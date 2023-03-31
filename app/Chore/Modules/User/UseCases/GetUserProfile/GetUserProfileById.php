<?php

namespace App\Chore\Modules\User\UseCases\GetUserProfile;

use App\Chore\Modules\Comedians\Entities\ComedianRepository;
use App\Chore\Modules\User\Entities\User;
use App\Chore\Modules\User\Entities\UserRepository;

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

    public function handle(string $userId): UserResponse
    {
        $user = $this->repo->findUserById($userId);

        if (!$user instanceof User) {
            throw new \Exception("User not found");
        }

        $comedians = $this->comedianRepo->getListOfComedians($user->followingComedians);

        return new UserResponse(
            $user, $comedians
        );
    }

}
