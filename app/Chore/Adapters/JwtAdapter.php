<?php

namespace App\Chore\Adapters;

use App\Chore\Domain\IJwt;
use App\Chore\Domain\User;

class JwtAdapter implements IJwt
{

    public function createToken(User $user,string $token)
    {
        $isProduction = env('APP_ENV') === 'production';
        $expiry = $isProduction ? time() + (60 * 60 * 2) : time() + (60 * 2);

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiry,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ]
        ];
    }
}
