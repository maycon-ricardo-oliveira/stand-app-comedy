<?php

namespace App\Chore\Tickets\Domain;

class TicketStatus
{
    private string $value;

    private function __construct(string $value) {
        $this->value = $value;
    }

    public static function waiting(): self {
        return new self('waiting');
    }

    public static function used(): self {
        return new self('used');
    }
    public static function paid(): self {
        return new self('paid');
    }

    public static function fromString(string $value): self {
        return new self($value);
    }

    public function isWaiting(): bool {
        return $this->value === 'waiting';
    }

    public function isUsed(): bool {
        return $this->value === 'used';
    }

    public function __toString(): string {
        return $this->value;
    }
}
