<?php

namespace App\Repository;

use App\Entity\Walk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Walk|null find($id, $lockMode = null, $lockVersion = null)
 * @method Walk|null findOneBy(array $criteria, array $orderBy = null)
 * @method Walk[]    findAll()
 * @method Walk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Walk::class);
    }

    /**
     * Find the last 5 walks
     */
    public function findLast()
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.createdAt', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
