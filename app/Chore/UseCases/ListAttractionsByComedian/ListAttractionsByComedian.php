<?php

namespace App\Chore\UseCases\ListAttractionsByComedian;

use App\Chore\Domain\AttractionRepository;
use App\Chore\UseCases\DTOs\AttractionResponse;
use App\Chore\UseCases\DTOs\AttractionWithLocationResponse;
use App\Chore\UseCases\DTOs\PlaceResponse;

class ListAttractionsByComedian
{


    private AttractionRepository $repo;

    public function __construct(AttractionRepository $repository)
    {
        $this->repo = $repository;
    }

    public function handle(string $comedian)
    {
        $attractions = $this->repo->getAttractionsByComedian($comedian);

        foreach ($attractions as $attraction) {

            $serialize = new AttractionResponse(
                $attraction['id'],
                $attraction['title'],
                $attraction['date'],
                $attraction['artist']
            );

            $response[] = $serialize;
        }
        return $response;
    }
}
