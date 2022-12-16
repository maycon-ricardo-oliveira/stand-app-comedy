<?php

namespace App\Chore\Domain;

interface AttractionRepository
{
    public function getAttractionsInAPlace(string $place);

}