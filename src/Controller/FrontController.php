<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Video;
use App\Utils\CategoryTreeFrontPage;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class FrontController extends AbstractController
{
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
    public function videoList($id, $page, CategoryTreeFrontPage $categories, Request $request): Response
    {
        $categories->getCategoryListAndParent($id);
        $ids = $categories->getChildIds($id);
        array_push($ids, $id);
        $videos = $this->getDoctrine()->getRepository(Video::class)->findByChildIds($ids, $page, $request->get('sortby'));
        return $this->render('front/video_list.html.twig', ['subcategories' => $categories, 'videos' => $videos]);
    }

    /**
     * @Route("/video-details/{video}", name="video_details")
     */
    public function videoDetails(VideoRepository $repo, $video): Response
    {
        dump($repo->videoDetails($video));
        return $this->render('front/video_details.html.twig',
            [
                'video' => $repo->videoDetails($video)
            ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $helper): Response
    {
        return $this->render('front/login.html.twig', ['error' => $helper->getLastAuthenticationError()]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): Response
    {
        return new \Exception();
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(): Response
    {
        return $this->render('front/register.html.twig');
    }

    /**
     * @Route ("/search-results/{page}", name="search_results", methods={"GET"}, defaults={"page":"1"})
     */
    public function searchResult($page, Request $request): Response
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
            'query' => $query
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
}
