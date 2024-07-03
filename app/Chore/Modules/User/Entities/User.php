<?php

namespace App\Chore\Modules\User\Entities;

use App\Chore\Modules\Comedians\Entities\Comedian;
use App\Models\UserLocations;

class User
{

    public string $id;
    public string $name;
    public string $email;
    private string $password;
    private string $rememberToken;

    /**
     * @var Comedian[]
     */
    public mixed $followingComedians;

    public array $locations;

    /**
     * @param string $id
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $rememberToken
     * @param Comedian[] $followingComedians
     * @param UserLocations[] $locations
     *
     */
    public function __construct(
        string $id,
        string $name,
        string $email,
        string $password,
        string $rememberToken,
        array $followingComedians = [],
        array $locations = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->rememberToken = $rememberToken;
        $this->followingComedians = $followingComedians;
        $this->locations = $locations;
    }

}
