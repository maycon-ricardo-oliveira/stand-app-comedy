<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Domain\AttractionRepository;

class AttractionDAODatabase implements AttractionRepository
{
    const EARTH_RADIUS_IN_KM = 6371;

    private DBConnection $connection;

    public function __construct(DBConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAttractionsInAPlace(string $place)
    {
        $query = "SELECT * FROM attractions WHERE attractions.place = :place";
        $params = ['place' => $place];

        return $this->connection->query($query, $params);

    }

    public function getPlacesByLocation(string $lat, string $long, int $distance, int $limit = 100)
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
        return $this->connection->query($query, $params);

    }
}
