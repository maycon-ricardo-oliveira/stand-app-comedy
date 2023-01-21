<?php

namespace App\Chore\Domain;

interface UserRepository
{
    public function register($userData): bool;

    public function findUserByEmail(string $email);

}
