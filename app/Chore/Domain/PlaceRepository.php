<?php

namespace App\Chore\Domain;

interface PlaceRepository
{
    public function getPlaceById(string $id);

}
