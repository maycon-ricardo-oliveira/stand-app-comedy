<?php

namespace App\Chore\Modules\Adapters\UuidAdapter;

interface UuidGenerator {
    public function uuid4(): string;
}
