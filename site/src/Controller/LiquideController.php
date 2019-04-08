<?php

namespace App\Controller;

use App\Entity\Liquide;
use App\Form\LiquideType;
use App\Repository\LiquideRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/liquide")
 */
class LiquideController extends AbstractController
{
    /**
     * @param LiquideRepository $liquideRepository
     *
     * @return Response
     *
     * @Route("/", name="app_liquide_index")
     * @Method({"GET"})
     */
    public function index(LiquideRepository $liquideRepository)
    {
        return $this->render('liquide/index.html.twig', [
            'liquides' => $liquideRepository->findAll(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/create", name="app_liquide_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $form = $this->createForm(LiquideType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $liquide = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($liquide);
            $entityManager->flush();

            return $this->redirectToRoute('app_liquide_index');
        }

        return $this->render('liquide/edit.html.twig', [
            'liquide' => $form->createView(),
            'new' => true,
        ]);
    }

    /**
     * @param Request $request
     * @param Liquide $liquide
     *
     * @return Response
     *
     * @Route("/{id}/edit", name="app_liquide_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Liquide $liquide)
    {
        $form = $this->createForm(LiquideType::class, $liquide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_liquide_index');
        }

        return $this->render('liquide/edit.html.twig', [
            'liquide' => $form->createView(),
            'new' => false,
        ]);
    }

    /**
     * @param Request $request
     * @param Liquide $liquide
     *
     * @return Response
     *
     * @Route("/{id}/delete", name="app_liquide_delete")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, Liquide $liquide)
    {
        if ($this->isCsrfTokenValid('delete'.$liquide->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($liquide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_liquide_index');
    }
}
