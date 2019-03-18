<?php

namespace App\Repository;

use App\Entity\Divers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Divers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Divers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Divers[]    findAll()
 * @method Divers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiversRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Divers::class);
    }

    // /**
    //  * @return Divers[] Returns an array of Divers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Divers
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
