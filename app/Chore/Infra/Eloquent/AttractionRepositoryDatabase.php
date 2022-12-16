<?php

namespace App\Chore\Infra\Eloquent;

use App\Chore\Domain\AttractionRepository;
use App\Chore\Infra\MySql\DBConnection;
use App\Models\Attraction;

class AttractionRepositoryDatabase implements AttractionRepository
{

    private DBConnection $connection;

    public function __construct(DBConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getModel() {
        return $this->connection->model;
    }

    public function getAttractionsInAPlace(string $place)
    {
        $query = $this->query()->where(['place' => $place])->toSql();
        return $this->connection->query($query, ['place' => $place]);
    }

    protected function query()
    {
        return $this->getModel()->query();
    }

}
