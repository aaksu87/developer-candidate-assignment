<?php

namespace Library\Application;

use Exception;
use Library\Domain\Book\Book;
use Library\Domain\Book\BookRepositoryInterface;

class CreateBookHandler
{
    public function __construct(
        private BookRepositoryInterface $bookRepository
    ) {
    }

    /**
     * @throws Exception
     */
    public function handle(array $bookArray)
    {
        $book = new Book();
        $book->setName($bookArray['name']);
        $book->setAuthor($bookArray['author']);
        $book->setGenre($bookArray['genre']);

        try {
            $this->bookRepository->save($book);
        } catch (Exception $exception) {
            //todo: log exception message
            throw new Exception($exception->getMessage().'. Book can not be saved');
        }
    }
}
