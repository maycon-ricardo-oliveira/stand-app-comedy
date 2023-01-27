<?php

namespace App\Chore\Infra\MySql;

use App\Chore\Domain\Comedian;
use App\Chore\Domain\ComedianRepository;
use App\Chore\Domain\IDateTime;
use App\Chore\Domain\User;
use App\Chore\Infra\ComedianMapper;

class ComedianDAODatabase extends ComedianMapper implements ComedianRepository
{

    private DBConnection $connection;

    public IDateTime $time;

    public function __construct(DBConnection $connection, IDateTime $time)
    {

        $this->connection = $connection;
        $this->time = $time;
        parent::__construct();
    }

    public function getComedianById(string $id)
    {
        $query = "select
                c.*,
                c.name as comedianName,
                c.mini_bio as miniBio
            from comedians c
            where c.id = :id";
        $params = ['id' => $id];

        $comedianData = $this->connection->query($query, $params);

        $data = $this->mapper($comedianData);

        return count($data) == 0 ? null : $data[0];
    }

}
