<?php

namespace App\Controller;

use DateTime;
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
        $titrePage = $wish->getTitle();
        return $this->render("wish/detail.html.twig", [
            'titre' => $titrePage,
            'wish' => $wish
        ]);
    }

    /**
     * @Route("/create", name="app_create")
     */
    public function create(Request $request, WishRepository $wishRepo)
    {
        if ($request->request->get('title') != null) {
            $dateObject = new DateTime();
            $date = $dateObject->format('Y-m-d H:i:s');
            $wish = new Wish();
            $wish->setTitle(htmlentities($request->request->get('title')));
            $wish->setDescription(htmlentities($request->request->get('description')));
            $wish->setAuthor(htmlentities($request->request->get('author')));
            $wish->setIsPublished(true);
            $wish->setDateCreated(new \DateTime());
            $wishRepo->add($wish, true);

            return $this->redirectToRoute('app_list');
        }


        $titrePage = "Create Wish";
        return $this->render("wish/create.html.twig", [
            'titre' => $titrePage,
        ]);
    }

    /**
     * @Route("/form-update/{id}", name="app_form_update")
     */
    public function formUpdate(WishRepository $wishRepo, $id) {
        $wish = $wishRepo->find($id);
        $titrePage = "Modifier " . $wish->getTitle();
        return $this->render("wish/update.html.twig", [
            'titre' => $titrePage,
            'wish' => $wish
        ]);
    }

    /**
     * @Route("/update/{id}", name="app_update")
     */
    public function update(Request $request, WishRepository $wishRepo, $id) {
        $title = htmlentities($request->request->get('title'));
        $description = htmlentities($request->request->get('description'));
        $author = htmlentities($request->request->get('author'));
        $wishRepo->updateById($id, $title, $description, $author);
        return $this->redirect("/detail/$id");
    }

    /**
     * @Route("/delete/{id}", name="app_delete")
     */
    public function delete(WishRepository $wishRepo, $id) {
        $wishRepo->delete($id);
        return $this->redirectToRoute("app_list");
    }
}
