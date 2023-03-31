<?php

namespace App\Chore\Modules\Tickets\UseCases\GetTicket;

use App\Chore\Modules\Tickets\Domain\Ticket;
use App\Chore\Modules\Tickets\Domain\TicketId;
use App\Chore\Modules\Tickets\Domain\TicketRepository;

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
