<?php

namespace App\Tests\Controller;

use App\Entity\Contact;
use App\Manager\ContactManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
//    public function testListWithDatabase()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/contacts/');
//
//        $this->assertSame(200, $client->getResponse()->getStatusCode());
//        $this->assertContains('3 contacts', $crawler->filter('table.table + p')->text());
//    }

    public function testListWithoutDatabase()
    {
        $client = static::createClient();

        $contacts = [
            (new Contact())->setId(1)->setFirstName('A')->setLastName('B'),
            (new Contact())->setId(2)->setFirstName('C')->setLastName('D'),
        ];

//        $mockConnection = $this->prophesize(Connection::class);
//        $mockConnection->fetchColumn('SELECT COUNT(id) AS count FROM contact')->willReturn(2);
//
//        $mockRepository = $this->prophesize(ContactRepository::class);
//        $mockRepository->findBy([], [], 100)->willReturn($contacts);
//
//        $mockRegistry = $this->prophesize(ManagerRegistry::class);
//        $mockRegistry->getManagerNames()->willReturn();
//        $mockRegistry->getConnectionNames()->willReturn();
//        $mockRegistry->getConnection()->willReturn($mockConnection->reveal());
//        $mockRegistry->getRepository("App\Entity\Contact")->willReturn($mockRepository->reveal());

//        $client->getContainer()->set('doctrine', $mockRegistry->reveal());

        $mockManager = $this->prophesize(ContactManagerInterface::class);
        $mockManager->count()->willReturn(2)->shouldBeCalledTimes(1);
        $mockManager->getAll()->willReturn($contacts)->shouldBeCalledTimes(1);

        static::$container->set(ContactManagerInterface::class, $mockManager->reveal());

        $crawler = $client->request('GET', '/contacts/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('2 contacts', $crawler->filter('table.table + p')->text());
    }

    public function testAddMethodGet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contacts/add');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertCount(5, $crawler->filter('form[name="contact"] input'));
    }

    public function testAddMethodPost()
    {
        $client = static::createClient();

        $mockManager = $this->prophesize(ContactManagerInterface::class);
        $client->getContainer()->set(ContactManagerInterface::class, $mockManager->reveal());

        $csrfToken = $client->getContainer()->get('security.csrf.token_manager')->getToken('contact');

        $crawler = $client->request('POST', '/contacts/add', [
            'contact' => [
                'firstName' => 'symfonyfan',
                '_token' => $csrfToken->getValue(),
                'birthdate' => [
                    'day' => '1',
                    'month' => '1',
                    'year' => '1899'
                ]
            ]

        ]);

        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $this->assertSame('/contacts/', $client->getResponse()->headers->get('Location'));

    }
}
