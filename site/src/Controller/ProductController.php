<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commentaire;
use App\Form\CommentType;
use App\Form\ProduitType;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(ProduitRepository $repo)
    {
        return $this->render('product/index.html.twig', [
            'produits' => $repo->findAll()
        ]);
    }
    
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('product/home.html.twig');
    }
    
    /**
     * @Route("/product/new", name="create")
     * @Route("/product/{id}/edit", name="edit")
     */
    public function create(Produit $produit = null, Request $request, ObjectManager $manager)
    {
        if ( !$produit )
        {
            $produit = new Produit();
        }

        $form = $this->createForm(ProduitType::class, $produit);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() )
        {
            if ( !$produit->getId() )
            {
                $produit->setCreatedAt(new \DateTime());
            }

            $manager->persist($produit);
            $manager->flush();

            return $this->redirectToRoute('show', ['id' => $produit->getId()]);
        }

        return $this->render('product/create.html.twig', [
            'formProduit' => $form->createView(),
            'editMode' => $produit->getId() !== null
        ]);
    }
    
    /**
     * @Route("/product/{id}", name="show")
     */
    public function show(Produit $produit, Request $request, ObjectManager $manager)
    {
        $comment = new Commentaire();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() )
        {
            $comment->setCreatedAt(new \DateTime())
                    ->setProduit($produit);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('show', ['id' => $produit->getId()]);
        }

        return $this->render('product/show.html.twig', [
            'produit' => $produit,
            'commentForm' => $form->createView()
        ]);
    }
}