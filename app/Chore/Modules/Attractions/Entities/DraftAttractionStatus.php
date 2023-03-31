<?php

namespace App\Chore\Modules\Attractions\Entities;

class DraftAttractionStatus extends AbstractAttractionStatus
{
    public function isValidTransition(AttractionStatusInterface $status): bool
    {
        return $status instanceof PublishedAttractionStatus;
    }
}



