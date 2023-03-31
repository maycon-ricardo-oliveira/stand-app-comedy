<?php

namespace App\Chore\Modules\User\Infra\Eloquent;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Comedians\Entities\Comedian;
use App\Chore\Modules\User\Entities\User;
use App\Chore\Modules\User\Entities\UserRepository;
use App\Chore\Modules\User\Infra\UserMapper;
use App\Models\User as UserModel;

class UserRepositoryEloquent extends UserMapper implements UserRepository
{

    public function findUserByEmail(string $email)
    {
        // TODO: Implement findUserByEmail() method.
    }

    public function findUserById(string $id): ?User
    {
        $user = UserModel::with('followingComedians.comedian')->where(['id' => $id])->first();

        return $user instanceof UserModel ?
            new User(
                $user->id,
                $user->name,
                $user->email,
                $user->password,
                $user->remember_token,
                (array) $user->followingComedians ?? []
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

    public function unFollowComedian(User $user, Comedian $comedian)
    {
        // TODO: Implement unFollowComedian() method.
    }

    public function register(User $user, IDateTime $date): bool
    {
        return true;
    }

    public function listFollowComedians(User $user)
    {
        // TODO: Implement listFollowComedians() method.
    }
}
