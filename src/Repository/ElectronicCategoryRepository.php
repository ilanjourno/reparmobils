<?php

namespace App\Repository;

use App\Entity\ElectronicCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ElectronicCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElectronicCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElectronicCategory[]    findAll()
 * @method ElectronicCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElectronicCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductCategory::class);
    }

    // /**
    //  * @return ElectronicCategory[] Returns an array of ElectronicCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductCategory
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
