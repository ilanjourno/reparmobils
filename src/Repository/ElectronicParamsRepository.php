<?php

namespace App\Repository;

use App\Entity\ElectronicParams;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ElectronicParams|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElectronicParams|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElectronicParams[]    findAll()
 * @method ElectronicParams[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElectronicParamsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElectronicParams::class);
    }

    // /**
    //  * @return ElectronicParams[] Returns an array of ElectronicParams objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ElectronicParams
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
