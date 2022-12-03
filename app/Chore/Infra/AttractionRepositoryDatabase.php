<?php

namespace App\Chore\Infra;

use App\Chore\Domain\AttractionRepository;
use App\Models\Attraction;

class AttractionRepositoryDatabase implements AttractionRepository
{

    public function getAttractionsInAPlace(string $place)
    {
       return Attraction::where(['place' => $place])->get();
    }
}