<?php

namespace App\Chore\Modules\Attractions\Entities;

class AttractionStatus
{
    private const DRAFT = 'draft';
    private const PUBLISHED = 'published';
    private const FINISH = 'finish';

    private $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function canPublish(): bool
    {
        return $this->status === self::DRAFT;
    }

    public function publish(): void
    {
        if (!$this->canPublish()) {
            throw new \LogicException('Cannot publish attraction in current status');
        }

        $this->status = self::PUBLISHED;
    }

    public function canFinish(): bool
    {
        return $this->status === self::PUBLISHED;
    }

    public function finish(): void
    {
        if (!$this->canFinish()) {
            throw new \LogicException('Cannot finish attraction in current status');
        }

        $this->status = self::FINISH;
    }

    public function canReturnToDraft(): bool
    {
        return $this->status === self::PUBLISHED;
    }

    public function returnToDraft(): void
    {
        if (!$this->canReturnToDraft()) {
            throw new \LogicException('Cannot return attraction to draft in current status');
        }

        $this->status = self::DRAFT;
    }

}
