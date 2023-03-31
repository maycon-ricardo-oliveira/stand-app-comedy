<?php

namespace App\Chore\Modules\User\UseCases\GetUserProfile;

use App\Chore\Modules\Comedians\Entities\Comedian;
use App\Chore\Modules\User\Entities\User;

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
