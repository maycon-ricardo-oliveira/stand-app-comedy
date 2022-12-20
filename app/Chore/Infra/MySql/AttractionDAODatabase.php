<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Domain\Attraction;
use App\Chore\Domain\AttractionRepository;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\Place;

class AttractionDAODatabase implements AttractionRepository
{
    const EARTH_RADIUS_IN_KM = 6371;

    private DBConnection $connection;
    private IDateTime $time;

    public function __construct(DBConnection $connection, IDateTime $time)
    {
        $this->connection = $connection;
        $this->time = $time;
    }

    public function getAttractionsInAPlace(string $place)
    {
        $query = "SELECT * FROM attractions WHERE attractions.place = :place";
        $params = ['place' => $place];

        return $this->connection->query($query, $params);

    }

    /**
     * @throws \Exception
     */
    public function getPlacesByLocation(string $lat, string $long, int $distance, int $limit = 100): array
    {
        $params = [
            'lat' => $lat,
            'lng' => $long,
            'maxDistance' => $distance,
            'limit' => $limit,
            'earthRadiusInKM' => self::EARTH_RADIUS_IN_KM
        ];

        $query = "SELECT
            a.*,
            p.*,
           :earthRadiusInKM * 2 * ASIN(SQRT( POWER(SIN((:lat -  lat)*pi()/180/2),2)
                +COS(:lat*pi()/180) * COS(lat*pi()/180) * POWER(SIN((:lng-lng) * pi()/180/2),2))
            ) as distance
            FROM attractions a
            INNER JOIN places p on a.place_id = p.id
            WHERE
                lng between (:lng-20/cos(radians(:lat))*69)
                and  (:lng+20/cos(radians(:lat))*69)
                and lat between  (:lat-(20/69))
                and  (:lat +(20/69))
            having  distance <= :maxDistance ORDER BY distance limit 100;";

        $attractionsData = $this->connection->query($query, $params);
        return $this->attractionMapper($attractionsData);

    }

    public function getAttractionsByComedian(string $comedian)
    {
        $comedian = '%' . $comedian . '%';
        // TODO: Inner join with comedians
        $query = "SELECT * FROM attractions
        inner join places on places.id = attractions.place_id
         WHERE attractions.artist like :comedian ";
        $params = ['comedian' => $comedian];

        $attractionsData = $this->connection->query($query, $params);

        return $this->attractionMapper($attractionsData);

    }

    private function attractionMapper($attractionsData = [])
    {
        if ($attractionsData == []) {
            return [];
        }

        return array_map(function($item) {
            return [
                new Attraction(
                    $item['id'],
                    $item['artist'],
                    new DateTimeAdapter($item['date']),
                    $this->time,
                    $item['title'],
                    new Place(
                        $item['place_id'],
                        $item['name'],
                        $item['address'],
                        $item['zipcode'],
                        $item['lat'],
                        $item['lng'],
                        $item['distance'] ?? 0,
                    )
                )
            ];

        }, $attractionsData);

    }
}
