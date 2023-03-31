<?php

namespace App\Chore\Modules\Adapters\MySqlAdapter;

use App\Chore\Modules\Adapters\UuidAdapter\RamseyUuidGenerator;
use App\Chore\Modules\Adapters\UuidAdapter\UuidGenerator;

class BaseDAODatabase
{

    protected UuidGenerator $uuidGenerator;

    public function __construct()
    {
        $this->uuidGenerator = new RamseyUuidGenerator();

    }
}
