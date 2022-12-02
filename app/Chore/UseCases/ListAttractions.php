<?php

namespace App\Chore\UseCases;

use App\Chore\Domain\Attraction;
use App\Chore\Domain\AttractionDAO;

class ListAttractions
{

    /**
     * @var AttractionDAO
     */
    private $attractionDAO;

    public function __construct(AttractionDAO $attractionDAO)
    {
        $this->attractionDAO = $attractionDAO;
    }

    public function handle($place)
    {
        $attractionsData = $this->attractionDAO->getAttractionsInAPlace($place);

        $response = [];

        foreach ($attractionsData as $attraction) {

            $serialize = new Attraction(
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