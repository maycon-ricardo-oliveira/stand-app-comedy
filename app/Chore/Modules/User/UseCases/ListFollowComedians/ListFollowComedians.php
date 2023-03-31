<?php

namespace App\Chore\Modules\User\UseCases\ListFollowComedians;

use App\Chore\Modules\User\Entities\User;
use App\Chore\Modules\User\Entities\UserRepository;

class ListFollowComedians
{
    private UserRepository $repo;

    public function __construct(UserRepository $repository)
    {
        $this->repo = $repository;
    }
    public function handle(string $userId)
    {

        $user = $this->repo->findUserById($userId);

        if (!$user instanceof User) {
            throw new \Exception('User not found');
        }

        return $this->repo->listFollowComedians($user);
    }

}
