<?php

namespace App\Repository;

use App\Entity\TrackTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrackTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrackTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrackTag[]    findAll()
 * @method TrackTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrackTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrackTag::class);
    }

    public function findListForPagination($userId)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.user = :val')
            ->orWhere('t.isPrivate = 0')
            ->setParameter('val', $userId)
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ;
    }

    // /**
    //  * @return TrackTag[] Returns an array of TrackTag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrackTag
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
