<?php

namespace App\Chore\Modules\Adapters\AuthAdapter;

use App\Chore\Modules\User\Entities\User;

interface IAuth
{
    public function attempt(array $credentials = [], bool $remember = false): bool|string;
    public function logout(): void;
    public function refresh(User $user);

}
