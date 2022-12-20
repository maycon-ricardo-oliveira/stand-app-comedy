<?php

namespace App\Chore\Domain;

interface AttractionRepository
{
    public function getAttractionsInAPlace(string $place);

    public function getPlacesByLocation(string $lat, string $long, int $distance, int $limit = 20);

    public function getAttractionsByComedian(string $comedian);

}
