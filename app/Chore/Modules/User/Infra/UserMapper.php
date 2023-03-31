<?php

namespace App\Chore\Modules\User\Infra;

use App\Chore\Modules\User\Entities\User;
use ArrayIterator;
use Exception;

class UserMapper extends ArrayIterator
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function mapper($userData = [])
    {

        if ($userData == []) {
            return $userData;
        }

        return array_map(function ($item) {
            $item = (object) $item;
            return new User(
                $item->id,
                $item->name,
                $item->email,
                $item->password,
                $item->remember_token,
                !empty($item->followingComedians) ? explode(",", $item->followingComedians) : []
            );

        }, $userData);

    }
}
