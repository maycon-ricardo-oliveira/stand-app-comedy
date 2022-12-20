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
        $query = "select * from attractions
             inner join places on places.id = attractions.place_id
             where attractions.place = :id";
        $params = ['id' => $id];

        $response = $this->connection->query($query, $params);
        return $response;

    }
}
