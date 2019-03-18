<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProfanFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /*
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 1; $i < 4; $i++) 
        {
            $category = new Categorie();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());

            $manager->persist($category);
            
            for ($j = 1; $j < mt_rand(4, 6); $j++) 
            {
                $product = new Produit();

                $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                $product->setTitle($faker->sentence())
                        ->setDescription($content)
                        ->setImage($faker->imageUrl())
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setCategorie($category);

                $manager->persist($product);

                for ($k = 1; $k < mt_rand(4, 10); $k++) 
                {
                    $comment = new Commentaire();
                    
                    $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';

                    $days = (new \DateTime())->diff($product->getCreatedAt())->days;

                    $comment->setAuteur($faker->name)
                            ->setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween('-'.$days.' days'))
                            ->setProduit($product);

                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
        */
    }
}