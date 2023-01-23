<?php

namespace App\Chore\UseCases\Auth;

use App\Chore\Adapters\AuthAdapter;
use App\Chore\Adapters\JwtAdapter;
use App\Chore\Domain\IAuth;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;

class Auth
{
    public UserRepository $userRepository;
    public IAuth $auth;
    public function __construct(UserRepository $userRepository,IAuth $auth)
    {
        $this->userRepository = $userRepository;
        $this->auth = $auth;
    }

    public function login($email, $password)
    {

        $user = $this->userRepository->findUserByEmail($email);

        if (!$user instanceof User) {
            throw new \Exception("Password or Email Incorrect");
        }

        if (!$token = $this->auth->auth->attempt(['email' => $email, 'password' => $password])) {
            throw new \Exception("Unauthorized");
        }

        $jwt = new JwtAdapter();
        return $jwt->createToken($user, $token);
    }

    public function logout(): bool
    {
        $this->auth->logout();
        return true;
    }

    /**
     * @throws \Exception
     */
    public function refresh()
    {
        $user = $this->userRepository->findUserById($this->auth->user()->getAuthIdentifier());

        if (!$user instanceof User) {
            throw new \Exception("Email does not exist");
        }

        $token = $this->auth->refresh($user);
        $jwt = new JwtAdapter();
        return $jwt->createToken($user, $token);
    }

}