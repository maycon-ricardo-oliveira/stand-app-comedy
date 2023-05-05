<?php

namespace App\Chore\Modules\Comedians\Infra\MySql;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\MySqlAdapter\DBConnection;
use App\Chore\Modules\Comedians\Entities\Comedian;
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

    public function getComedianById(string $id): ?Comedian
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

    public function getComedianByName(string $name): ?Comedian
    {
        $comedian = '%' . $name . '%';
        $query = "select
                c.*,
                c.name as comedianName,
                c.mini_bio as miniBio
            from comedians c
            where c.id like :name";

        $params = ['name' => $comedian];
        $comedianData = $this->connection->query($query, $params);
        $data = $this->mapper($comedianData);

        return count($data) == 0 ? null : $data[0];
    }

    public function register(Comedian $comedian): bool
    {

       $query = "INSERT INTO comedians (id, name, mini_bio, thumbnail, created_at, updated_at)
                  VALUES (:id, :name, :mini_bio, :thumbnail, :created_at, :updated_at)";

        $params = [
            "id" => $comedian->id,
            "name" => $comedian->name,
            "mini_bio" => $comedian->miniBio,
            "thumbnail" => $comedian->thumbnail,
            "created_at" => $this->time->format('Y-m-d H:i:s'),
            "updated_at" => $this->time->format('Y-m-d H:i:s'),
        ];

        $this->connection->query($query, $params);
        return true;
    }
}
