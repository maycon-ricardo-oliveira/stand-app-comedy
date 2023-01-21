<?php

namespace App\Chore\Domain;

use App\Chore\Adapters\DateTimeAdapter;

interface UserRepository
{
    public function register($userData, DateTimeAdapter $date): bool;

    public function findUserByEmail(string $email);

}
