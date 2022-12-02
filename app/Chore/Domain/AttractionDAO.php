<?php

namespace App\Chore\Domain;

interface AttractionDAO
{
    public function getAttractionsInAPlace(string $place);

}