<?php

namespace App\Chore\Tickets\UseCases\GetTicket;

use App\Chore\Tickets\Domain\Ticket;
use App\Chore\Tickets\Domain\TicketId;
use App\Chore\Tickets\Domain\TicketRepository;
use Ramsey\Uuid\Uuid;

class GetTicketById
{

    private TicketRepository $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function handle(TicketId $ticketId): ?Ticket {
        return $this->ticketRepository->findById($ticketId);
    }

}
