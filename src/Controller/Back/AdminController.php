<?php


namespace App\Controller\Back;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController.php
 *
 * @author Kevin Tourret
 */
class AdminController extends AbstractController
{

    #[Route('/admin', name: 'app_admin_home')]
    public function home(): Response {
        return $this->render('back/pages/home.html.twig', []);
    }

}
