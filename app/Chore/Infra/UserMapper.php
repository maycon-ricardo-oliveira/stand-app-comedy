<?php

namespace App\Chore\Infra;

use App\Chore\Domain\Comedian;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\User;
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
            return new User(
                $item['id'],
                $item['name'],
                $item['email'],
                $item['password']
            );

        }, $userData);

    }
}
