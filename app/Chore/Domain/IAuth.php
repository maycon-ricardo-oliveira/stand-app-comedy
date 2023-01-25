<?php

namespace App\Chore\Domain;

interface IAuth
{
    public function attempt(array $credentials = [], bool $remember = false): bool|string;
    public function logout(): void;
    public function refresh(User $user);

}
