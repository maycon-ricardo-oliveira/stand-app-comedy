<?php

namespace App\Chore\UseCases\ListAttractionsByLocation;

use App\Chore\Domain\AttractionRepository;
use App\Chore\UseCases\ListAttractions\AttractionWithLocation;
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


    public function handle(string $lat, string $long, int $distance, $limit = 100): array
    {
        $attractionsData = $this->attractionRepo->getPlacesByLocation($lat, $long, $distance, $limit);


        $response = [];

        if ($attractionsData == null) {
            return [];
        }

        foreach ($attractionsData as $item) {

            $serialize = new AttractionWithLocation(
                $item['id'],
                $item['artist'],
                $item['place'],
                $item['date'],
                $item['title'],
                $item['place_id'],
                $item['name'],
                $item['address'],
                $item['zipcode'],
                $item['lat'],
                $item['lng'],
                $item['distance'],
            );

            $response[] = $serialize;
        }

        return $response ?? [];
    }

}
