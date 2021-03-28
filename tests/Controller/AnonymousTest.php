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
    public function testRedirectGet($url): void
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

    /**
     * Same test but with POST method
     *
     * @dataProvider urlProvider
     */
    public function testRedirectPost($url): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', $url);

        // check redirect login page
        $this->assertResponseStatusCodeSame(302);
    }

    public function url()
    {
        yield ['/walk/create'];
        yield ['/walk/edit/1'];
        yield ['/profile/1/contact-user'];

    }
}