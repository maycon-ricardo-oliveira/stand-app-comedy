<?php

namespace App\Chore\Modules\Attractions\Infra\Eloquent;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\EloquentAdapter\EloquentBase;
use App\Chore\Modules\Adapters\MySqlAdapter\DBConnection;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;

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

    public function updateAttraction(Attraction $attractionData): bool
    {
        // TODO: Implement updateAttraction() method.
    }
}
