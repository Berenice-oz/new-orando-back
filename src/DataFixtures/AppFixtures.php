<?php

namespace App\DataFixtures;

use Faker;
use DateTime;
use App\Entity\Area;
use App\Entity\User;
use App\Entity\Walk;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Provider\WalkDbProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * This class allow to make some Area objects et Walks objects in our database
 */
class AppFixtures extends Fixture
{
    //
    const NB_AREAS = 12;
    const NB_WALKS = 35;
    const NB_USERS = 50;
    
    private $passwordEncoder;
    // Connection to MySQL
    private $connection;

    
    public function __construct(Connection $connection, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->connection = $connection;
        $this->passwordEncoder = $passwordEncoder;
    }
    private function truncate()
    {
        
        //Here , we "discuss" with MySql and ask to disabled foreign key
        $users = $this->connection->executeQuery('SET foreign_key_checks = 0');
        // each time we make bin/console doctrine:fixtures:load, thank to $this->connection->executeQuery
        //we can restart the id at 0 in each table that we mentioned
        $users = $this->connection->executeQuery('TRUNCATE TABLE area');
        $users = $this->connection->executeQuery('TRUNCATE TABLE walk');
        $users = $this->connection->executeQuery('TRUNCATE TABLE user');
    }
    
    public function load(ObjectManager $manager)
    {
        // we truncate our table
        $this->truncate();
        
        // use the factory to create a Faker\Generator instance in french
        $faker = Faker\Factory::create('fr_FR');
        $faker->seed('Orando');

        // Initialization of the Provider
        $walkDbProvider = new WalkDbProvider();

        //Giving provider to faker
        $faker->addProvider($walkDbProvider);

        // we store the areas in an array
        $areasList = [];

        for ($i = 1; $i <= self::NB_AREAS; $i++) {
             
             // An area
            $area = new Area();
            $area->setName($faker->unique()->areaName());
            $area->setColor($faker->areaColor());
 
            $areasList[] = $area;
             
            // Prepare the entity $area for the creation in the database
            $manager->persist($area);
        }

        // we store the users in an array
        $usersList = [];
        for ($i = 1; $i <= self::NB_USERS; $i++) {
            $user = new User();
            $user->setEmail($faker->unique()->email());
            $user->setLastname($faker->unique()->lastName());
            $user->setFirstname($faker->firstName());
            $userHashPassword = $this->passwordEncoder->encodePassword($user, $faker->password(8,16));
            $user->setPassword($userHashPassword);
            $user->setStatus(1);
            // array_rand allow to have areas randomly
            $randomArea = $areasList[array_rand($areasList)];
            $user->setArea($randomArea);
            $usersList[] = $user;
            // here, we prepare the entity user for the creation
            $manager->persist($user);
        }
 

        // We store the walks in an array
        $walksList = [];

        for ($i = 1; $i <= self::NB_WALKS; $i++) {
            
            // A walk
            $walk = new Walk();
            
            // faker allow to generate fake data
            // unique / streetaddress/ randamDigitNotNull etc, you can find these
            // formatters available in his documentation
            $walk->setTitle($faker->unique()->sentence());
            $walk->setStartingPoint($faker->streetAddress());
            $walk->setEndPoint($faker->streetAddress());
            $walk->setDate($faker->unique->dateTimeThisDecade());
            $walk->setDuration($faker->randomDigitNotNull());
            $walk->setDifficulty($faker->walkDifficulty());
            $walk->setElevation($faker->randomNumber(3, true));
            $walk->setMaxNbPersons($faker->numberBetween(1, 30));
            $walk->setDescription($faker->text());
            $walk->setCreatedAt(new DateTime());
            // array_rand allow to have users randomly
            $randomUser = $usersList[array_rand($usersList)];
            $walk->setCreator($randomUser);
            // array_rand allow to have areas randomly
            $randomArea = $areasList[array_rand($areasList)];
            $walk->setArea($randomArea);


            $walksList[] = $walk;

            // here, we prepare the entity walk for the creation
            $manager->persist($walk);
        }

       
        
        // we send the data in our database
        $manager->flush();
    }
}
