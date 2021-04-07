<?php

namespace App\Tests\Controller\Login;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoleUserTest extends WebTestCase
{
    /**
     * User connected can create walk
     */
    public function testCreateWalk()
    {
      
        // create a client
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('user@user.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the walk form create page
        $client->request('GET', '/walk/create');
        $this->assertResponseIsSuccessful();
       
    }
}