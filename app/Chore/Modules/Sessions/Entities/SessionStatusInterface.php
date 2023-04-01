<?php

namespace App\Chore\Modules\Sessions\Entities;

interface SessionStatusInterface
{
    public function getStatus(): string;

    public function isValidTransition(SessionStatusInterface $status): bool;
}
