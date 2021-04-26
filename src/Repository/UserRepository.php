<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Find the last 5 users
     * 
     * @return User[] Returns an array of User objects
     */
    public function findLast()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.createdAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Query: Find All users
     * 
     * @return \Doctrine\ORM\Query
     */
    public function findAllQuery()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.createdAt', 'DESC')
            ->getQuery()
        ;
    }

    /**
     * Query: Find all users by search
     * 
     * @param mixed|null $search
     * @return \Doctrine\ORM\Query
     */
    public function findAllUsersBySearchQuery($search = null)
    {
        return $this->createQueryBuilder('u')
            ->where('(u.lastname LIKE :lastname) OR
                (u.firstname LIKE :firstname) OR
                (u.nickname LIKE :nickname) OR
                (u.email LIKE :email)')
            ->setParameters(array(
                'lastname' => '%' . $search . '%',
                'firstname' => '%' . $search . '%',
                'nickname' => '%' . $search . '%',
                'email' => '%' . $search . '%',
                ))
            ->orderBy('u.createdAt', 'DESC')
            ->getQuery();
    }
}
