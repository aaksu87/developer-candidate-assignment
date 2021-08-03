<?php

namespace Library\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Library\Domain\Book\Book;
use Library\Domain\Book\BookRepositoryInterface;

class BookRepository extends ServiceEntityRepository implements BookRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Book $book)
    {
        $this->_em->persist($book);
        $this->_em->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update(Book $book)
    {
        $this->_em->flush($book);
    }

    /**
     * @throws ORMException
     */
    public function remove(Book $book)
    {
        $this->_em->remove($book);
        $this->_em->flush();
    }

    public function findByAuthorAndGenre(string $author, string $genre): array|int|string
    {
        return $this->createQueryBuilder('b')
            ->where('b.author like :author')
            ->andWhere('b.genre like :genre')
            ->setParameter('author', $author)
            ->setParameter('genre', $genre)
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?Book
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
