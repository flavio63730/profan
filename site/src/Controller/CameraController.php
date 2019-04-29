<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use PHPZxing\PHPZxingDecoder;


class CameraController extends AbstractController
{
    /**
     * @Route("/camera", name="camera")
     */
    public function index()
    {
        return $this->render('camera/index.html.twig', [
            'controller_name' => 'CameraController',
        ]);
    }
/**
    public function PhpZxing(){
        $decoder        = new PHPZxingDecoder();
        $data           = $decoder->decode('#');
        if($data->isFound()) {
            $data->getImageValue();
            $data->getFormat();
            $data->getType();
        }
        return $data;
    }*/
}
