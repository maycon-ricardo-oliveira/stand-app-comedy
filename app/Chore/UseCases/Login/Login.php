<?php

namespace App\Chore\UseCases\Login;

use App\Chore\Domain\UserRepository;
use Illuminate\Support\Facades\Auth;

class Login
{
    public UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle($username, $password)
    {
         if (Auth::attempt(['email'=> $username,'password'=> $password])) {
            return true;
         }
         return false;

    }

}
