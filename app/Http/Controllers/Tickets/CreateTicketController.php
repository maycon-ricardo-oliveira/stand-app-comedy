<?php

namespace App\Http\Controllers\Tickets;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\RamseyUuidGenerator;
use App\Chore\Domain\SessionRepository;
use App\Chore\Infra\MySql\SessionDAODatabase;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\Modules\Attractions\Infra\MySql\AttractionDAODatabase;
use App\Chore\Modules\Tickets\Infra\MySql\TicketDAODatabase;
use App\Chore\Modules\Tickets\UseCases\CreateTicket\CreateTicket;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateTicketController extends Controller
{
    private CreateTicket $createTicketUseCase;
    private TicketDAODatabase $ticketRepository;
    private AttractionDAODatabase $attractionRepository;
    private UserDAODatabase $userRepository;
    private RamseyUuidGenerator $uuidGenerator;
    private SessionRepository $sessionRepository;

    public function __construct()
    {

        parent::__construct();
        $uuidGenerator = new RamseyUuidGenerator();

        $this->ticketRepository = new TicketDAODatabase($this->dbConnection, $this->time, $uuidGenerator);
        $this->attractionRepository = new AttractionDAODatabase($this->dbConnection, $this->time);
        $this->userRepository = new UserDAODatabase($this->dbConnection, $this->time);
        $this->uuidGenerator = new RamseyUuidGenerator();
        $this->sessionRepository = new SessionDAODatabase($this->dbConnection, $this->time);

        $this->createTicketUseCase = new CreateTicket(
            $this->ticketRepository,
            $this->attractionRepository,
            $this->sessionRepository,
            $this->userRepository,
            $this->uuidGenerator,
            $this->time
        );
    }

    public function create(Request $request): JsonResponse
    {

        try {

//            $request->validate([
//                'ownerId ' => 'required',
//                'attractionId' => 'required',
//            ]);

            $ticketData = [
                'ownerId' => $request->ownerId,
                'attractionId' => $request->attractionId,
                'payedAt' => new DateTimeAdapter()
            ];

            $response = $this->createTicketUseCase->handle(
                $request->ownerId,
                $request->attractionId,
                $request->sessionId,
                new DateTimeAdapter()
            );

            return $this->response->successResponse($response);

        } catch(\Exception $exception) {
            return $this->response->badRequestResponse($exception->getMessage());
        }

    }

}
