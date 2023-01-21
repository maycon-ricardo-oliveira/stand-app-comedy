<?php

namespace App\Chore\UseCases\UserRegister;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\IHash;
use App\Chore\Domain\IUniqId;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;
use Illuminate\Support\Str;

class UserRegister
{

    public UserRepository $userRepository;

    public IHash $bcrypt;
    public IUniqId $uuid;
    public function __construct(UserRepository $userRepository, IHash $bcrypt, IUniqId $uuid)
    {
        $this->userRepository = $userRepository;
        $this->bcrypt = $bcrypt;
        $this->uuid = $uuid;
    }

    public function handle($userData, DateTimeAdapter $date)
    {

        $user = $this->userRepository->findUserByEmail($userData['email']);

        if ($user instanceof User) {
            throw new \Exception('This user already registered');
        }

        $user = new User(
            $this->uuid->id(),
            $userData["name"],
            $userData["email"],
            $this->bcrypt->make($userData["password"]),
            $this->uuid->rememberToken(),
        );


        $this->userRepository->register($user, $date);

        return $this->userRepository->findUserByEmail($userData["email"]);
    }

}
