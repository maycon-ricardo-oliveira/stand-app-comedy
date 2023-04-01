<?php

namespace App\Chore\Modules\Sessions\Infra\Memory;

use App\Chore\Modules\Sessions\Entities\Session;
use App\Chore\Modules\Sessions\Entities\SessionRepository;

class SessionRepositoryMemory implements SessionRepository
{

    private array $sessions = [];
    private ?string $lastInsertedId = null;

    public function getLastInsertedId(): ?string {
        return $this->lastInsertedId;
    }

    public function findSessionById(string $sessionId): ?Session
    {
        return $this->sessions[$sessionId] ?? null;
    }

    public function getSessionsByAttractionsId(string $attractionId)
    {
        return $this->sessions[$attractionId] ?? null;
    }

    public function register(Session $session): bool
    {
        $this->sessions[$session->id] = $session;
        $this->lastInsertedId = $session->id;
        return true;
    }

    public function update(Session $session): bool
    {
        foreach ($this->sessions as $item) {
            if ($item->id == $session->id) {
                $item->attractionId = $session->attractionId;
                $item->sessionCode = $session->sessionCode;
                $item->tickets = $session->tickets;
                $item->ticketsSold = $session->ticketsSold;
                $item->ticketsValidated = $session->ticketsValidated;
                $item->startAt = $session->startAt;
                $item->finishAt = $session->finishAt;
                $item->status = $session->status;
                $item->createdBy = $session->createdBy;
                $item->updatedAt = $session->updatedAt;
                return true;
            }
        }
        return false;
    }

}
