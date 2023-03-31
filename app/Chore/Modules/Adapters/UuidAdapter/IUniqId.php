<?php

namespace App\Chore\Modules\Adapters\UuidAdapter;

interface IUniqId
{
    public function id(): string;
    public function rememberToken(): string;
}
