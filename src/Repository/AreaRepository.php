<?php

namespace App\Repository;

use App\Entity\Area;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Area|null find($id, $lockMode = null, $lockVersion = null)
 * @method Area|null findOneBy(array $criteria, array $orderBy = null)
 * @method Area[]    findAll()
 * @method Area[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AreaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Area::class);
    }

   

    /**
     * Find all Areas order by name ASC
     * and retrieve only associate incoming walks
     * @return Area[] Returns an array of Area objects 
     */
    public function findAllWithWalk()
    {
        return $this->createQueryBuilder('a')
            ->leftjoin('a.walks', 'w')
            ->addSelect('w')
            ->andWhere('w.status = :status OR w.status IS NULL')
            ->setParameter('status', 1)
            ->addOrderBy('a.name' ,'ASC')
            ->addOrderBy('w.date' ,'ASC')
            ->getQuery()
            ->getResult();
    }

}
