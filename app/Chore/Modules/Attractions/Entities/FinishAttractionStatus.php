<?php

namespace App\Chore\Modules\Attractions\Entities;

class FinishAttractionStatus extends AbstractAttractionStatus
{
    public function isValidTransition(AttractionStatusInterface $status): bool
    {
        return false;
    }
}
