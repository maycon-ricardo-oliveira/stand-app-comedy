<?php

namespace App\Chore\Adapters;

use App\Chore\Domain\IAuth;
use App\Chore\Domain\IJwt;
use App\Chore\Domain\User;
use Illuminate\Support\Facades\Auth;

class AuthAdapter extends Auth implements IAuth
{

    public $auth;

    public IJwt $jwt;

    public function __construct(IJwt $jwt)
    {
        $this->auth = auth();
        $this->jwt = $jwt;
    }
    public function attempt(array $credentials = [], bool $remember = false): bool|string
    {
        return $this->auth->attempt($credentials, $remember);
    }

    public function logout(): void
    {
        $this->auth->logout();
    }

    public function refresh(User $user)
    {
       return $this->auth->refresh();
    }

    public function user()
    {
       return $this->auth->user();
    }

}
