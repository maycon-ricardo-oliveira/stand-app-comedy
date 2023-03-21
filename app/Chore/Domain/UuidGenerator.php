<?php

namespace App\Chore\Domain;

interface UuidGenerator {
    public function uuid4(): string;
}
