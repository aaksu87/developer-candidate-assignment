<?php

namespace Library\Tests\Functional\Infrastructure\Controller\Reader;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ReaderControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->client = static::createClient(['environment' => 'test']);
        $this->client->disableReboot();

        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
    }

    public function testAdd()
    {
        $data = json_encode(['username' => 'junior', 'email' => 'jtest@test.com', 'password' => '4321']);
        $response = $this->getResponse(Request::METHOD_POST, $data);
        $this->assertSame('User created', $response);
    }

    public function testEdit()
    {
        $data = json_encode(['reader-id' => '1', 'newusername' => 'bar', 'newemail' => 'btest@test.com', 'newpassword' => '1243']);
        $response = $this->getResponse(Request::METHOD_PUT, $data);
        $this->assertSame('User Updated', $response);
    }

    private function getResponse(string $requestMethod, $data)
    {
        $this->client->request(
            $requestMethod,
            '/api/readers',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $data
        );

        $content = $this->client->getResponse()->getContent();

        return json_decode($content, true);
    }
}
