<?php

namespace App\Chore\Modules\Places\Entities;

interface PlaceRepository
{
    public function getPlaceById(string $id);
    public function getPlaceByName(string $name): ?Place;

    public function register(Place $place): bool;

}
