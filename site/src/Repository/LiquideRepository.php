<?php

namespace App\Repository;

use App\Entity\Liquide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Liquide|null find($id, $lockMode = null, $lockVersion = null)
 * @method Liquide|null findOneBy(array $criteria, array $orderBy = null)
 * @method Liquide[]    findAll()
 * @method Liquide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LiquideRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Liquide::class);
    }

    // /**
    //  * @return Liquide[] Returns an array of Liquide objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Liquide
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
