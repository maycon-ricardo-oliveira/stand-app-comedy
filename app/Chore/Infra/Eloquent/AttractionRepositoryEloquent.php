<?php

namespace App\Chore\Infra\Eloquent;

use App\Chore\Domain\AttractionRepository;
use App\Chore\Infra\MySql\DBConnection;
use App\Models\Attraction;

class AttractionRepositoryEloquent extends EloquentBase implements AttractionRepository
{

    public DBConnection $connection;

    public function __construct(DBConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAttractionsInAPlace(string $place)
    {
//        return Attraction::where(['place' => $place])->get();

        $query = $this->query()->where(['place' => $place])->toSql();
        return $this->connection->query($query, []);
    }

    public function getPlacesByLocation(string $lat, string $long, int $distance, int $limit = 20)
    {
        // TODO: Implement getPlacesByLocation() method.
    }
}
