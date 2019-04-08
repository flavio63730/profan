<?php

namespace App\Controller;

use App\Entity\Divers;
use App\Form\DiversType;
use App\Repository\DiversRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/divers")
 */
class DiversController extends AbstractController
{
    /**
     * @param DiversRepository $diversRepository
     * @param UserInterface    $user
     *
     * @return Response
     *
     * @Route("/", name="app_divers_index")
     * @Method({"GET"})
     */
    public function index(DiversRepository $diversRepository, UserInterface $user)
    {
        return $this->render('divers/index.html.twig', [
            'diverss' => $diversRepository->findAll(),
            'isAdmin' => in_array('ROLE_ADMIN', $user->getRoles()),

        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/create", name="app_divers_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $form = $this->createForm(DiversType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $divers = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($divers);
            $entityManager->flush();

            return $this->redirectToRoute('app_divers_index');
        }

        return $this->render('divers/edit.html.twig', [
            'divers' => $form->createView(),
            'new' => true,
        ]);
    }

    /**
     * @param Request $request
     * @param Divers $divers
     *
     * @return Response
     *
     * @Route("/{id}/edit", name="app_divers_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Divers $divers)
    {
        $form = $this->createForm(DiversType::class, $divers);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_divers_index');
        }

        return $this->render('divers/edit.html.twig', [
            'divers' => $form->createView(),
            'new' => false,
        ]);
    }

    /**
     * @param Request $request
     * @param Divers $divers
     *
     * @return Response
     *
     * @Route("/{id}/delete", name="app_divers_delete")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, Divers $divers)
    {
        if ($this->isCsrfTokenValid('delete'.$divers->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($divers);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_divers_index');
    }
}
