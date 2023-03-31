<?php

namespace App\Chore\Modules\User\UseCases\UnFollow;

use App\Chore\Modules\Comedians\Entities\Comedian;
use App\Chore\Modules\Comedians\Entities\ComedianRepository;
use App\Chore\Modules\User\Entities\User;
use App\Chore\Modules\User\Entities\UserRepository;

class UnFollowComedian
{

    private ComedianRepository $comedianRepository;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, ComedianRepository $comedianRepository)
    {
        $this->comedianRepository = $comedianRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(string $userId, string $comedianId)
    {
        $user = $this->userRepository->findUserById($userId);
        $comedian = $this->comedianRepository->getComedianById($comedianId);

        if (!$user instanceof User) {
            throw new \Exception("User does not exist");
        }

        if (!$comedian instanceof Comedian) {
            throw new \Exception("Comedian does not exist");
        }

        $follows = $this->userRepository->checkIfIsFollowAComedian($user, $comedian);

        if ($follows != 0) {
            throw new \Exception("This user already unfollowing this Comedian");
        }

        $this->userRepository->unFollowComedian($user, $comedian);

        return $this->userRepository->findUserById($userId);

    }

}
