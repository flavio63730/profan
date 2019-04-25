<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Form\ProduitType;
use App\Form\ProduitSearchType;
use App\Repository\ProduitRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @param ProduitRepository $produitRepository
     * @param Request           $request
     * @param UserInterface     $user
     *
     * @return Response
     *
     * @Route("/", name="app_produit_index")
     * @Method({"GET", "POST"})
     */
    public function index(ProduitRepository $produitRepository, Request $request, UserInterface $user)
    {
        $produits = $produitRepository->findAll();

        $form = $this->createForm(ProduitSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            $values = [
                'reference' => strtoupper($search->getReference()),
                'designation' => strtoupper($search->getDesignation()),
                'quantite' => $search->getQuantite(),
            ];
            for ($i=0; $i < sizeof($produits); ++$i ) {
                if (   ($values['reference']   && strpos(strtoupper($produits[$i]->getReference()),   $values['reference'])   === false )
                    || ($values['designation'] && strpos(strtoupper($produits[$i]->getDesignation()), $values['designation']) === false )
                    || ($values['quantite'] && $produits[$i]->getQuantite() >= $values['quantite'] === false) )
                    unset($produits[$i]);
            }
        }

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'form' => $form->createView(),
            'isAdmin' => in_array('ROLE_ADMIN', $user->getRoles()),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/create", name="app_produit_new")
     * @Method({"GET", "POST"})
     */
    public function create(Request $request)
    {
        $form = $this->createForm(ProduitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $support = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($support);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $form->createView(),
            'new' => true,
        ]);
    }

    /**
     * @param Request $request
     * @param Produit $produit
     *
     * @return Response
     *
     * @Route("/{id}/edit", name="app_produit_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Produit $produit)
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $form->createView(),
            'new' => false,
        ]);
    }

    /**
     * @param Request $request
     * @param Produit $produit
     *
     * @return Response
     *
     * @Route("/{id}/delete", name="app_produit_delete")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, Produit $produit)
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_index');
    }
}
