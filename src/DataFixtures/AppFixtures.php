<?php

namespace Library\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Library\Domain\Book\Book;
use Library\Domain\Reader\Reader;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $book = new Book();
        $book->setName('Accelerate');
        $book->setAuthor('Nicole&Jez');
        $book->setGenre('devops');

        $manager->persist($book);

        $reader = new Reader();
        $reader->setUsername('foo');
        $reader->setEmail('test@test.com');
        $reader->setPassword($this->hasher->hashPassword($reader, '1234'));

        $manager->persist($reader);

        $manager->flush();
    }
}
