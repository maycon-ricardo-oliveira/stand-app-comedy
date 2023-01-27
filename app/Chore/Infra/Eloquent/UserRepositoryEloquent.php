<?php

namespace App\Chore\Infra\Eloquent;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\Comedian;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;
use App\Chore\Infra\UserMapper;
use App\Models\User as UserModel;

class UserRepositoryEloquent extends UserMapper implements UserRepository
{

    public function register(User $user, DateTimeAdapter $date): bool
    {
        return true;
    }

    public function findUserByEmail(string $email)
    {
        // TODO: Implement findUserByEmail() method.
    }

    public function findUserById(string $id)
    {
        $user = UserModel::with('userFollows.comedian')->where(['id' => $id])->first();

        var_dump($user->userFollows);
        return $user instanceof UserModel ?
            new User(
                $user->id,
                $user->name,
                $user->email,
                $user->password,
                $user->remember_token,
                (array) $user->userFollows ?? []
            ) : null;
    }

    public function followComedian(User $user, Comedian $comedian, string $id)
    {
        // TODO: Implement followComedian() method.
    }

    public function checkIfIsFollowAComedian(User $user, Comedian $comedian)
    {
        // TODO: Implement getFollows() method.
    }
}
