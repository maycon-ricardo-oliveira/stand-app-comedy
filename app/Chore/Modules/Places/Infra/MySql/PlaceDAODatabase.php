<?php

namespace App\Chore\Modules\Places\Infra\MySql;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\MySqlAdapter\DBConnection;
use App\Chore\Modules\Places\Entities\Place;
use App\Chore\Modules\Places\Entities\PlaceRepository;
use App\Chore\Modules\Places\Infra\PlaceMapper;

class PlaceDAODatabase extends PlaceMapper implements PlaceRepository
{

    private DBConnection $connection;
    private IDateTime $time;

    public function __construct(DBConnection $connection, IDateTime $time)
    {
        parent::__construct();
        $this->connection = $connection;
        $this->time = $time;
    }

    public function getPlaceById(string $id)
    {
        $query = "select * from places p where p.id = :id";
        $params = ['id' => $id];

        $userData = $this->connection->query($query, $params);

        $data = $this->mapper($userData);

        return count($data) == 0 ? null : $data[0];
    }

    public function register(Place $place): bool
    {
        $query = "INSERT INTO places ( id,name,seats,address,zipcode,image,lat,lng,created_at,updated_at)
                  VALUES (:id,:name,:seats,:address,:zipcode,:image,:lat,:lng,:created_at,:updated_at)";
        $params = [
            "id" => $place->id,
            "name" => $place->name,
            "seats" => $place->seats,
            "address" => $place->address,
            "zipcode" => $place->zipcode,
            "image" => $place->image->url ?? '',
            "lat" => $place->lat,
            "lng" => $place->lng,
            "created_at" => $this->time->format('Y-m-d H:i:s'),
            "updated_at" => $this->time->format('Y-m-d H:i:s'),
        ];
        $this->connection->query($query, $params);
        return true;
    }

    public function getPlaceByName(string $name): ?Place
    {
        $place = '%' . $name . '%';
        $query = "select *
            from places p
            where p.name like :name";

        $params = ['name' => $place];
        $placeData = $this->connection->query($query, $params);

        if (count($placeData) == 0) {
            return null;
        }

        $data = $this->mapper($placeData);

        return count($data) == 0 ? null : $data[0];
    }
}
