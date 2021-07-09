<?php

namespace App\Repository;

use App\Entity\Kkk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Kkk|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kkk|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kkk[]    findAll()
 * @method Kkk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KkkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kkk::class);
    }

    // /**
    //  * @return Kkk[] Returns an array of Kkk objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Kkk
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
