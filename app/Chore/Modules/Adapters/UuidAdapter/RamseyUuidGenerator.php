<?php

namespace App\Chore\Modules\Adapters\UuidAdapter;

use Ramsey\Uuid\Uuid;

class RamseyUuidGenerator implements UuidGenerator {
    public function uuid4(): string {
        return Uuid::uuid4()->toString();
    }
}
