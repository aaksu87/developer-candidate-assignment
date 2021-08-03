<?php

namespace Library\Application;

use Exception;
use Library\Domain\Reader\Reader;
use Library\Domain\Reader\ReaderRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateReaderHandler
{
    public function __construct(
        private ReaderRepositoryInterface $readerRepository,
        private UserPasswordHasherInterface $hasher
    ) {
    }

    /**
     * @throws Exception
     */
    public function handle(array $readerArray)
    {
        $reader = new Reader();
        $reader->setUsername($readerArray['username']);
        $reader->setEmail($readerArray['email']);
        $reader->setPassword($this->hasher->hashPassword($reader, $readerArray['password']));

        try {
            $this->readerRepository->save($reader);
        } catch (Exception $exception) {
            //todo: log exception message
            throw new Exception('User can not be saved');
        }
    }
}
