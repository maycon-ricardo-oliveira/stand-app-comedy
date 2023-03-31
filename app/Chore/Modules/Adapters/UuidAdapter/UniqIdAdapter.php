<?php

namespace App\Chore\Modules\Adapters\UuidAdapter;

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
