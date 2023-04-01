<?php

namespace App\Chore\Modules\Sessions\Entities;

class InProgressSessionStatus extends AbstractSessionStatus
{
    public function isValidTransition(SessionStatusInterface $status): bool
    {
        return $status instanceof FinishSessionStatus;
    }
}
