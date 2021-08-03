<?php

namespace Library\Application;

use Exception;
use Library\Domain\Book\Book;
use Library\Domain\Book\BookRepositoryInterface;
use Psr\Log\LoggerInterface;

class RemoveBookHandler
{
    public function __construct(
        private BookRepositoryInterface $bookRepository,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws Exception
     */
    public function handle(int $id)
    {
        /** @var Book|null $book */
        $book = $this->bookRepository->find($id);

        if (!$book) {
            throw new Exception('Book not found');
        }

        try {
            $this->bookRepository->remove($book);
        } catch (Exception $exception) {
            $this->logger->critical($exception->getMessage());
            throw new Exception('Book can not be removed');
        }
    }
}
