<?php

namespace App\Chore\Infra;

use App\Chore\Domain\AttractionDAO;
use App\Models\Attraction;

class AttractionRepositoryDatabase implements AttractionDAO
{

    public function getAttractionsInAPlace(string $place)
    {
       return Attraction::where(['place' => $place])->get();
    }
}