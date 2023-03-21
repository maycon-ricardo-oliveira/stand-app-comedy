<?php

namespace App\Http\Controllers\Tickets;

use App\Chore\Adapters\AuthAdapter;
use App\Chore\Adapters\UniqIdAdapter;
use App\Chore\Infra\MySql\ComedianDAODatabase;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\Tickets\UseCases\CreateTicket\CreateTicket;
use App\Chore\UseCases\Follow\FollowComedian;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateTicketController extends Controller
{
    private CreateTicket $createTicketUseCase;

    public function __construct(CreateTicket $createTicketUseCase)
    {
        parent::__construct();
        $this->createTicketUseCase = $createTicketUseCase;
    }

    public function create(Request $request): JsonResponse
    {

        try {

            $ticket = $this->createTicketUseCase->handle();

            return $this->response->successResponse($ticket->getId());

        } catch(\Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }

    }

    public function getById(Request $request, Response $response, array $args): Response
    {
        // ...
    }
}
