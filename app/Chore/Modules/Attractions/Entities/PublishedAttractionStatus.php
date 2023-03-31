<?php

namespace App\Chore\Modules\Attractions\Entities;

class PublishedAttractionStatus extends AbstractAttractionStatus
{
    public function isValidTransition(AttractionStatusInterface $status): bool
    {
        return $status instanceof FinishAttractionStatus || $status instanceof DraftAttractionStatus;
    }
}
