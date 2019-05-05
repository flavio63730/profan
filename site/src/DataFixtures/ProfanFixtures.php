<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfanFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setLogin('admin');
        $admin->setEmail('admin@profan.fr');
        $admin->setPassword($this->encoder->encodePassword($admin, 'admin'));
        $admin->setRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);

        for ($i = 0; $i < 20; $i++) {
            $produit = new Produit();
            $produit->setReference('produit '.$i);
            $produit->setDesignation(str_shuffle('abcdefghi'));
            $produit->setQuantite(mt_rand(10, 100));
            $manager->persist($produit);
        }
    
        $manager->flush();
    }
}