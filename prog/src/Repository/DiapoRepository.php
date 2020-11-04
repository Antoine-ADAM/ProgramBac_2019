<?php

namespace App\Repository;

use App\Entity\Diapo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Diapo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Diapo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Diapo[]    findAll()
 * @method Diapo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiapoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Diapo::class);
    }

    // /**
    //  * @return Diapo[] Returns an array of Diapo objects
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
    public function findOneBySomeField($value): ?Diapo
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
