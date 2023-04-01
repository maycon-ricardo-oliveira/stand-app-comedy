<?php

namespace App\Chore\Modules\Sessions\Entities;

class DraftSessionStatus extends AbstractSessionStatus
{
    public function isValidTransition(SessionStatusInterface $status): bool
    {
        return $status instanceof PublishedSessionStatus;
    }
}



