<?php

namespace App\Chore\Modules\User\UseCases\UserRegister;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\HashAdapter\IHash;
use App\Chore\Modules\Adapters\UuidAdapter\IUniqId;
use App\Chore\Modules\User\Entities\User;
use App\Chore\Modules\User\Entities\UserRepository;
use App\Chore\Modules\User\UserAlreadyRegisteredException;

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

    /**
     * @throws UserAlreadyRegisteredException
     */
    public function handle($userData, IDateTime $date)
    {

        $user = $this->userRepository->findUserByEmail($userData['email']);

        if ($user instanceof User) {
            throw new UserAlreadyRegisteredException();
        }

        $password = $this->bcrypt->make($userData["password"]);
        $rememberToken = $this->uuid->rememberToken();
        $user = new User(
             $userData["id"] ?? $this->uuid->id(),
            $userData["name"],
            $userData["email"],
            $password,
            $rememberToken
        );

        $this->userRepository->register($user, $password, $rememberToken, $date);

        return $this->userRepository->findUserByEmail($userData["email"]);
    }

}
