<?php

namespace App\DataFixtures;

use Faker;
use DateTime;
use App\Entity\Tag;
use App\Entity\Area;
use App\Entity\User;
use App\Entity\Walk;
use App\Entity\Participant;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Provider\WalkDbProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\DataFixtures\Data\TagData;
use App\DataFixtures\Data\WalkData;
/**
 * This class allow to make some Area objects et Walks objects in our database
 */
class AppFixtures extends Fixture
{
    //Here, we define number of recordings in each table
    const NB_WALKS = 11;
    const NB_USERS = 10;
    const NB_PARTICIPANTS = 3 * self::NB_USERS;
    
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
        $users = $this->connection->executeQuery('TRUNCATE TABLE tag');
        $users = $this->connection->executeQuery('TRUNCATE TABLE participant');
        $users = $this->connection->executeQuery('TRUNCATE TABLE walk_tag');
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
        $areas = [
            
            1 => 'Bretagne',
            2 => 'Normandie',
            3 => 'Hauts-de-France',
            4 => 'Pays de la Loire',
            5 =>  'Île-de-France',
            6 => 'Centre-Val de Loire',
            7 => 'Nouvelle-Aquitaine',
            8 => 'Occitanie',
            9 => 'Auvergne-Rhône-Alpes',
            10 => 'Provence-Alpes-Côte d\'Azur',
            11 => 'Corse',
            12 => 'Grand-Est',
            13 => 'Bourgogne-Franche-Comté',
            14 => 'Mayotte',
            15 => 'Martinique',
            16 => 'Guadeloupe',
            17 => 'Réunion',
            18 => 'Guyane',
        ];

        $areasList = [];

        foreach($areas as $value) {
             
             // An area
            $area = new Area();
            $area->setName($value);
            $area->setColor($faker->areaColor());

            $areasList[] = $area;
             
            // Prepare the entity $area for the creation in the database
            $manager->persist($area);
        }

        //we store tags in an array
        $tagsList = [];

        
        foreach (TagData::$tagsData as $tag) {
            
            // A Tag
            $myTag = new Tag();
            $myTag->setName($tag['name']);
            $myTag->setColor($tag['color']);

            $tagsList[] = $myTag;
            
            // Prepare the entity $myTag for the creation in the database
            $manager->persist($myTag);
        }

        // We store the walks in an array
        $walksList = [];

        for ($i = 1; $i <= self::NB_WALKS; $i++) {

            $walkData = new WalkData();
            
            // A walk
            $walk = new Walk();
            
            $walk->setTitle(WalkData::$walksData[$i]['title']);
            $walk->setDescription(WalkData::$walksData[$i]['description']);
            $walk->setDifficulty($faker->walkDifficulty());
            //$walk->setArea(WalkData::$walksData['areaId']);

            shuffle($tagsList);
            
            for ($r = 0; $r <= mt_rand(1, 2); $r++) {
                $randomTag = $tagsList[$r];
                $walk->addTag($randomTag);
            }


            $walksList[] = $walk;

            // here, we prepare the entity walk for the creation
            $manager->persist($walk);
        }


        // we store the users in an array
        $usersList = [];
        for ($i = 1; $i <= self::NB_USERS; $i++) {
            $user = new User();
            $user->setEmail($faker->unique()->email());
            $user->setLastname($faker->unique()->lastName());
            $user->setFirstname($faker->firstName());
            $userHashPassword = $this->passwordEncoder->encodePassword($user, $faker->password(8, 16));
            $user->setPassword($userHashPassword);
            $user->setStatus(1);
            $user->setNickname($faker->unique()->name());
            $user->setDateOfBirth($faker->optional()->dateTime());
            $user->setDescription($faker->optional()->paragraphs(2, true));
            // array_rand allow to have areas randomly
            $randomArea = $areasList[array_rand($areasList)];
            $user->setArea($randomArea);
            //add walks creations
            shuffle($walksList);
            for ($r = 0; $r < mt_rand(1, 5); $r++) {
                $randomWalk = $walksList[$r];
                $user->addWalk($randomWalk);
            }

            shuffle($walksList);
            for ($s = 0; $s < mt_rand(1, 4); $s++) {
                $randomWalk = $walksList[$s];
                $user->addParticipant($randomWalk);
            }

            $usersList[] = $user;
            

            // here, we prepare the entity user for the creation
            $manager->persist($user);
        }


        // admin
        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setLastname('admin');
        $admin->setFirstname('admin');
        $adminHashPassword = $this->passwordEncoder->encodePassword($admin, 'admin');
        $admin->setPassword($adminHashPassword);
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setStatus(1);
        $admin->setNickname('admin');
        $manager->persist($admin);

        // user
        $user = new User();
        $user->setEmail('user@user.com');
        $user->setLastname('user');
        $user->setFirstname('user');
        $userHashPassword = $this->passwordEncoder->encodePassword($user, 'user');
        $user->setPassword($userHashPassword);
        $user->setRoles(['ROLE_USER']);
        $user->setStatus(1);
        $user->setNickname('user');
        shuffle($walksList);
        for ($s = 0; $s < 5; $s++) {
            $randomWalk = $walksList[$s];
            $user->addParticipant($randomWalk);
        }
        $manager->persist($user);

        $userWalks = [
            [
                'title' => 'Circuit découverte de la Presqu\'île de Crozon',
                'startingPoint' => 'Presqu\'île de Crozon',
                'endPoint' => '',
                'date' => new \Datetime('2021-04-01 14:00:00'),
                'duration' => '1 heure',
                'difficulty' => 'Moyen',
                'elevation' => null,
                'maxNbPersons' => null,
                'description' => 'Cadre idyllique pour profiter d\'une vue sur le large à 180 degrés.',
            ],
            [
                'title' => 'Randonnée à la Pointe de Saint Mathieu',
                'startingPoint' => 'Pointe de Saint Mathieu',
                'endPoint' => '',
                'date' => new \Datetime('2021-04-05 14:00:00'),
                'duration' => '2 heures 30',
                'difficulty' => 'Facile',
                'elevation' => 255,
                'maxNbPersons' => null,
                'description' => 'Circuit de l\'île d\'Ouessant à l\'île de Sein.',
            ],
            [
                'title' => 'Côte de Granit Rose',
                'startingPoint' => 'Côte de Granit Rose',
                'endPoint' => '',
                'date' => new \Datetime('2021-04-24 14:00:00'),
                'duration' => '4 heures 30',
                'difficulty' => 'Facile',
                'elevation' => 500,
                'maxNbPersons' => 12,
                'description' => 'Découverte de ce musée à ciel ouvert sur les sentiers de Ploumanac\'h.',
            ],
            [
                'title' => 'La Forêt de la Madeleine et l\'Abbaye de Port-Royal-des-Champs',
                'startingPoint' => 'La Forêt de la Madeleine',
                'endPoint' => 'l\'Abbaye de Port-Royal-des-Champs',
                'date' => new \Datetime('2021-04-30 14:00:00'),
                'duration' => '3 heures 30',
                'difficulty' => 'Facile',
                'elevation' => null,
                'maxNbPersons' => 10,
                'description' => 'Balade historique sur les pas de Jean Racine',
            ]
        ];

        $userWalksList = [];
        foreach ($userWalks as $userWalk) {
            $walk = new Walk();
            $walk->setTitle($userWalk['title']);
            $walk->setStartingPoint($userWalk['startingPoint']);
            $walk->setEndPoint($userWalk['endPoint']);
            $walk->setDate($userWalk['date']);
            $walk->setDuration($userWalk['duration']);
            $walk->setDifficulty($userWalk['difficulty']);
            $walk->setElevation($userWalk['elevation']);
            $walk->setMaxNbPersons($userWalk['maxNbPersons']);
            $walk->setDescription($userWalk['description']);
            // array_rand allow to have areas randomly
            $randomArea = $areasList[array_rand($areasList)];
            $walk->setArea($randomArea);
            $userWalksList[] = $walk;
            $manager->persist($walk);
        }

        foreach ($userWalksList as $walk) {
            $user->addWalk($walk);
        }

        // we send the data in our database
        $manager->flush();
    }
}
