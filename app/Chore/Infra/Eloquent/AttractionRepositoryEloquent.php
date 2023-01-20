<?php

namespace App\Chore\Infra\Eloquent;

use App\Chore\Domain\AttractionRepository;
use App\Chore\Infra\MySql\DBConnection;

class AttractionRepositoryEloquent extends EloquentBase implements AttractionRepository
{

    public DBConnection $connection;

    public function __construct(DBConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAttractionsInAPlace(string $place)
    {
        return $this->getModel()->with('place')->where(['place' => $place])->get();
    }

    public function getPlacesByLocation(string $lat, string $long, int $distance, int $limit = 20)
    {
        // TODO: implement this method
    }

    public function getAttractionsByComedianName(string $comedianName)
    {
        return $this->getModel()->with('place')->where(['artist' => $comedianName])->get();

    }

    public function getAttractionsByComedianId(string $comedianId)
    {
        return $this->getModel()->with('place')->where(['artist' => $comedianId])->get();
    }
}
