<?php

namespace App\Chore\Modules\Tickets\Domain;

use DateTimeImmutable;
use Exception;

class Ticket {

    public TicketId $id;
    public string $ownerId;
    public string $attractionId;
    public string $sessionId;
    public DateTimeImmutable $payedAt;
    public TicketStatus $status;
    public DateTimeImmutable|null $checkinAt;

    public function __construct(DateTimeImmutable $time, TicketId $id, string $ownerId, string $attractionId, string $sessionId, DateTimeImmutable $payedAt, TicketStatus $status, DateTimeImmutable|null $checkinAt) {

        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->attractionId = $attractionId;
        $this->sessionId = $sessionId;
        $this->payedAt = $payedAt;
        $this->status = $status;
        $this->checkinAt = $checkinAt;

        $this->validatePaymentDate($time, $payedAt);
    }

    private function validatePaymentDate(DateTimeImmutable $time, DateTimeImmutable $payedAt)
    {
        if (strtotime($payedAt->format('Y-m-d H:i:s')) > strtotime($time->format('Y-m-d H:i:s'))) {
            throw new Exception("Payed date invalid");
        }
    }
}
