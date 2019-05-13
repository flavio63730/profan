<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/scan")
 */
class ScanController extends AbstractController
{
    /**
     * @Route("/", name="app_scan_index")
     */
    public function index()
    {
        return $this->render('scan/index.html.twig');
    }
    /**
     * @param ProduitRepository $produitRepository
     * @param UserInterface     $user
     * @param string            $reference
     *
     * @Route("/{reference}", name="app_scan_search")
     * @Method({"GET"})
     */
    public function search(ProduitRepository $produitRepository, UserInterface $user, string $reference)
    {
        $produits = $produitRepository->findAll();
        $id = 0;
        foreach ($produits as $produit) {
            if ( $produit->getReference() == $reference ) {
                $id = $produit->getId();
                break;
            }
        }

        if ( $id )
            $page = $this->redirectToRoute('app_produit_edit', ['id' => $id]);
        else if ( in_array('ROLE_ADMIN', $user->getRoles()) )
            $page = $this->redirectToRoute('app_produit_new', ['reference' => $reference]);
        else {
            $page = $this->redirectToRoute('app_produit_index');
            $this->addFlash('danger', 'Produit inexistant.');
        }
        
        return $page;
    }
}
