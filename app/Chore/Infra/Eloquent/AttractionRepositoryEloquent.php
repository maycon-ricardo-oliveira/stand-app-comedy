<?php

namespace App\Chore\Infra\Eloquent;

use App\Chore\Domain\Attraction;
use App\Chore\Domain\AttractionRepository;
use App\Chore\Domain\IDateTime;
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


    public function registerAttraction(Attraction $attractionData, IDateTime $date): bool
    {

        return true;
        // TODO: Implement registerAttraction() method.
    }
    public function findAttractionById(string $attractionId): ?Attraction
    {
        return $this->getModel()->with('place')->where(['id' => $attractionId])->first();
    }
}
