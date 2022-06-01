<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController {

    /**
     * @Route("/list", name="app_list")
     */
    public function list(WishRepository $wishRepository):Response {
        $wishs = $wishRepository->findAll();
        dump($wishs);
        $titrePage = "List";
        return $this->render("wish/list.html.twig", [
            'titre' => $titrePage,
            'wishs' => $wishs
        ]);
    }

    /**
     * @Route("/detail/{id}", name="app_detail", 
     * requirements={"id"="\d+"}, methods={"GET"})
     */
    public function detail(WishRepository $wishRepository, $id):Response {
        $wish = $wishRepository->findOneBy(['id' => $id]);
        $titrePage = "Detail";
        return $this->render("wish/detail.html.twig", [
            'titre' => $titrePage,
            'wish' => $wish
        ]);
    }
}