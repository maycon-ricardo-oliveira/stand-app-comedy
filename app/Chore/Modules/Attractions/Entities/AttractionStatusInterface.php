<?php

namespace App\Chore\Modules\Attractions\Entities;

interface AttractionStatusInterface
{
    public function getStatus(): string;

    public function isValidTransition(AttractionStatusInterface $status): bool;
}
