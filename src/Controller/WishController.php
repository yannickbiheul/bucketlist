<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WishController extends AbstractController
{

    /**
     * @Route("/list", name="app_list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        $wishs = $wishRepository->findAll();
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
    public function detail(WishRepository $wishRepository, $id): Response
    {
        $wish = $wishRepository->find($id);
        $titrePage = "Detail";
        return $this->render("wish/detail.html.twig", [
            'titre' => $titrePage,
            'id' => $id
        ]);
    }

    /**
     * @Route("/create", name="app_create")
     */
    public function create(Request $request, WishRepository $wishRepo)
    {
        if ($request->request->get('title') != null) {
            $wish = new Wish();
            $wish->setTitle($request->request->get('title'));
            $wish->setDescription($request->request->get('description'));
            $wish->setAuthor($request->request->get('author'));
            $wishRepo->add($wish, true);

            return $this->redirectToRoute('app_list');
        }


        $titrePage = "Create Wish";
        return $this->render("wish/create.html.twig", [
            'titre' => $titrePage,
        ]);
    }
}
