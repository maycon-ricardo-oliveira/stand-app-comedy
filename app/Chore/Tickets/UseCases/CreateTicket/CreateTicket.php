<?php

namespace App\Chore\Tickets\UseCases\CreateTicket;

use App\Chore\Domain\UuidGenerator;
use App\Chore\Tickets\Domain\TicketId;
use App\Chore\Tickets\Domain\TicketStatus;
use Ramsey\Uuid\Uuid;
use App\Chore\Tickets\Domain\Ticket;
use App\Chore\Tickets\Domain\TicketRepository;

class CreateTicket
{
    private TicketRepository $ticketRepository;
    private UuidGenerator $uuidGenerator;

    public function __construct(TicketRepository $ticketRepository, UuidGenerator $uuidGenerator)
    {
        $this->ticketRepository = $ticketRepository;
        $this->uuidGenerator = $uuidGenerator;
    }

    public function execute(string $ownerId, string $attractionId, string $payedAt, string $checkinAt): void {
        $ticket = new Ticket(TicketId::generate($this->uuidGenerator), $ownerId, $attractionId, $payedAt, TicketStatus::available(), $checkinAt);
        $this->ticketRepository->save($ticket);
    }

}
