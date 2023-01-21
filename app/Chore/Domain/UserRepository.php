<?php

namespace App\Chore\Domain;

use App\Chore\Adapters\DateTimeAdapter;

interface UserRepository
{
    public function register(User $user, DateTimeAdapter $date): bool;

    public function findUserByEmail(string $email);

}
