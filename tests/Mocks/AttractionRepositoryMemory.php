<?php

namespace Tests\Mocks;

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
}
