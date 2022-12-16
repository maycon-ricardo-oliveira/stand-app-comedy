<?php

namespace App\Chore\UseCases\ListAttractionsByLocation;

use App\Chore\Domain\AttractionRepository;
use App\Chore\UseCases\ListAttractions\AttractionResponse;

class ListAttractionsByLocation
{

    // https://www.anycodings.com/1questions/279869/find-nearest-latitudelongitude-with-an-sql-query

    private AttractionRepository $attractionRepo;

    /**
     * @param AttractionRepository $attractionRepo
     */
    public function __construct(AttractionRepository $attractionRepo)
    {
        $this->attractionRepo = $attractionRepo;
    }


    public function handle(string $lat, string $long): array
    {
        $attractionsData = $this->attractionRepo->getPlacesByLocation($lat, $long, 10);

        return $attractionsData;
    }

}
