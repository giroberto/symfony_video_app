<?php


namespace App\Controller\Admin\SuperAdmin;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/su")
 */
class SuperAdminController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @Route("/upload-video", name="upload_video")
     */
    public function uploadVideo(){
        return $this->render('admin/upload_video.html.twig');
    }

    /**
     * @Route("/users", name="users")
     */
    public function users(){
        return $this->render('admin/users.html.twig');
    }

}