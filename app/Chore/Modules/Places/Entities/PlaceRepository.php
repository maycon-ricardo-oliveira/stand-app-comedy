<?php

namespace App\Chore\Modules\Places\Entities;

interface PlaceRepository
{
    public function getPlaceById(string $id);

}
