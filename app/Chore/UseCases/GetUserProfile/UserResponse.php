<?php

namespace App\Chore\UseCases\GetUserProfile;

use App\Chore\Domain\Comedian;
use App\Chore\Domain\User;

class UserResponse
{
    public User $user;

    /** @var Comedian[] */
    public array|null $comedians;

    /**
     * @param User $user
     * @param array|null $comedians
     */
    public function __construct(User $user, array|null $comedians = null)
    {
        $this->user = $user;
        $this->comedians = $comedians;
    }

}
