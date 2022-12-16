<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Domain\AttractionRepository;

class AttractionDAODatabase implements AttractionRepository
{

    private DBConnection $connection;

    public function __construct(DBConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAttractionsInAPlace(string $place)
    {
        $query = "SELECT * FROM attractions WHERE attractions.place = :place";
        $params = ['place' => $place];

        return $this->connection->query($query, $params);

    }
}
