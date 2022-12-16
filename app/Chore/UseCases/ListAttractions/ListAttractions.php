<?php

namespace App\Chore\UseCases\ListAttractions;

use App\Chore\Domain\AttractionRepository;

class ListAttractions
{

    /**
     * @var AttractionRepository
     */
    private $attractionRepo;

    public function __construct(AttractionRepository $attractionRepo)
    {
        $this->attractionRepo = $attractionRepo;
    }

    public function handle(string $place): array
    {
        $response = [];
        $attractionsData = $this->attractionRepo->getAttractionsInAPlace($place);
        foreach ($attractionsData as $attraction) {

            $serialize = new AttractionResponse(
                $attraction['id'],
                $attraction['title'],
                $attraction['date'],
                $attraction['place'],
                $attraction['artist']
            );

            $response[] = $serialize;
        }
        return $response;
    }

}