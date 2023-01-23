<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\IHash;
use App\Chore\Domain\User;
use App\Chore\Domain\UserRepository;
use App\Chore\Infra\UserMapper;
use Exception;
use Illuminate\Support\Str;

class UserDAODatabase extends UserMapper implements UserRepository
{

    private DBConnection $connection;

    public IDateTime $time;
    public function __construct(DBConnection $connection, IDateTime $time)
    {
        parent::__construct();
        $this->connection = $connection;
        $this->time = $time;
    }

    public function register(User $user, DateTimeAdapter $date): bool
    {

        $query = "INSERT INTO users (name, email, password, remember_token, created_at, updated_at)
                  VALUES (:name, :email, :password, :remember_token, :created_at, :updated_at)";

        $params = [
            "name" => $user->name,
            "email" => $user->email,
            "password" =>$user->password,
            "remember_token" => $user->rememberToken,
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

    public function findUserById(string $id)
    {
        $query = "select * from users u where u.id = :id";
        $params = ['id' => $id];

        $userData = $this->connection->query($query, $params);

        $data = $this->mapper($userData);

        return count($data) == 0 ? null : $data[0];
    }
}
