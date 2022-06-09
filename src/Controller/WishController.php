<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wish")
 */
class WishController extends AbstractController
{
    /**
     * @Route("/", name="app_wish_index", methods={"GET"})
     */
    public function index(WishRepository $wishRepository): Response
    {
        return $this->render('wish/index.html.twig', [
            'wishes' => $wishRepository->showAll(),
        ]);
    }

    /**
     * @isGranted("ROLE_USER")
     * @Route("/new", name="app_wish_new", methods={"GET", "POST"})
     */
    public function new(Request $request, WishRepository $wishRepository): Response
    {

        if (!$this->isGranted("ROLE_USER")) {
            return $this->redirectToRoute("app_login");
        }

        $wish = new Wish();
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wish->setIsPublished("true");
            $wish->setDateCreated(new \DateTime());
            $wishRepository->add($wish, true);

            return $this->redirectToRoute('app_wish_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wish/new.html.twig', [
            'wish' => $wish,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_wish_show", methods={"GET"})
     */
    public function show(Wish $wish): Response
    {
        return $this->render('wish/show.html.twig', [
            'wish' => $wish,
        ]);
    }

    /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/{id}/edit", name="app_wish_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Wish $wish, WishRepository $wishRepository): Response
    {

        if (!$this->isGranted("ROLE_ADMIN")) {
            return $this->redirectToRoute("app_wish_index");
        }

        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wishRepository->add($wish, true);

            return $this->redirectToRoute('app_wish_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wish/edit.html.twig', [
            'wish' => $wish,
            'form' => $form,
        ]);
    }

    /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/{id}", name="app_wish_delete", methods={"POST"})
     */
    public function delete(Request $request, Wish $wish, WishRepository $wishRepository): Response
    {

        if (!$this->isGranted("ROLE_ADMIN")) {
            return $this->redirectToRoute("app_wish_index");
        }

        if ($this->isCsrfTokenValid('delete'.$wish->getId(), $request->request->get('_token'))) {
            $wishRepository->remove($wish, true);
        }

        return $this->redirectToRoute('app_wish_index', [], Response::HTTP_SEE_OTHER);
    }
}
