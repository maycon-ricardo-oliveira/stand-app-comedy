<?php

namespace App\Chore\Infra\Memory;

use App\Chore\Domain\AttractionRepository;

class AttractionRepositoryMemory implements AttractionRepository {

    public function getAttractionsInAPlace(string $place): array
    {
        return [[
            'id' => 'any_id',
            'artist' => 'any_artist',
            'place' => 'any_place',
            'date' => 'any_date',
            'title' => 'any_title',
        ], [
            'id' => 'any_id',
            'artist' => 'any_artist',
            'place' => 'any_place',
            'date' => 'any_date',
            'title' => 'any_title',
        ],
        ];
    }

    public function getPlacesByLocation(string $lat, string $long, int $distance, int $limit = 20)
    {

    }
}
