<?php

namespace App\Chore\Modules\Places\Infra\MySql;

use App\Chore\Modules\Adapters\MySqlAdapter\DBConnection;
use App\Chore\Modules\Places\Entities\PlaceRepository;
use App\Chore\Modules\Places\Infra\PlaceMapper;

class PlaceDAODatabase extends PlaceMapper implements PlaceRepository
{

    private DBConnection $connection;

    public function __construct(DBConnection $connection)
    {
        parent::__construct();
        $this->connection = $connection;
    }

    public function getPlaceById(string $id)
    {
        $query = "select * from places p where p.id = :id";
        $params = ['id' => $id];

        $userData = $this->connection->query($query, $params);

        $data = $this->mapper($userData);

        return count($data) == 0 ? null : $data[0];
    }
}
