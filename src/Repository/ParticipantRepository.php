<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participant::class);
    }

    // /**
    //  * @return Participant[] Returns an array of Participant objects
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
    public function findOneBySomeField($value): ?Participant
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

 /**
     * Return All Incoming Walk for a User
    */
    public function findIncomingWalksByUser($user)
    {
        return $this->createQueryBuilder('p')
        ->andWhere('p.user = :user')
        ->innerjoin('p.walk', 'w')
        ->addSelect('w')
        ->andWhere('w.status = :status')
        ->andWhere('p.requestStatus = :requestStatus')
        ->setParameters(array('user' => $user, 'status' => 1, 'requestStatus' => 1))
        ->orderBy("w.date", "ASC")
        ->getQuery()
        ->getResult()
    ; 
    }

    /**
     * Return All Archived Walk for a User
    */
    public function findArchivedWalksByUser($user)
    {
        return $this->createQueryBuilder('p')
        ->andWhere('p.user = :user')
        ->innerjoin('p.walk', 'w')
        ->addSelect('w')
        ->andWhere('w.status = :status')
        ->andWhere('p.requestStatus = :requestStatus')
        ->setParameters(array('user' => $user, 'status' => 2, 'requestStatus' => 1))
        ->orderBy("w.date", "ASC")
        ->getQuery()
        ->getResult()
    ; 
    }
}
