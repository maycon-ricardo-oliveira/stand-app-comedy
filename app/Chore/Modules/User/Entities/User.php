<?php

namespace App\Chore\Modules\User\Entities;

use App\Chore\Modules\Comedians\Entities\Comedian;

class User
{

    public string $id;
    public string $name;
    public string $email;
    public string $password;
    public string $rememberToken;

    /**
     * @var Comedian[]
     */
    public mixed $followingComedians;

    /**
     * @param string $id
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $rememberToken
     * @param Comedian[] $followingComedians
     */
    public function __construct(
        string $id,
        string $name,
        string $email,
        string $password,
        string $rememberToken,
        array $followingComedians = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->rememberToken = $rememberToken;
        $this->followingComedians = $followingComedians;
    }

}
