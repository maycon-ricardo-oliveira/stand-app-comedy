<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Domain\AttractionRepository;

class AttractionDAODatabase implements AttractionRepository
{

    private Connection $connection;

    public function __construct(Connection $connection)
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