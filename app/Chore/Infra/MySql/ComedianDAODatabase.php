<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Domain\ComedianRepository;
use App\Chore\Domain\IDateTime;

class ComedianDAODatabase implements ComedianRepository
{

    private DBConnection $connection;

    public IDateTime $time;

    public function __construct(DBConnection $connection, IDateTime $time)
    {

        $this->connection = $connection;
        $this->time = $time;
    }

    public function getComedianById(string $id)
    {
        $query = "select * from comedians
             where comedians.id = :id";
        $params = ['id' => $id];

        $response = $this->connection->query($query, $params);
        return $response;

    }
}
