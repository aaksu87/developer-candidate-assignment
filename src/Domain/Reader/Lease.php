<?php

namespace Library\Domain\Reader;

use DateTimeImmutable;
use DateTimeInterface;
use Library\Domain\Book\Book;

class Lease
{
    private int $id;
    private DateTimeInterface $returnDate;
    private DateTimeInterface $createdAt;
    private Book $book;
    private Reader $reader;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Lease
    {
        $this->id = $id;

        return $this;
    }

    public function getReturnDate(): DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(DateTimeInterface $returnDate): Lease
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    /**
     * @return DateTimeImmutable|DateTimeInterface
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeImmutable|DateTimeInterface $createdAt
     *
     * @return Lease
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function setBook(Book $book): Lease
    {
        $this->book = $book;

        return $this;
    }

    public function getReader(): Reader
    {
        return $this->reader;
    }

    public function setReader(Reader $reader): Lease
    {
        $this->reader = $reader;

        return $this;
    }
}
