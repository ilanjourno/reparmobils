<?php

namespace App\Repository;

use App\Entity\NewsletterEmails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsletterEmails|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterEmails|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterEmails[]    findAll()
 * @method NewsletterEmails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterEmailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterEmails::class);
    }

    // /**
    //  * @return NewsletterEmails[] Returns an array of NewsletterEmails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewsletterEmails
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
