<?php

namespace App\Chore\Modules\Tickets\UseCases\GetTicket;

use App\Chore\Modules\Tickets\Entities\Ticket;
use App\Chore\Modules\Tickets\Entities\TicketId;
use App\Chore\Modules\Tickets\Entities\TicketRepository;

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
