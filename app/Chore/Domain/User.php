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

    /**
     * @param string $id
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $rememberToken
     */
    public function __construct(string $id, string $name, string $email, string $password, string $rememberToken)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->rememberToken = $rememberToken;
    }
}
