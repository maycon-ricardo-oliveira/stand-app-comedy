<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Domain\Comedian;
use App\Chore\Domain\ComedianRepository;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\User;
use App\Chore\Infra\ComedianMapper;

class ComedianDAODatabase extends ComedianMapper implements ComedianRepository
{

    private DBConnection $connection;

    public IDateTime $time;

    public function __construct(DBConnection $connection, IDateTime $time)
    {

        $this->connection = $connection;
        $this->time = $time;
        parent::__construct();
    }

    public function getComedianById(string $id)
    {
        $query = "select
                c.*,
                c.name as comedianName,
                c.mini_bio as miniBio
            from comedians c
            where c.id = :id";
        $params = ['id' => $id];

        $response = $this->connection->query($query, $params);
        return $this->mapper($this->time, $response);

    }

    public function followComedian(User $user, Comedian $comedian)
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
}
