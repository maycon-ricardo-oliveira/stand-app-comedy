<?php

namespace App\Chore\Modules\Sessions\Entities;

use App\Chore\Modules\Sessions\Exceptions\InvalidSessionStatusException;

class SessionStatus
{
    const DRAFT = 'draft';
    const PUBLISHED = 'published';
    const FINISH = 'finish';
    const VALIDATING = 'validating';
    const IN_PROGRESS = 'in_progress';

    private string $status;

    /**
     * @throws InvalidSessionStatusException
     */
    public function __construct(string $status)
    {
        if (!self::isValidStatus($status)) {
            throw new InvalidSessionStatusException();
        }

        $this->status = $status;
    }

    /**
     * @param SessionStatus $status
     * @return bool
     * @throws InvalidSessionStatusException
     */
    public function canTransitionTo(SessionStatus $status): bool
    {
        return match ($this->status) {
            self::DRAFT => $status->status === self::PUBLISHED,
            self::PUBLISHED => $status->status === self::DRAFT || $status->status === self::VALIDATING,
            self::VALIDATING => $status->status === self::PUBLISHED || $status->status === self::IN_PROGRESS,
            self::IN_PROGRESS => $status->status === self::FINISH,
            self::FINISH => false,
            default => throw new InvalidSessionStatusException(),
        };
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    private static function isValidStatus(string $status): bool
    {
        return in_array($status, [self::DRAFT, self::PUBLISHED, self::VALIDATING, self::IN_PROGRESS, self::FINISH]);
    }
}
