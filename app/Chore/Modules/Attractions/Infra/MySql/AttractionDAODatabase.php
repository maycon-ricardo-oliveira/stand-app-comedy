<?php

namespace App\Chore\Modules\Attractions\Infra\MySql;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\MySqlAdapter\DBConnection;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Entities\AttractionRepository;
use App\Chore\Modules\Attractions\Infra\AttractionMapper;

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
                a.id as attractionId,
                p.name as placeName,
                c.name as comedianName,
                c.mini_bio as miniBio,
                a.owner_id as owner,
                a.duration as duration,
                c.id as comedianId,
                p.id as placeId
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
                a.id as attractionId,
                p.name as placeName,
                c.name as comedianName,
                c.mini_bio as miniBio,
                a.owner_id as owner,
                c.id as comedianId,
                p.id as placeId,
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

    public function getAttractionsByComedianName(string $comedianName)
    {
        $comedian = '%' . $comedianName . '%';

        $query = "select a.*, p.*, c.*,
                a.id as attractionId,
                p.name as placeName,
                c.id as comedianId,
                c.name as comedianName,
                c.mini_bio as miniBio,
                a.owner_id as owner,
                p.id as placeId

            from attractions a
            inner join places p on p.id = a.place_id
            inner join comedians c on c.id = a.comedian_id
            where c.name like :comedian ";

        $params = ['comedian' => $comedian];

        $attractionsData = $this->connection->query($query, $params);
        return $this->mapper($this->time, $attractionsData);

    }
    public function getAttractionsByComedianId(string $comedianId)
    {
        $query = "select a.*, p.*, c.*,
                a.id as attractionId,
                c.id as comedianId,
                c.mini_bio as miniBio,
                a.owner_id as owner,
                p.id as placeId,
                p.name as placeName

            from attractions a
            inner join places p on p.id = a.place_id
            inner join comedians c on c.id = a.comedian_id
            where c.id = :comedian ";

        $params = ['comedian' => $comedianId];

        $attractionsData = $this->connection->query($query, $params);
        return $this->mapper($this->time, $attractionsData);

    }

    public function registerAttraction(Attraction $attractionData, IDateTime $date): bool
    {

        $query = "INSERT INTO attractions (id,
                         title, date,
                         duration, status,
                         comedian_id, place_id,
                         owner_id,
                         created_at, updated_at)
                  VALUES ( :id, :title,:date,:duration,:status,:comedian_id,:place_id,:owner_id,:created_at,:updated_at)";

        $params = [
            "id" => $attractionData->id,
            "title" => $attractionData->title,
            "date" => $attractionData->date->format('Y-m-d H:i:s'),
            "duration" => $attractionData->duration,
            "status" => $attractionData->status,
            "comedian_id" => $attractionData->comedian->id,
            "place_id" => $attractionData->place->id,
            "owner_id" => $attractionData->owner,
            "created_at" => $date->format('Y-m-d H:i:s'),
            "updated_at" => $date->format('Y-m-d H:i:s'),
        ];

        $this->connection->query($query, $params);
        return true;

    }

    public function findAttractionById(string $attractionId): ?Attraction
    {
        $query = "select
                a.id as attractionId,
                p.name as placeName,
                c.name as comedianName,
                c.id as comedianId,
                c.mini_bio as miniBio,
                a.owner_id as owner,
                p.id as placeId,
                a.*, p.*, c.*
            from attractions a
            inner join places p on p.id = a.place_id
            inner join comedians c on c.id = a.comedian_id
            where a.id = :id ";

        $params = ['id' => $attractionId];

        $attractionsData = $this->connection->query($query, $params);

        $data = $this->mapper($this->time, $attractionsData);

        return count($data) == 0 ? null : $data[0];
    }
}
