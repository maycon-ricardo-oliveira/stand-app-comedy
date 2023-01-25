<?php

namespace App\Chore\Domain;

interface IUniqId
{
    public function id(): string;
    public function rememberToken(): string;
}
