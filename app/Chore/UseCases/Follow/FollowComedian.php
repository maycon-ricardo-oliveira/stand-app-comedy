<?php

namespace App\Chore\UseCases\Follow;

use App\Chore\Domain\Comedian;
use App\Chore\Domain\ComedianRepository;
use App\Chore\Domain\IUniqId;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;

class FollowComedian
{

    private ComedianRepository $comedianRepository;
    private UserRepository $userRepository;
    private IUniqId $uuid;

    public function __construct(UserRepository $userRepository, ComedianRepository $comedianRepository, IUniqId $uuid)
    {
        $this->comedianRepository = $comedianRepository;
        $this->userRepository = $userRepository;
        $this->uuid = $uuid;
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

        $this->userRepository->followComedian($user, $comedian, $this->uuid->id());

        return $this->userRepository->findUserById($userId);

    }

}
