<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Hello HomeController!', $crawler->filter('h1')->text());
    }

    public function testHello()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/hello/Romain');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Hello Romain', $client->getResponse()->getContent());
    }
}
