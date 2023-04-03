<?php

namespace App\Chore\Modules\Tickets\UseCases\CheckinTicket;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\UuidAdapter\UuidGenerator;
use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Entities\SessionRepository;
use App\Chore\Modules\Sessions\Entities\SessionStatus;
use App\Chore\Modules\Sessions\Exceptions\CantCheckinTicketsForThisSessionStatusException;
use App\Chore\Modules\Sessions\Exceptions\MaxTicketsEmittedException;
use App\Chore\Modules\Sessions\Exceptions\MaxTicketsValidatedException;
use App\Chore\Modules\Sessions\Exceptions\SessionNotFoundException;
use App\Chore\Modules\Sessions\UseCases\UpdateSessionStatus\UpdateSessionStatus;
use App\Chore\Modules\Tickets\Entities\Ticket;
use App\Chore\Modules\Tickets\Entities\TicketId;
use App\Chore\Modules\Tickets\Entities\TicketRepository;
use App\Chore\Modules\Tickets\Entities\TicketStatus;
use App\Chore\Modules\Tickets\Exceptions\TicketNotFoundException;
use Exception;

class CheckinTicket
{
    private TicketRepository $ticketRepository;
    private SessionRepository $sessionRepository;
    private IDateTime $time;
    private UuidGenerator $uuidGenerator;

    public function __construct(TicketRepository $ticketRepository, SessionRepository $sessionRepository, IDateTime $time, UuidGenerator $uuidGenerator)
    {

        $this->ticketRepository = $ticketRepository;
        $this->sessionRepository = $sessionRepository;
        $this->time = $time;
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * @param string $ticketId
     * @return Ticket
     * @throws CantCheckinTicketsForThisSessionStatusException
     * @throws SessionNotFoundException
     * @throws TicketNotFoundException
     * @throws MaxTicketsValidatedException
     */
    public function handle(string $ticketId): Ticket
    {
        $ticketId = TicketId::fromString($ticketId, $this->uuidGenerator);
        $ticket = $this->ticketRepository->findById($ticketId);

        if (!$ticket instanceof Ticket) {
            throw new TicketNotFoundException();
        }

        $session = $this->sessionRepository->findSessionById($ticket->sessionId);

        if (!$session instanceof Session) {
            throw new SessionNotFoundException();
        }

        $session->increaseTicketValidated();

        // does not have ticket status machine
        $ticket->status = TicketStatus::used();
        $ticket->checkinAt = $this->time;

        $this->ticketRepository->checkin($ticket);
        $this->sessionRepository->update($session);

        return $this->ticketRepository->findById($ticketId);
    }
}
