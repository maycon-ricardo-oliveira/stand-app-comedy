<?php

namespace App\Chore\Modules\Attractions\Entities;

abstract class AbstractAttractionStatus implements AttractionStatusInterface
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

    public function isValidTransition(AttractionStatusInterface $status): bool
    {
        return false;
    }
}

