<?php

namespace App\Chore\Infra\Eloquent;

use App\Chore\Domain\AttractionRepository;
use App\Chore\Infra\MySql\DBConnection;

class AttractionRepositoryDatabase extends EloquentBase implements AttractionRepository
{

    const EARTH_RADIUS_IN_KM = 6371;

    public DBConnection $connection;

    public function __construct(DBConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAttractionsInAPlace(string $place)
    {
        $query = $this->query()->where(['place' => $place])->toSql();
        return $this->connection->query($query, ['place' => $place]);
    }

    public function getPlacesByLocation(string $lat, string $long, int $distance, int $limit = 20)
    {

        $origLat = $lat;
        $origLon = $long;
        $dist = $distance;
        $earthRadiusInKM = self::EARTH_RADIUS_IN_KM;

        $query = "
             SELECT places.id,
                   name,
                   lat,
                   lng,
                   6371 * 2 * ASIN(SQRT( POWER(SIN(('-23.544662' -  lat)*pi()/180/2),2)
                        +COS('-23.544662'*pi()/180  )*COS(lat*pi()/180)
                                   *POWER(SIN(('-46.5804355'-lng)*pi()/180/2),2))) as distance

            FROM places
              WHERE
                  lng between  ('-46.5804355'-20/cos(radians('-23.544662'))*69)
                      and  ('-46.5804355'+20/cos(radians('-23.544662'))*69)
                and lat between  ('-23.544662'-(20/69))
                  and  ('-23.544662' +(20/69))
              having  distance < 20 ORDER BY distance limit 100;
";

        return $this->connection->query($query, []);
    }
}
