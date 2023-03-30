<?php

namespace App\Chore\Adapters;

use App\Chore\Domain\UuidGenerator;
use Ramsey\Uuid\Uuid;

class RamseyUuidGenerator implements UuidGenerator {
    public function uuid4(): string {
        return Uuid::uuid4()->toString();
    }
}
