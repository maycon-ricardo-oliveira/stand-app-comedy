<?php

namespace App\Chore\Modules\Tickets\Entities;

use App\Chore\Modules\Adapters\UuidAdapter\UuidGenerator;

class TicketId {
    private string $id;
    private UuidGenerator $uuidGenerator;

    public function __construct(string $id, UuidGenerator $uuidGenerator) {
        $this->id = $id;
        $this->uuidGenerator = $uuidGenerator;
    }

    public static function generate(UuidGenerator $uuidGenerator): self {
        return new self($uuidGenerator->uuid4(), $uuidGenerator);
    }

    public static function fromString(string $id, UuidGenerator $uuidGenerator): self {
        return new self($id, $uuidGenerator);
    }

    public function toString(): string {
        return $this->id;
    }
}
