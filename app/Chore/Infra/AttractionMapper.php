<?php

namespace App\Chore\Infra;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\Attraction;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\Place;
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
                $item['id'],
                $item['title'],
                new DateTimeAdapter($item['date']),
                $time,
                $item['artist'],
                new Place(
                    $item['place_id'],
                    $item['name'],
                    $item['address'],
                    $item['zipcode'],
                    $item['lat'],
                    $item['lng'],
                    $item['distance'] ?? 0,
                )
            );

        }, $attractionsData);

    }

}
