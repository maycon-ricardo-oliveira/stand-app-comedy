<?php

namespace App\Chore\Adapters;

use App\Chore\Domain\IUniqId;

class UniqIdAdapter implements IUniqId
{

    public function id(): string
    {
        return uniqid();
    }
}
