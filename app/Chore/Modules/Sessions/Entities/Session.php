<?php

namespace App\Chore\Modules\Sessions\Entities;

use App\Chore\Modules\Sessions\Exceptions\CantCheckinTicketsForThisSessionStatusException;
use App\Chore\Modules\Sessions\Exceptions\CantEmitTicketsForThisSessionStatusException;
use App\Chore\Modules\Sessions\Exceptions\MaxTicketsEmittedException;
use App\Chore\Modules\Types\Time\Time;
use DateTimeImmutable;

class Session
{

    public string $id;
    public string $attractionId;
    public SessionCode $sessionCode;
    public int $tickets;
    public int $ticketsSold;
    public int $ticketsValidated;
    public Time $startAt;
    public Time $finishAt;
    public string $status;
    public string $createdBy;
    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;
    public function __construct(string $id, string $attractionId, SessionCode $sessionCode, int $tickets, int $ticketsSold, int $ticketsValidated, Time $startAt, Time $finishAt, string $status, string $createdBy, DateTimeImmutable $createdAt, DateTimeImmutable $updatedAt)
    {
        $this->id = $id;
        $this->attractionId = $attractionId;
        $this->sessionCode = $sessionCode;
        $this->tickets = $tickets;
        $this->ticketsSold = $ticketsSold;
        $this->ticketsValidated = $ticketsValidated;
        $this->startAt = $startAt;
        $this->finishAt = $finishAt;
        $this->status = $status;
        $this->createdBy = $createdBy;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @throws MaxTicketsEmittedException
     * @throws CantEmitTicketsForThisSessionStatusException
     */
    public function increaseTicketSold(int $amount = 1): void
    {
        if ($this->ticketsSold + $amount > $this->tickets) {
            throw new MaxTicketsEmittedException();
        }

        if (!$this->canSoldTicketStatus()) {
            throw new CantEmitTicketsForThisSessionStatusException();
        }

        $this->ticketsSold += $amount;
    }

    /**
     * @throws MaxTicketsEmittedException
     * @throws CantCheckinTicketsForThisSessionStatusException
     */
    public function increaseTicketValidated(): void
    {
        if (!$this->canValidatingTicketStatus()) {
            throw new CantCheckinTicketsForThisSessionStatusException();
        }

        // TODO: tickets ? or ticketsSold
        // TODO: change this exception to a MaxTicketValidated
        if ($this->ticketsValidated++ > $this->tickets) {
            throw new MaxTicketsEmittedException();
        }
        $this->ticketsValidated++;
    }

    private function canSoldTicketStatus(): bool
    {
        return in_array($this->status, [SessionStatus::PUBLISHED, SessionStatus::VALIDATING, SessionStatus::IN_PROGRESS]);
    }

    private function canValidatingTicketStatus()
    {
        return in_array($this->status, [SessionStatus::VALIDATING, SessionStatus::IN_PROGRESS]);
    }
}
