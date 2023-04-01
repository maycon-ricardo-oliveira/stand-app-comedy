<?php

namespace App\Chore\Modules\Sessions\Entities;

abstract class AbstractSessionStatus implements SessionStatusInterface
{
    protected string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isValidTransition(SessionStatusInterface $status): bool
    {
        return false;
    }
}

