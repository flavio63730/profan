<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ScanController extends AbstractController
{
    /**
     * @Route("/scan", name="scan")
     */
    public function index()
    {
        return $this->render('scan/index.html.twig', [
            'controller_name' => 'ScanController',
        ]);
    }
}
