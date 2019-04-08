<?php

namespace App\Controller;

use App\Entity\Support;
use App\Entity\User;
use App\Form\SupportType;
use App\Form\SupportSearch;
use App\Form\SupportSearchType;
use App\Repository\SupportRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/support")
 */
class SupportController extends AbstractController
{
    /**
     * @param SupportRepository $supportRepository
     * @param Request           $request
     * @param Userinterface     $user
     *
     * @return Response
     *
     * @Route("/", name="app_support_index")
     * @Method({"GET"})
     */
    public function index(SupportRepository $supportRepository, Request $request, UserInterface $user)
    {
        $supports = $supportRepository->findAll();

        $form = $this->createForm(SupportSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            $values = [
                'nom' => strtoupper($search->getNom()),
                'quantite' => $search->getQuantite(),
                'couleur' => strtoupper($search->getCouleur()),
                'format' => strtoupper($search->getFormat()),
                'grammage' => $search->getGrammage(),
                'materiel' => strtoupper($search->getMateriel()),
                'type' => strtoupper($search->getType()),
            ];
            for ($i=0; $i < sizeof($supports); ++$i ) {
                if (   ($values['nom'] && strpos(strtoupper($supports[$i]->getNom()), $values['nom']) === false )
                    || ($values['quantite'] && $supports[$i]->getQuantite() > $values['quantite'] === false)
                    || ($values['couleur'] && strpos(strtoupper($supports[$i]->getCouleur()), $values['couleur']) === false)
                    || ($values['format'] && strpos(strtoupper($supports[$i]->getFormat()), $values['format']) === false)
                    || ($values['grammage'] && $supports[$i]->getGrammage() != $values['grammage'])
                    || ($values['materiel'] && strpos(strtoupper($supports[$i]->getMateriel()), $values['materiel']) === false)
                    || ($values['type'] && strpos(strtoupper($supports[$i]->getType()), $values['type']) === false) )
                    unset($supports[$i]);
            }
        }

        return $this->render('support/index.html.twig', [
            'supports' => $supports,
            'form' => $form->createView(),
            'isAdmin' => in_array('ROLE_ADMIN', $user->getRoles()),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/create", name="app_support_new")
     * @Method({"GET", "POST"})
     */
    public function create(Request $request)
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
     * @Route("/{id}/delete", name="app_support_delete")
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
