<?php

namespace App\Chore\Tickets\Domain;

class Ticket {
    public TicketId $id;
    public string $ownerId;
    public string $attractionId;
    public string $payedAt;
    public TicketStatus $status;
    public null|string $checkinAt;

    public function __construct(TicketId $id, string $ownerId, string $attractionId, string $payedAt, TicketStatus $status, string|null $checkinAt) {

        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->attractionId = $attractionId;
        $this->payedAt = $payedAt;
        $this->status = $status;
        $this->checkinAt = $checkinAt;
    }
}
