<?php

namespace Library\Application;

use Exception;
use Library\Domain\Book\Book;
use Library\Domain\Book\BookRepositoryInterface;
use Psr\Log\LoggerInterface;

class UpdateBookHandler
{
    public function __construct(
        private BookRepositoryInterface $bookRepository,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws Exception
     */
    public function handle($bookArray)
    {
        /** @var Book|null $book */
        $book = $this->bookRepository->find($bookArray['bookId']);

        if (!$book) {
            throw new Exception('Book not found');
        }

        try {
            $book->setname($bookArray['name']);
            $book->setAuthor($bookArray['author']);
            $book->setGenre($bookArray['genre']);
            $this->bookRepository->update($book);
        } catch (Exception $exception) {
            $this->logger->critical($exception->getMessage());
            throw new Exception('Book can not be updated');
        }
    }
}
