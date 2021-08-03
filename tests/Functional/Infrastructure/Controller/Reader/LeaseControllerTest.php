<?php

namespace Library\Tests\Functional\Infrastructure\Controller\Reader;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class LeaseControllerTest extends WebTestCase
{
    private const ADMIN_USERNAME = 'foo';
    private const ADMIN_USER_PASSWORD = '1234';
    private const BASE_URL = 'http://127.0.0.1:8030';

    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->client = $this->createAuthenticatedClient();
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
    }

    public function testAdd()
    {
        $data = json_encode(['book-id' => '1', 'return-date' => 'tomorrow']);
        $response = $this->getResponse($data);
        $this->assertSame('Book has been leased.', $response);
    }

    private function getResponse($data)
    {
        $this->client->request(
            Request::METHOD_POST,
            '/api/leases',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $data
        );

        $content = $this->client->getResponse()->getContent();

        return json_decode($content, true);
    }

    private function createAuthenticatedClient(): KernelBrowser
    {
        $client = static::createClient(['environment' => 'test']);
        $client->disableReboot();
        $client->request(
            'POST',
            self::BASE_URL.'/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(
                [
                    'username' => self::ADMIN_USERNAME,
                    'password' => self::ADMIN_USER_PASSWORD,
                ]
            )
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }
}
