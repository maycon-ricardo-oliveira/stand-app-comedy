<?php

namespace App\Chore\Domain;

interface IJwt
{
    public function createToken(User $user, string $token);

}
