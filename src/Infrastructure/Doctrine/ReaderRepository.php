<?php

namespace Library\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Library\Domain\Reader\Reader;
use Library\Domain\Reader\ReaderRepositoryInterface;

class ReaderRepository extends ServiceEntityRepository implements ReaderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reader::class);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(Reader $reader)
    {
        $this->_em->persist($reader);
        $this->_em->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update(Reader $reader)
    {
        $this->_em->flush($reader);
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?Reader
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
