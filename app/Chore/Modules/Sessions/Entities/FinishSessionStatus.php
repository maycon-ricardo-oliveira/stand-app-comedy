<?php

namespace App\Chore\Modules\Sessions\Entities;

class FinishSessionStatus extends AbstractSessionStatus
{
    public function isValidTransition(SessionStatusInterface $status): bool
    {
        return false;
    }
}
