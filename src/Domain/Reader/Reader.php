<?php

namespace Library\Domain\Reader;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use Library\Domain\Book\Book;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Reader implements UserInterface, PasswordAuthenticatedUserInterface
{
    private int $id;
    private string $username;
    private string $password;
    private string $email;
    private bool $isActive;
    private DateTimeInterface $createdAt;
    private Collection $leases;

    public function __construct()
    {
        $this->isActive = true;
        $this->createdAt = new DateTimeImmutable();
        $this->leases = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Reader
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): Reader
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): Reader
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Reader
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): Reader
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

    public function addLease(Lease $lease): Reader
    {
        $lease->setReader($this);

        if (!$this->getLeases()->contains($lease)) {
            $this->leases->add($lease);
        }

        return $this;
    }

    public function removeLease(Lease $lease): Reader
    {
        $this->leases->removeElement($lease);

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }

    /**
     * @throws Exception
     */
    public function makeLeases(Book $book, string $returnDate)
    {
        if (!($this->leases->count() < 3)) {
            throw new Exception('Reader already rented 3 Books');
        }

        $lease = new Lease();
        $lease->setReader($this);
        $lease->setBook($book);
        $lease->setReturnDate(new DateTimeImmutable($returnDate));

        $this->leases->add($lease);
        $book->addLease($lease);
    }
}
