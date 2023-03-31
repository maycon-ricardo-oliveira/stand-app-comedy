<?php

namespace App\Chore\Modules\Adapters\JwtAdapter;

use App\Chore\Modules\User\Entities\User;

interface IJwt
{
    public function createToken(User $user, string $token);

}
