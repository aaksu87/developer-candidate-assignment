<?php

namespace Library\Infrastructure\Controller\Reader;

use Library\Application\CreateReaderHandler;
use Library\Application\UpdateReaderHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReaderController
{
    public function __construct(
       private CreateReaderHandler $createReaderHandler,
       private UpdateReaderHandler $updateReaderHandler,
       private LoggerInterface $logger
    ) {
    }

    public function add(Request $request): JsonResponse
    {
        $readerArray = json_decode($request->getContent(), true);

        //todo: add validation

        try {
            $this->createReaderHandler->handle(
                [
                    'username' => $readerArray['username'],
                    'email' => $readerArray['email'],
                    'password' => $readerArray['password'],
                ]
            );
        } catch (\Exception $exception) {
            //todo: Log exception message and send user friendly message as response
            return new JsonResponse($exception->getMessage());
        }

        return new JsonResponse('User created');
    }

    public function edit(Request $request): JsonResponse
    {
        $readerArray = json_decode($request->getContent(), true);

        //todo: add validation

        try {
            $this->updateReaderHandler->handle(
                [
                    'readerId' => $readerArray['reader-id'],
                    'username' => $readerArray['newusername'],
                    'email' => $readerArray['newemail'],
                    'password' => $readerArray['newpassword'],
                ]
            );
        } catch (\Exception $exception) {
            //todo: Log exception message and send user friendly message as response
            return new JsonResponse($exception->getMessage());
        }

        return new JsonResponse('User Updated');
    }
}
