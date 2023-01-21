<?php

namespace App\Chore\UseCases\UserRegister;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;

class UserRegister
{

    public UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle($userData, DateTimeAdapter $date)
    {

        $user = $this->userRepository->findUserByEmail($userData['email']);

        if (count($user) > 0) {
            throw new \Exception('This user already registered');
        }

        $stored = $this->userRepository->register($userData, $date);

        return $stored;
    }
}
