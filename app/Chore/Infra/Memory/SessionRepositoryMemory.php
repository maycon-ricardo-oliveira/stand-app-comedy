<?php

namespace App\Chore\Infra\Memory;

use App\Chore\Domain\Session;
use App\Chore\Domain\SessionRepository;

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

}
