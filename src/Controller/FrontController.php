<?php

namespace App\Controller;

use App\Controller\Traits\Likes;
use App\Entity\Comment;
use App\Repository\VideoRepository;
use App\Utils\VideoForNoValidSubscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Video;
use App\Utils\CategoryTreeFrontPage;

class FrontController extends AbstractController
{
    use Likes;
    /**
     * @Route("/", name="main_page")
     */
    public function index(): Response
    {
        return $this->render('front/index.html.twig');
    }

    /**
     * @Route("/video-list/category/{categoryname},{id}/{page}", defaults={"page": "1"}, name="video_list")
     */
    public function videoList($id, $page, CategoryTreeFrontPage $categories, Request $request, VideoForNoValidSubscription $video_no_members): Response
    {
        $categories->getCategoryListAndParent($id);
        $ids = $categories->getChildIds($id);
        array_push($ids, $id);
        $videos = $this->getDoctrine()->getRepository(Video::class)->findByChildIds($ids, $page, $request->get('sortby'));
        return $this->render('front/video_list.html.twig', ['subcategories' => $categories, 'videos' => $videos, 'video_no_members'=>$video_no_members]);
    }

    /**
     * @Route("/video-details/{video}", name="video_details")
     */
    public function videoDetails(VideoRepository $repo, $video, VideoForNoValidSubscription $video_no_members): Response
    {
        dump($repo->videoDetails($video));
        return $this->render('front/video_details.html.twig',
            [
                'video' => $repo->videoDetails($video), 'video_no_members'=>$video_no_members
            ]);
    }

    /**
     * @Route ("/search-results/{page}", name="search_results", methods={"GET"}, defaults={"page":"1"})
     */
    public function searchResult($page, Request $request, VideoForNoValidSubscription $video_no_members): Response
    {
        $videos = null;
        if ($query = $request->get('query')) {
            $videos = $this->getDoctrine()
                ->getRepository(Video::class)
                ->findByTitle($query, $page, $request->get('sortby'));
            if (!$videos->getItems()) $videos = null;

        }
        return $this->render("front/search_results.html.twig", [
            'videos' => $videos,
            'query' => $query,
            'video_no_members'=>$video_no_members
        ]);
    }

    /**
     * @Route("/pricing", name="pricing")
     */
    public function pricing(): Response
    {
        return $this->render('front/pricing.html.twig');
    }

    /**
     * @Route("/payment", name="payment")
     */
    public function payment(): Response
    {
        return $this->render('front/payment.html.twig');
    }

    public function getMainCategories(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findBy(['parent' => null], ['name' => 'ASC']);
        return $this->render('front/_main_categories.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/new-comment/{video}", methods={"POST"}, name="new_comment")
     */
    public function newComment(Video $video, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        if (!empty(trim($request->request->get('comment')))) {
            $comment = new Comment();
            $comment->setContent(trim($request->request->get('comment')));
            $comment->setUser($this->getUser());
            $comment->setVideo($video);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
        }
        return $this->redirectToRoute('video_details', ['video'=> $video->getId()]);
    }

    /**
     * @Route("/video-list/{video}/like", methods={"POST"}, name="like_video")
     * @Route("/video-list/{video}/dislike", methods={"POST"}, name="dislike_video")
     * @Route("/video-list/{video}/undo-like", methods={"POST"}, name="undo_like_video")
     * @Route("/video-list/{video}/undo-dislike", methods={"POST"}, name="undo_dislike_video")
     */
    public function toggleLikesAjax(Video $video, Request $request){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        switch ($request->get('_route')){
            case 'like_video':
                $result = $this->likeVideo($video);
                break;
            case 'dislike_video':
                $result = $this->dislikeVideo($video);
                break;
            case 'undo_like_video':
                $result = $this->undoLikeVideo($video);
                break;
            case 'undo_dislike_video':
                $result = $this->undoDislikeVideo($video);
                break;
        }
        return $this->json(['action'=> $result, 'id'=> $video->getId()]);
    }
}
