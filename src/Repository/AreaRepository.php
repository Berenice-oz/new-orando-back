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
     * We get back walk's list of an area
     *
     * Here : SQL request associate
     * 
     * SELECT * FROM walk
     * INNER JOIN area
     * ON `walk`.`area_id`= `area`.`id`
     * WHERE `area`.`id`= 1
     */
    public function findAllWalkJoinedToArea(Area $area)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT w, a
            FROM App\Entity\Walk w
            INNER JOIN w.area a
            WHERE w.area = :area'
        )->setParameter('area', $area);

        return $query->getResult();
    }
    

    
    /*public function findAllByAsc($area)
    {
        return $this->createQueryBuilder('a')
            ->('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
