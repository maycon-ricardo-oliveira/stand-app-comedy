<?php

namespace App\Chore\Modules\User\Entities;


use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Comedians\Entities\Comedian;

interface UserRepository
{
    public function register(User $user, IDateTime $date): bool;
    public function findUserByEmail(string $email);
    public function findUserById(string $id): ?User;
    public function followComedian(User $user, Comedian $comedian, string $id);
    public function checkIfIsFollowAComedian(User $user, Comedian $comedian);
    public function unFollowComedian(User $user, Comedian $comedian);
    public function listFollowComedians(User $user);

}
