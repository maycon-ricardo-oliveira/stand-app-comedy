<?php

namespace App\Chore\Modules\Tickets\Entities;

interface TicketRepository
{
    public function save(Ticket $ticket): bool;
    public function findById(TicketId $id): ?Ticket;
    public function getLastInsertedId(): ?TicketId;
    public function checkin(Ticket $ticket);

}
