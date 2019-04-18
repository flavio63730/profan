<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\User;
use App\Form\ItemType;
use App\Entity\ItemSearch;
use App\Form\ItemSearchType;
use App\Repository\ItemRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/item")
 */
class ItemController extends AbstractController
{
    /**
     * @param ItemRepository $itemRepository
     * @param Request        $request
     * @param Userinterface  $user
     *
     * @return Response  
     *
     * @Route("/", name="app_item_index")
     * @Method({"GET"})
     */
    public function index(ItemRepository $itemRepository, Request $request, UserInterface $user)
    {
        $items = $itemRepository->findAll();

        $form = $this->createForm(ItemSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            $values = [
                'reference' => strtoupper($search->getReference()),
                'designation' => strtoupper($search->getDesignation()),
                'emplacement' => strtoupper($search->getEmplacement()),
                'quantite' => strtoupper($search->getQuantite()),
            ];
            for ($i=0; $i < sizeof($items); ++$i ) {
                if (   ($values['reference'] && strpos(strtoupper($items[$i]->getReference()), $values['reference']) === false)
                    || ($values['designation'] && strpos(strtoupper($items[$i]->getDesignation()), $values['designation']) === false)
                    || ($values['emplacement'] && strpos(strtoupper($items[$i]->getEmplacement()), $values['emplacement']) === false)
                    || ($values['quantite'] && strpos(strtoupper($items[$i]->getQuantite()), $values['quantite']) === false) )
                    unset($items[$i]);
            }
        }

        return $this->render('item/index.html.twig', [
            'items' => $items,
            'form' => $form->createView(),
            'isAdmin' => in_array('ROLE_ADMIN', $user->getRoles()),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/create", name="app_item_new")
     * @Method({"GET", "POST"})
     */
    public function create(Request $request)
    {
        $form = $this->createForm(ItemType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($item);
            $entityManager->flush();

            return $this->redirectToRoute('app_item_index');
        }

        return $this->render('item/edit.html.twig', [
            'item' => $form->createView(),
            'new' => true,
        ]);
    }

    /**
     * @param Request $request
     * @param Item    $item
     *
     * @return Response
     *
     * @Route("/{id}/edit", name="app_item_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Item $item)
    {
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_item_index');
        }

        return $this->render('item/edit.html.twig', [
            'item' => $form->createView(),
            'new' => false,
        ]);
    }

    /**
     * @param Request $request
     * @param Item    $item
     *
     * @return Response
     *
     * @Route("/{id}/delete", name="app_item_delete")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, Item $item)
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($item);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_item_index');
    }
}
