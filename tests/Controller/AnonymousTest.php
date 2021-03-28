<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnonymousTest extends WebTestCase
{

    /**
     * We check user's anonym does not access of these pages
     *
     * @dataProvider urlProvider
     */
    public function testRedirectInGet($url): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);

        // check redirect login page
        $this->assertResponseStatusCodeSame(302);
    }

    public function urlProvider()
    {
        yield ['/walk/create'];
        yield ['/walk/edit/1'];
        yield ['/profile/1/contact-user'];

    }
}