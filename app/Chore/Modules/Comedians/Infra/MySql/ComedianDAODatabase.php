<?php

namespace App\Chore\Modules\Comedians\Infra\MySql;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\MySqlAdapter\DBConnection;
use App\Chore\Modules\Comedians\Entities\ComedianRepository;
use App\Chore\Modules\Comedians\Infra\ComedianMapper;

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


    public function getListOfComedians(array $comedianIds)
    {
        $query = "SELECT  c.*,
                c.name as comedianName,
                c.mini_bio as miniBio FROM comedians c WHERE 1=0 ";
        if (!empty($comedianIds)) {
            $query .= "OR id IN (" . implode(",", array_fill(0, count($comedianIds), "?")) . ")";
        }

        $comedianData = $this->connection->query($query, $comedianIds);

        $data = $this->mapper($comedianData);

        return count($data) == 0 ? null : $data;
    }
}
