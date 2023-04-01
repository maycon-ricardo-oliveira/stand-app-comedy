<?php

namespace App\Chore\Modules\Sessions\Entities;

class PublishedSessionStatus extends AbstractSessionStatus
{
    public function isValidTransition(SessionStatusInterface $status): bool
    {
        return $status instanceof FinishSessionStatus || $status instanceof DraftSessionStatus || $status instanceof ValidatingSessionStatus;
    }
}
