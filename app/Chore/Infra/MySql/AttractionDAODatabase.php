<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Domain\AttractionRepository;
use App\Chore\Domain\IDateTime;
use App\Chore\Infra\AttractionMapper;

class AttractionDAODatabase extends AttractionMapper implements AttractionRepository
{
    const EARTH_RADIUS_IN_KM = 6371;

    private DBConnection $connection;

    public IDateTime $time;

    public function __construct(DBConnection $connection, IDateTime $time)
    {
        parent::__construct();
        $this->connection = $connection;
        $this->time = $time;
    }

    public function getAttractionsInAPlace(string $place)
    {
        $query = "select a.*, p.*, c.*,
                p.name as placeName,
                c.name as comedianName,
                c.mini_bio as miniBio
            from attractions a
            inner join places p on p.id = a.place_id
            inner join comedians c on c.id = a.comedian_id
            where p.name = :place";
        $params = ['place' => $place];

        $attractionsData = $this->connection->query($query, $params);
        return $this->mapper($this->time, $attractionsData);

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

        $query = "select a.*, p.*, c.*,
                p.name as placeName,
                c.name as comedianName,
                c.mini_bio as miniBio,
                :earthRadiusInKM * 2 * ASIN(SQRT( POWER(SIN((:lat -  lat)*pi()/180/2),2)
                    +COS(:lat*pi()/180) * COS(lat*pi()/180) * POWER(SIN((:lng-lng) * pi()/180/2),2))
                ) as distance
            from attractions a
            inner join places p on a.place_id = p.id
            inner join comedians c on c.id = a.comedian_id
            where
                lng between (:lng-20/cos(radians(:lat))*69)
                and  (:lng+20/cos(radians(:lat))*69)
                and lat between  (:lat-(20/69))
                and  (:lat +(20/69))
            having  distance <= :maxDistance order by distance limit 100;";

        $attractionsData = $this->connection->query($query, $params);
        return $this->mapper($this->time, $attractionsData);

    }

    public function getAttractionsByComedian(string $comedian)
    {
        $comedian = '%' . $comedian . '%';

        $query = "select a.*, p.*, c.*,
                p.name as placeName,
                c.name as comedianName,
                c.mini_bio as miniBio
            from attractions a
            inner join places p on p.id = a.place_id
            inner join comedians c on c.id = a.comedian_id
            where c.name like :comedian ";

        $params = ['comedian' => $comedian];

        $attractionsData = $this->connection->query($query, $params);
        return $this->mapper($this->time, $attractionsData);

    }

}
