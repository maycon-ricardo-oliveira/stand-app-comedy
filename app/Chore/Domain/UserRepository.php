<?php

namespace App\Chore\Domain;

use App\Chore\Adapters\DateTimeAdapter;

interface UserRepository
{
    public function register(User $user, DateTimeAdapter $date): bool;
    public function findUserByEmail(string $email);
    public function findUserById(string $id);
    public function followComedian(User $user, Comedian $comedian, string $id);
    public function checkIfIsFollowAComedian(User $user, Comedian $comedian);
    public function unFollowComedian(User $user, Comedian $comedian);

}
