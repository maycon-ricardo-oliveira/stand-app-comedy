<?php

namespace App\Chore\UseCases\Follow;

use App\Chore\Domain\ComedianRepository;
use App\Chore\Domain\UserRepository;

class FollowComedian
{

    private ComedianRepository $comedianRepository;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, ComedianRepository $comedianRepository)
    {
        $this->comedianRepository = $comedianRepository;
    }

    public function handle(string $userId, string $comedianId): bool
    {
        $user = $this->userRepository->findUserById($userId);
        $comedian = $this->comedianRepository->getComedianById($comedianId);

        return $this->comedianRepository->followComedian($user, $comedian);
    }


}
