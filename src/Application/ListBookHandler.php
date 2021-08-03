<?php

namespace Library\Application;

use Exception;
use Library\Domain\Book\BookRepositoryInterface;
use Psr\Log\LoggerInterface;

class ListBookHandler
{
    public function __construct(
        private BookRepositoryInterface $bookRepository,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws Exception
     */
    public function handle(array $bookArray): array|int|string
    {
        try {
            $books = $this->bookRepository->findByAuthorAndGenre($bookArray['author'], $bookArray['genre']);
        } catch (Exception $exception) {
            $this->logger->critical($exception->getMessage());
            throw new Exception('Book Author or Book Genre not correct');
        }

        return $books;
    }
}
