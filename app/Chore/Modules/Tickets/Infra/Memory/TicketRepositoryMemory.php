<?php

namespace App\Chore\Modules\Tickets\Infra\Memory;

use App\Chore\Modules\Tickets\Domain\Ticket;
use App\Chore\Modules\Tickets\Domain\TicketId;
use App\Chore\Modules\Tickets\Domain\TicketRepository;

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
