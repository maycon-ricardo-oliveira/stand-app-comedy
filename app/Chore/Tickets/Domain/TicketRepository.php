<?php

namespace App\Chore\Tickets\Domain;

interface TicketRepository
{
    public function save(Ticket $ticket): bool;

    public function findById(TicketId $id): ?Ticket;

    public function getLastInsertedId(): ?TicketId;

}
