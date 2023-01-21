<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\IHash;
use App\Chore\Domain\UserRepository;
use App\Chore\Infra\UserMapper;
use Exception;

class UserDAODatabase extends UserMapper implements UserRepository
{

    private DBConnection $connection;

    public IDateTime $time;
    public IHash $bcrypt;
    public function __construct(DBConnection $connection, IDateTime $time, IHash $bcrypt)
    {
        parent::__construct();
        $this->connection = $connection;
        $this->time = $time;
        $this->bcrypt = $bcrypt;
    }

    public function register($userData, DateTimeAdapter $date): bool
    {

        $query = "INSERT INTO users (name, email, password, created_at, updated_at)
                  VALUES (:name, :email, :password, :created_at, :updated_at)";

        $params = [
            "name" => $userData["name"],
            "email" => $userData["email"],
            "password" => $this->bcrypt->make($userData["password"]),
            "created_at" => $date->format('Y-m-d H:i:s'),
            "updated_at" => $date->format('Y-m-d H:i:s'),
        ];

        $this->connection->query($query, $params);
        return true;

    }

    /**
     * @throws Exception
     */
    public function findUserByEmail(string $email)
    {
        $query = "select * from users u where u.email = :email";
        $params = ['email' => $email];

        $userData = $this->connection->query($query, $params);

        $data = $this->mapper($userData);

        return count($data) == 0 ? null : $data[0];
    }
}
