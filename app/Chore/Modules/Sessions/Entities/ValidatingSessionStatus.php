<?php

namespace App\Chore\Modules\Sessions\Entities;

class ValidatingSessionStatus extends AbstractSessionStatus
{
    public function isValidTransition(SessionStatusInterface $status): bool
    {
        return $status instanceof FinishSessionStatus || $status instanceof InProgressSessionStatus;
    }
}
