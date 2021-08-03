<?php

namespace Library\Application;

use Exception;
use Library\Domain\Reader\Reader;
use Library\Domain\Reader\ReaderRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UpdateReaderHandler
{
    public function __construct(
        private ReaderRepositoryInterface $readerRepository,
        private UserPasswordHasherInterface $hasher
    ) {
    }

    /**
     * @throws Exception
     */
    public function handle($readerArray)
    {
        /** @var Reader|null $reader */
        $reader = $this->readerRepository->find($readerArray['readerId']);

        if (!$reader) {
            //todo: log exeption message
            throw new Exception('Reader not found');
        }

        try {
            $reader->setUsername($readerArray['username']);
            $reader->setEmail($readerArray['email']);
            $reader->setPassword($this->hasher->hashPassword($reader, $readerArray['password']));
            $this->readerRepository->update($reader);
        } catch (Exception $exception) {
            //todo: log exception message
            throw new Exception($exception->getMessage() . 'User can not be saved');
        }
    }
}
