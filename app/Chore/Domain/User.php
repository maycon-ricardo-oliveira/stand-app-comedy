<?php

namespace App\Chore\Domain;

use Illuminate\Http\JsonResponse;

class User
{

    public string $id;
    public string $name;
    public string $email;
    public string $password;

    /**
     * @param string $id
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function __construct(string $id, string $name, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
}
