<?php

namespace Library\Domain\Book;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Library\Domain\Reader\Lease;

class Book
{
    private int $id;
    private string $name;
    private string $author;
    private string $genre;
    private DateTimeInterface $createdAt;
    private Collection $leases;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->leases = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Book
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Book
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): Book
    {
        $this->author = $author;

        return $this;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): Book
    {
        $this->genre = $genre;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): Book
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<Lease>
     */
    public function getLeases(): Collection
    {
        return $this->leases;
    }

    public function addLease(Lease $lease): Book
    {
        $lease->setBook($this);

        if (!$this->getLeases()->contains($lease)) {
            $this->leases->add($lease);
        }

        return $this;
    }

    public function removeLease(Lease $lease): Book
    {
        $this->leases->removeElement($lease);

        return $this;
    }
}
