<?php

namespace App\Chore\Modules\Sessions\UseCases\FindSessionById;

use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Entities\SessionRepository;
use App\Chore\Modules\Tickets\Entities\Ticket;
use App\Chore\Modules\Tickets\Entities\TicketId;
use App\Chore\Modules\Tickets\Entities\TicketRepository;

class FindSessionById
{
    private SessionRepository $sessionRepository;

    public function __construct(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    public function handle(string $sessionId): ?Session {
        return $this->sessionRepository->findSessionById($sessionId);
    }

}
