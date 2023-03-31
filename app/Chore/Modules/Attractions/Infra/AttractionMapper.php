<?php

namespace App\Chore\Modules\Attractions\Infra;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\Comedian;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\Place;
use App\Chore\Modules\Attractions\Entities\Attraction;
use ArrayIterator;
use Exception;

class AttractionMapper extends ArrayIterator {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function mapper(IDateTime $time, $attractionsData = [])
    {
        return $attractionsData == [] ? $attractionsData : array_map(function ($item) use ($time) {
            return new Attraction(
                $item['attractionId'],
                $item['title'],
                new DateTimeAdapter($item['date']),
                $item["duration"],
                new Comedian(
                    $item['comedianId'],
                    $item['comedianName'],
                    $item['miniBio'],
                    $item['socialMedias'] ?? [],
                    $item['attractions'] ?? [],
                ),
                new Place(
                    $item['placeId'],
                    $item['placeName'],
                    $item['seats'],
                    $item['address'],
                    $item['zipcode'],
                    $item['lat'],
                    $item['lng'],
                    $item['distance'] ?? 0,
                ),
                $item['status'],
                $item['owner'],
                $time
            );

        }, $attractionsData);

    }

}
