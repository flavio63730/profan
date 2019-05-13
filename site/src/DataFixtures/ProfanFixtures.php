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
        $products = [
            ['I500A', 'Gants Vynil poudré S'],
            ['I500B', 'Gants Vynil poudré M'],
            ['I500C', 'Gants Vynil poudré L'],
            ['I500D', 'Gants Vynil poudré XL'],
            ['I501A', 'Gants Latex non-poudrés S'],
            ['I501B', 'Gants Latex non-poudrés M'],
            ['I501C', 'Gants Latex non-poudrés L'],
            ['I501D', 'Gants Latex non-poudrés XL'],
            ['I502A', 'Doigtiers roulés latex S'],
            ['I502B', 'Doigtiers roulés latex M'],
            ['I502C', 'Doigtiers roulés latex L'],
            ['I502S', 'Doigtiers roulés latex XL'],
            ['I600C', 'Varn fountclean (x10l)'],
            ['I600D', 'Solution finition PaE LC-V (x20l)'],
            ['I600E', 'Eau déminéralisée (x10l)'],
            ['I600G', 'JJ PERFECT WASH 25l'],
            ['I600H', 'VARN PROTECT FOUNT 20l'],
            ['I602A', 'Solvant HLM3556 1L'],
            ['I603A', 'Wash-FS'],
            ['I603B', 'Dégraissant Solstar FS'],
            ['I702A', 'Colle Planatol BB supérieur'],
            ['I800C', 'Oeillets laiton nickelé ⌀ 11.6'],
            ['I800D', 'Oeillets laiton nickelé ⌀ 16.7'],
            ['I230A', 'Encre Inkredible Resista Rouge (2.5kg)'],
            ['I230B', 'Encre Inkredible Resista Jaune (2.5kg)'],
            ['I231A', 'Encre Alchemy Silver'],
            ['I240A', 'Encre UV Cyan 1200 bidon1L'],
            ['I240B', 'Encre UV Magenta 1200 bidon1L'],
            ['I240C', 'Encre UV Jaune bidon1L'],
            ['I240D', 'Encre UV Noir bidon1L'],
            ['I240E', 'Encre UV Blanc Ecowhite H5760 1L'],
            ['I241A', 'Vernis Ultrajet'],
            ['I241B', 'Vernis Acrylique mat 25kg'],
            ['I300A', 'Plaque Fuji PRO-V 400 x 510mm'],
            ['I300B', 'Plaque Fuji PRO-V 605 x 745mm'],
            ['I300C', 'Plaque Fuji PRO-V 635 x 760mm'],
            ['I310A', 'Plaque PP Alvéolé 3.5 x 2000 x 1200'],
            ['I311A', 'Plaque PP Blanc 3 x 3000 x 1500'],
            ['I320A', 'Plaque Simopor blanc digital 5 x 2440 x 1220'],
            ['I321A', 'Plaque Simopor noir digital 5 x 3050 x 1530'],
            ['I321B', 'Plaque Simopor noir digital 10 x3050 x 2050'],
            ['I400A', 'Pâte lavante "encre & peinture"'],
            ['I401A', 'Creme nettoyante orange Bidon 4kg'],
            ['I402A', 'Esponge n°4'],
            ['I403A', 'Lingettes ControlWipes 229x229'],
            ['I403B', 'Chiffons sans peluches x150'],
            ['I404A', ' Filtre bac de mouillage GA250'],
            ['I201C', 'Encre Pantone Bleu Primaire'],
            ['I201D', 'Encre Pantone Bleu Process 1kg'],
            ['I202A', 'Encre Pantone Rouge 032'],
            ['I202B', 'Encre Pantone Rouge Rubine 1kg'],
            ['I202C', 'Encre Pantone Rouge Fer'],
            ['I203A', 'Encre Pantone Jaune Q21'],
            ['I204A', 'Encre Pantone Orange'],
            ['I205A', 'Encre Pantone Vert C'],
            ['I205B', 'Encre Pantone Vert'],
            ['I206A', 'Encre Pantone Violet'],
            ['I206B', 'Encre Pantone Violet Stylo'],
            ['I206C', 'Encre Pantone Violet C'],
            ['I206D', 'Encre Pantone Violet Pourpre'],
            ['I207A', 'Encre Pantone Rose'],
            ['I208A', 'Encre Pantone Blanc transparent 1kg'],
            ['I210A', 'Encre Quadri Jaune 1kg'],
            ['I210B', 'Encre Quadri Cyan 1kg'],
            ['I210C', 'Encre Quadri Rouge 1kg'],
            ['I210D', 'Encre Quadri Noir 1kg'],
            ['I220A', 'Encre Inkdredible Resista Magenta (1kg)'],
            ['I220B', 'Encre Inkdredible Resista Cyan (1kg)'],
            ['I220C', 'Encre Inkdredible Trans-white (1kg)'],
            ['I220D', 'Encre Inkdredible Resista Yellow (1kg)'],
            ['I221A', 'Encre Inkdredible Blanc (1kg)'],
            ['I127E', 'Imagine satin 300g/m² 32x45'],
            ['I128J', 'Imagine satin 350g/m² 52x72'],
            ['I128Q', 'Imagine satin 350g/m² 72x102'],
            ['I142E', 'Imagine brillant 115g/m² 32x45'],
            ['I142J', 'Imagine brillant 115g/m² 52x72'],
            ['I144E', 'Imagine brillant 150g/m² 32x45'],
            ['I145E', 'Imagine brillant 200g/m² 32x45'],
            ['I146E', 'Imagine brillant 250g/m² 32x45'],
            ['I146J', 'Imagine brillant 250g/m² 52x72'],
            ['I147E', 'Imagine brillant 300g/m² 32x45'],
            ['I148E', 'Couché brillant 350g/m² 32x45'],
            ['I148J', 'Imagine brillant 350g/m² 52x72'],
            ['I160E', 'Inaset Plus Digital 90g/m² 32x45'],
            ['I160G', 'Extra Strong Laser Jet 80g 45x64'],
            ['I166G', 'Trophé "rose" 240g 45x64'],
            ['I170A', 'Papier Traceur satin 150g 76mx1.6m'],
            ['I170B', 'Papier Traceur 90g/m² Espon stylus pro 7500'],
            ['I170C', 'Papier Traceur Fuji IPP-SG 230g 0.610x45m'],
            ['I171A', 'Polyester Cristal 20mx1.37m'],
            ['I172A', 'Bache blanc 440g 50mx1.37m'],
            ['I173A', 'Film pelliculage mat Laize 445x3000'],
            ['I200A', 'Encre Pantone Noire 1kg'],
            ['I201A', 'Encre Pantone Bleu 072C'],
            ['I201B', 'Encre Pantone Bleu Reflex 1kg'],
            ['I100J', 'Offset 80gr/m² 52x72'],
            ['I100K', 'Offset 90gr/m² 52x72'],
            ['I102E', 'Couché mat 115g/m² 32x45'],
            ['I102G', 'Couché mat périgord 115g/m² 45x64'],
            ['I102J', 'Couché mat 115g/m² 52x72'],
            ['I103J', 'Couché mat périgord 115g/m² 52x72'],
            ['I104E', 'Couché mat 150g/m² 32x45'],
            ['I106E', 'Couché mat 250g/m² 32x45'],
            ['I107G', 'Couché mat périgord 300g/m² 45x64'],
            ['I107H', 'Couché mat périgord 350g/m² 45x64'],
            ['I107P', 'Couché mat périgord 300g/m² 70x102'],
            ['I108E', 'Couché mat 350g/m² 32x45'],
            ['I108J', 'Couché mat 350g/m² 52x72'],
            ['I115J', 'Couché demi-mat 170g 52x72'],
            ['I115K', 'Condat Silk 200g 58x78'],
            ['I122E', 'Imagine satin 115g/m² 32x45'],
            ['I122J', 'Imagine satin 115g/m² 52x72'],
            ['I123G', 'Imagine satin 130g/m² 45x64'],
            ['I124E', 'Imagine satin 150g/m² 32x45'],
            ['I124Q', 'Imagine satin 150g/m² 72x102'],
            ['I125E', 'Imagine satin 170g/m² 32x45'],
            ['I125J', 'Imagine satin 170g/m² 52x72'],
            ['I126E', 'Imagine satin 250g/m² 32x45'],
            ['I126J', 'Imagine satin 250g/m² 52x72'],
        ];


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