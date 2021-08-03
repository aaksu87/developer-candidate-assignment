<?php

namespace Library\Application;

use Exception;
use Library\Domain\Book\BookRepositoryInterface;
use Library\Domain\Reader\ReaderRepositoryInterface;

class MakeLeaseHandler
{
    public function __construct(
        private BookRepositoryInterface $bookRepository,
        private ReaderRepositoryInterface $readerRepository
    ) {
    }

    /**
     * @throws Exception
     */
    public function handle(array $leaseArray)
    {
        $reader = $this->readerRepository->findOneBy(['username' => $leaseArray['username']]);

        if (!$book = $this->bookRepository->findOneById($leaseArray['bookId'])) {
            //todo: log exception message
            throw new Exception('Book not found');
        }

        $reader->makeLeases($book, $leaseArray['returnDate']);

        $this->readerRepository->update($reader);
    }
}
