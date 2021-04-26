<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /**
     * Find the last 5 tags
     * 
     * @return Tag[] Returns an array of Tag objects
     */
    public function findLast()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Query: Find All tags
     * 
     * @return \Doctrine\ORM\Query
     */
    public function findAllQuery()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->getQuery()
        ;
    }

    /**
     * Query: Find all tags by search
     * 
     * @param mixed|null $search
     * @return \Doctrine\ORM\Query
     */
    public function findAllTagsBySearchQuery($search = null)
    {
        return $this->createQueryBuilder('t')
            ->where('(t.name LIKE :name) OR
                (t.color LIKE :color)')
            ->setParameters(array(
                'name' => '%' . $search . '%',
                'color' => '%' . $search . '%',
                ))
            ->orderBy('t.id', 'DESC')
            ->getQuery();
    }
}
