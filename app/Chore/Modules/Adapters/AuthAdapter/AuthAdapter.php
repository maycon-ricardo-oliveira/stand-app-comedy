<?php

namespace App\Chore\Modules\Adapters\AuthAdapter;

use App\Chore\Modules\User\Entities\User;
use Illuminate\Support\Facades\Auth;

class AuthAdapter extends Auth implements IAuth
{

    public $auth;

    public function __construct()
    {
        $this->auth = auth();
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
