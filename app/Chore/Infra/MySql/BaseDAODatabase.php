<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Adapters\RamseyUuidGenerator;
use App\Chore\Domain\UuidGenerator;

class BaseDAODatabase
{

    protected UuidGenerator $uuidGenerator;

    public function __construct()
    {
        $this->uuidGenerator = new RamseyUuidGenerator();

    }
}
