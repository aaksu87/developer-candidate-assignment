<?php

namespace Library\Tests\Functional\Infrastructure\Controller\Book;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class BookControllerTest extends WebTestCase
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
        $data = json_encode(['name' => 'code', 'author' => 'carlos', 'genre' => 'programing']);
        $response = $this->getResponse(Request::METHOD_POST, $data);
        $this->assertSame('Book created', $response);
    }

    public function testEdit()
    {
        $data = json_encode(['book-id' => '1', 'newname' => 'code', 'newauthor' => 'carlos', 'newgenre' => 'programing']);
        $response = $this->getResponse(Request::METHOD_PUT, $data);
        $this->assertSame('Book updated', $response);
    }

    public function testRemove()
    {
        $data = json_encode(['book-id' => '1']);
        $response = $this->getResponse(Request::METHOD_DELETE, $data);
        $this->assertSame('Book removed.', $response);
    }

    public function testSearch()
    {
        $data = json_encode(['author' => 'Nicole&Jez', 'genre' => 'devops']);
        $response = $this->getResponse(Request::METHOD_GET, $data);
        $this->assertCount(1, $response);
        foreach ($response as $book) {
            $this->assertArrayHasKey('name', $book);
            $this->assertArrayHasKey('author', $book);
            $this->assertArrayHasKey('genre', $book);
            $this->assertArrayHasKey('createdAt', $book);
        }
    }

    private function getResponse(string $requestMethod, $data)
    {
        $this->client->request(
            $requestMethod,
            '/api/books',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $data
        );

        $content = $this->client->getResponse()->getContent();

        return json_decode($content, true);
    }
}
