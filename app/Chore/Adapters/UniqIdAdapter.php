<?php

namespace App\Chore\Adapters;

use App\Chore\Domain\IUniqId;
use Illuminate\Support\Str;

class UniqIdAdapter implements IUniqId
{

    public function id(): string
    {
        return uniqid();
    }

    public function rememberToken(): string
    {
        return uniqid(Str::random());
    }
}
