<?php

namespace App\Controller;

use App\Repository\HistoriqueRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/")
 */
class ProfanController extends AbstractController
{
    /**
     * @param HistoriqueRepository $historiqueRepository
     * @param ProduitRepository    $produitRepository
     *
     * @return Response
     *
     * @Route("/", name="home")
     * @Method({"GET"})
     */
    public function home(HistoriqueRepository $historiqueRepository, ProduitRepository $produitRepository)
    {
        return $this->render('home.html.twig', [
            'historiques' => $historiqueRepository->findAll(),
            'produits' => $produitRepository->findAll(),
        ]);
    }

    /**
     * @return Response
     *
     * @Route("/tutoriel", name="app_tutoriel_index")
     * @Method({"GET"})
     */
    public function tutoriel()
    {
        return $this->render('tutoriel.html.twig');
    }
}