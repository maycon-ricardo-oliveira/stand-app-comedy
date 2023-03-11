<?php

namespace App\Chore\Domain;

use Illuminate\Http\JsonResponse;
use Laravel\Sanctum\HasApiTokens;

class User
{

    public string $id;
    public string $name;
    public string $email;
    public string $password;
    public string $rememberToken;
    public $followingComedians;

    /**
     * @param string $id
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $rememberToken
     * @param $followingComedians
     */
    public function __construct(
        string $id,
        string $name,
        string $email,
        string $password,
        string $rememberToken,
        $followingComedians = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->rememberToken = $rememberToken;
        $this->followingComedians = $followingComedians;
    }


}
