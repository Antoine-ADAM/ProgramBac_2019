<?php

namespace App\Repository;

use App\Entity\LiaisonProgram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LiaisonProgram|null find($id, $lockMode = null, $lockVersion = null)
 * @method LiaisonProgram|null findOneBy(array $criteria, array $orderBy = null)
 * @method LiaisonProgram[]    findAll()
 * @method LiaisonProgram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LiaisonProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LiaisonProgram::class);
    }

    // /**
    //  * @return LiaisonProgram[] Returns an array of LiaisonProgram objects
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
    public function findOneBySomeField($value): ?LiaisonProgram
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
