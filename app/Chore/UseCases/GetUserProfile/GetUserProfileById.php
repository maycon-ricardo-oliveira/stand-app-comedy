<?php

namespace App\Chore\UseCases\GetUserProfile;

use App\Chore\Domain\ComedianRepository;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;

class GetUserProfileById
{

    private UserRepository $repo;
    private ComedianRepository $comedianRepo;

    /**
     * @param UserRepository $repo
     */
    public function __construct(UserRepository $repo, ComedianRepository $comedianRepository)
    {
        $this->comedianRepo = $comedianRepository;
        $this->repo = $repo;
    }

    public function handle(string $userId)
    {
        $user = $this->repo->findUserById($userId);

        if (!$user instanceof User) {
            throw new \Exception("User not found");
        }

        $comedians = $this->comedianRepo->getListOfComedians($user->followingComedians);

        return [
            "user" => $user,
            "comedians" => $comedians
        ];

    }

}
