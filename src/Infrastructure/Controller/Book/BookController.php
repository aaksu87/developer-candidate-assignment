<?php

namespace Library\Infrastructure\Controller\Book;

use Library\Application\CreateBookHandler;
use Library\Application\ListBookHandler;
use Library\Application\RemoveBookHandler;
use Library\Application\UpdateBookHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController
{
    public function __construct(
       private CreateBookHandler $createBookHandler,
       private UpdateBookHandler $updateBookHandler,
       private RemoveBookHandler $removeBookHandler,
       private ListBookHandler $listBookHandler
    ) {
    }

    public function add(Request $request): JsonResponse
    {
        $bookArray = json_decode($request->getContent(), true);

        //todo: add validation

        try {
            $this->createBookHandler->handle(
                [
                    'name' => $bookArray['name'],
                    'author' => $bookArray['author'],
                    'genre' => $bookArray['genre'],
                ]
            );
        } catch (\Exception $exception) {
            //todo: Log exception message and send user friendly message as response
            return new JsonResponse($exception->getMessage());
        }

        return new JsonResponse('Book created', Response::HTTP_OK);
    }

    public function edit(Request $request): JsonResponse
    {
        $bookArray = json_decode($request->getContent(), true);

        //todo: add validation

        try {
            $this->updateBookHandler->handle(
                [
                    'bookId' => $bookArray['book-id'],
                    'name' => $bookArray['newname'],
                    'author' => $bookArray['newauthor'],
                    'genre' => $bookArray['newgenre'],
                ]
            );
        } catch (\Exception $exception) {
            //todo: Log exception message and send user friendly message as response
            return new JsonResponse($exception->getMessage());
        }

        return new JsonResponse('Book updated', Response::HTTP_OK);
    }

    public function remove(Request $request): JsonResponse
    {
        $bookArray = json_decode($request->getContent(), true);

        //todo: add validation

        try {
            $this->removeBookHandler->handle($bookArray['book-id']);
        } catch (\Exception $exception) {
            //todo: Log exception message and send user friendly message as response
            return new JsonResponse($exception->getMessage());
        }

        return new JsonResponse('Book removed.', Response::HTTP_OK);
    }

    public function search(Request $request): JsonResponse
    {
        $bookArray = json_decode($request->getContent(), true);

        //todo: add validation

        try {
            $books = $this->listBookHandler->handle($bookArray);
        } catch (\Exception $exception) {
            //todo: Log exception message and send user friendly message as response
            return new JsonResponse($exception->getMessage());
        }

        return new JsonResponse($books, Response::HTTP_OK);
    }
}
