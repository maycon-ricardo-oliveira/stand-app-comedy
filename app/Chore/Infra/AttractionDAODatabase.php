<?php

namespace App\Chore\Infra;

use App\Chore\Domain\AttractionDAO;

class AttractionDAODatabase implements AttractionDAO
{

    private $connection;

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