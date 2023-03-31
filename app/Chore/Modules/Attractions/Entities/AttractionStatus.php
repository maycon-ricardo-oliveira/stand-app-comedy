<?php

namespace App\Chore\Modules\Attractions\Entities;

use App\Chore\Exceptions\InvalidAttractionStatusException;

class AttractionStatus
{
    const DRAFT = 'draft';
    const PUBLISHED = 'published';
    const FINISH = 'finish';

    private string $status;

    /**
     * @throws InvalidAttractionStatusException
     */
    public function __construct(string $status)
    {
        if (!self::isValidStatus($status)) {
            throw new InvalidAttractionStatusException();
        }

        $this->status = $status;
    }

    /**
     * @param AttractionStatus $status
     * @return bool
     * @throws InvalidAttractionStatusException
     */
    public function canTransitionTo(AttractionStatus $status): bool
    {
        return match ($this->status) {
            self::DRAFT => $status->status === self::PUBLISHED,
            self::PUBLISHED => $status->status === self::DRAFT || $status->status === self::FINISH,
            self::FINISH => false,
            default => throw new InvalidAttractionStatusException(),
        };
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    private static function isValidStatus(string $status): bool
    {
        return in_array($status, [self::DRAFT, self::PUBLISHED, self::FINISH]);
    }
}
