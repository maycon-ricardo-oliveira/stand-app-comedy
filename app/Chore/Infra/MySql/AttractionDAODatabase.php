<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Domain\AttractionRepository;

class AttractionDAODatabase implements AttractionRepository
{

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
            'distance' => $distance,
            'limit' => $limit,
        ];

        $query = "
             SELECT places.id,
                   name,
                   lat,
                   lng,
                   6371 * 2 * ASIN(SQRT( POWER(SIN((:lat -  lat)*pi()/180/2),2)
                        +COS(:lat*pi()/180  )*COS(lat*pi()/180)
                                   *POWER(SIN((:lng-lng)*pi()/180/2),2))) as distance

            FROM places
              WHERE
                  lng between  (:lng-20/cos(radians(:lat))*69)
                      and  (:lng+20/cos(radians(:lat))*69)
                and lat between  (:lat-(20/69))
                  and  (:lat +(20/69))
              having  distance <= :distance ORDER BY distance limit :limit;
";
        return $this->connection->query($query, $params);

    }
}
