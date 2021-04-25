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
            ->orderBy('w.createdAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find All Query
     */
    public function findAllQuery()
    {
        return $this->createQueryBuilder('w')
            ->innerjoin('w.creator', 'u')
            ->addSelect('u')
            ->orderBy('w.createdAt', 'DESC')
            ->getQuery();
    }

    /**
     * Find expired and status "incoming" walk's
     */
    public function findForCronJob()
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.status = :status AND w.date < :date')
            ->setParameters(array('date' => new \DateTime, 'status' => 1))
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all walks by search
     */
    public function findAllWalksBySearchQuery($search = null)
    {
        return $this->createQueryBuilder('w')
            ->innerjoin('w.creator', 'u')
            ->addSelect('u')
            ->where('(w.title LIKE :title) OR
                (w.description LIKE :desc) OR
                (u.nickname LIKE :nickname)')
            ->setParameters(array(
                'title' => '%' . $search . '%',
                'desc' => '%' . $search . '%',
                'nickname' => '%' . $search . '%',
            ))
            ->orderBy('w.createdAt', 'DESC')
            ->getQuery();
    }
}
