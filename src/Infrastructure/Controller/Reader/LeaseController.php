<?php

namespace Library\Infrastructure\Controller\Reader;

use Library\Application\MakeLeaseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LeaseController extends AbstractController
{
    public function __construct(
        private MakeLeaseHandler $makeLeaseHandler
    ) {
    }

    public function lease(Request $request): JsonResponse
    {
        $leaseArray = json_decode($request->getContent(), true);

        //todo: add validation

        try {
            $this->makeLeaseHandler->handle(
                [
                    'bookId' => $leaseArray['book-id'],
                    'returnDate' => $leaseArray['return-date'],
                    'username' => $this->getUser()->getUserIdentifier(),
                ]
            );
        } catch (\Exception $exception) {
            //todo: Log exception message and send user friendly message as response
            return new JsonResponse($exception->getMessage());
        }

        return new JsonResponse('Book has been leased.', Response::HTTP_OK);
    }
}
