<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="app_home")
     */
    public function index():Response {
        $titrePage = "Bucket List";
        return $this->render("home.html.twig", [
            'titre' => $titrePage
        ]);
    }

    /**
     * @Route("/about", name="app_about")
     */
    public function aboutUs():Response {
        $titrePage = "About Us";
        return $this->render("main/about-us.html.twig", [
            'titre' => $titrePage
        ]);
    }

    /**
     * @Route("/legal-stuff", name="app_legal-stuff")
     */
    public function legalStuff():Response {
        $titrePage = "legal Stuff";
        return $this->render("main/legal-stuff.html.twig", [
            'titre' => $titrePage
        ]);
    }

}