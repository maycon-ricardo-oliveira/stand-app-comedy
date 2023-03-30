<?php

namespace App\Chore\Tickets\Infra\Memory;

use App\Chore\Tickets\Domain\Ticket;
use App\Chore\Tickets\Domain\TicketId;
use App\Chore\Tickets\Domain\TicketRepository;

class TicketRepositoryMemory implements TicketRepository
{
    private array $tickets = [];
    private ?TicketId $lastInsertedId = null;
    public function save(Ticket $ticket): bool {
        $this->tickets[$ticket->id->toString()] = $ticket;
        $this->lastInsertedId = $ticket->id;
        return true;
    }

    public function findById(TicketId $id): ?Ticket {
        return $this->tickets[$id->toString()] ?? null;
    }

    public function getLastInsertedId(): ?TicketId {
        return $this->lastInsertedId;
    }
}
