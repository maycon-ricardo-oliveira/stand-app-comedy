<?php

namespace App\Chore\UseCases\UnFollow;

use App\Chore\Domain\Comedian;
use App\Chore\Domain\ComedianRepository;
use App\Chore\Domain\IUniqId;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;

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

        if ($follows > 0) {
            throw new \Exception("This user already following this Comedian");
        }

        $this->userRepository->unFollowComedian($user, $comedian);

        return $this->userRepository->findUserById($userId);

    }

}
