<?php

namespace App\Chore\Domain;

interface SessionRepository
{

    public function getLastInsertedId(): ?string;

    public function findSessionById(string $sessionId): ?Session;

    public function getSessionsByAttractionsId(string $attractionId);

    public function register(Session $session): bool;

}
