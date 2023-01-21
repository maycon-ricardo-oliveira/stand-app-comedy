<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Domain\IDateTime;
use App\Chore\Domain\UserRepository;
use App\Chore\Infra\UserMapper;
use Exception;

class UserDAODatabase extends UserMapper implements UserRepository
{

    private DBConnection $connection;

    public IDateTime $time;
    public function __construct(DBConnection $connection, IDateTime $time)
    {
        $this->connection = $connection;
        $this->time = $time;
    }

    public function register($userData): bool
    {

        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";

        $params = [
            "name" => $userData["name"],
            "email" => $userData["email"],
            "password" => bcrypt($userData["password"])
        ];

        $this->connection->query($query, $params);
        return true;

    }

    public function findUserByEmail(string $email)
    {
        $query = "select *
            from users u
            where u.email = :email";
        $params = ['email' => $email];

        $userData = $this->connection->query($query, $params);

        return $this->mapper($userData);
    }
}
