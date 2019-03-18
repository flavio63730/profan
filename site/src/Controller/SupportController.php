<?php

namespace App\Controller;

use App\Entity\Support;
use App\Form\SupportType;
use App\Repository\SupportRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SupportController extends AbstractController
{
    /**
     * @param SupportRepository $supportRepository
     *
     * @return Response
     *
     * @Route("/support", name="app_support_index")
     * @Method({"GET"})
     */
    public function index(SupportRepository $supportRepository)
    {
        return $this->render('support/index.html.twig', [
            'supports' => $supportRepository->findAll(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/support/create", name="app_support_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $form = $this->createForm(SupportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $support = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($support);
            $entityManager->flush();

            return $this->redirectToRoute('app_support_index');
        }

        return $this->render('support/edit.html.twig', [
            'support' => $form->createView(),
            'new' => true,
        ]);
    }

    /**
     * @param Request $request
     * @param Support $support
     *
     * @return Response
     *
     * @Route("/{id}/edit", name="app_support_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Support $support)
    {
        $form = $this->createForm(SupportType::class, $support);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_support_index');
        }

        return $this->render('support/edit.html.twig', [
            'support' => $form->createView(),
            'new' => false,
        ]);
    }

    /**
     * @param Request $request
     * @param Support $support
     *
     * @return Response
     *
     * @Route("/{id}", name="app_support_delete")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, Support $support)
    {
        if ($this->isCsrfTokenValid('delete'.$support->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($support);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_support_index');
    }
}
