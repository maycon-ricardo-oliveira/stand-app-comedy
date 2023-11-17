<?php

namespace App\Chore\Modules\Attractions\Entities;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;

interface AttractionRepository
{
    public function getAttractionsInAPlace(string $place);

    public function getPlacesByLocation(string $lat, string $long, int $distance, int $limit = 20);

    public function getAttractionsByComedianName(string $comedianName);

    public function getAttractionsByComedianId(string $comedianId);

    public function registerAttraction(Attraction $attractionData, IDateTime $date): bool;

    public function findAttractionById(string $attractionId): ?Attraction;

    public function updateAttraction(Attraction $attractionData): bool;

}
