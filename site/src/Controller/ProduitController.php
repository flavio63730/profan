<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Entity\Historique;
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
     * @param Request       $request
     * @param UserInterface $user
     *
     * @throws \Exception
     *
     * @return Response
     *
     * @Route("/create", name="app_produit_new")
     * @Method({"GET", "POST"})
     */
    public function create(Request $request, UserInterface $user)
    {
        $form = $this->createForm(ProduitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();

            $historique = new Historique();
            $historique->setDate(new \DateTime());
            $historique->setAction("Création");
            $historique->setQuantite($produit->getQuantite());
            $historique->setUser($user);
            $historique->setProduit($produit);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($produit);
            $entityManager->persist($historique);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $form->createView(),
            'new' => true,
        ]);
    }

    /**
     * @param Request       $request
     * @param int           $id
     * @param UserInterface $user
     *
     * @return Response
     *
     * @Route("/{id}/edit", name="app_produit_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, int $id, UserInterface $user)
    {        
        $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->find($id);
        $old_quantity = $produit->getQuantite();

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $quantity_changed = $produit->getQuantite() - $old_quantity;
            if ( $quantity_changed ) {
                $historique = new Historique();
                $historique->setDate(new \DateTime())
                           ->setAction("Modification")
                           ->setQuantite($quantity_changed)
                           ->setUser($user)
                           ->setProduit($produit);

                $entityManager->persist($historique);
            }

            $entityManager->flush();

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
