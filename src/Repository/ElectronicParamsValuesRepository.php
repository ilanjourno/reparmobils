<?php

namespace App\Repository;

use App\Entity\ElectronicParamsValues;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ElectronicParamsValues|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElectronicParamsValues|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElectronicParamsValues[]    findAll()
 * @method ElectronicParamsValues[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElectronicParamsValuesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElectronicParamsValues::class);
    }

    // /**
    //  * @return ElectronicParamsValues[] Returns an array of ElectronicParamsValues objects
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
    public function findOneBySomeField($value): ?ElectronicParamsValues
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
