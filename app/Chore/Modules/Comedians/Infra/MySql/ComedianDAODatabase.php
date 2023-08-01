<?php

namespace App\Chore\Modules\Comedians\Infra\MySql;

use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\MySqlAdapter\DBConnection;
use App\Chore\Modules\Comedians\Entities\Comedian;
use App\Chore\Modules\Comedians\Entities\ComedianMeta;
use App\Chore\Modules\Comedians\Entities\ComedianRepository;
use App\Chore\Modules\Comedians\Exceptions\InvalidComedianMetaException;
use App\Chore\Modules\Comedians\Infra\ComedianMapper;

class ComedianDAODatabase implements ComedianRepository
{

    private DBConnection $connection;

    public IDateTime $time;

    public function __construct(DBConnection $connection, IDateTime $time)
    {
        $this->connection = $connection;
        $this->time = $time;
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

        if (count($comedianData) == 0) {
            return null;
        }

        $data = $this->mapper($comedianData);
        return $data[0];
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

        if (count($comedianData) == 0) {
            return null;
        }

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

        if (count($comedianData) == 0) {
            return null;
        }

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

    public function registerMeta(ComedianMeta $comedianMeta): bool
    {

        $query = "INSERT INTO comedian_metas (id, comedian_id, name, value, created_at, updated_at)
                  VALUES (:id, :comedian_id, :name, :value, :created_at, :updated_at)";

        $params = [
            "id" => $comedianMeta->id,
            "comedian_id" => $comedianMeta->comedianId,
            "name" => $comedianMeta->name,
            "value" => $comedianMeta->value,
            "created_at" => $this->time->format('Y-m-d H:i:s'),
            "updated_at" => $this->time->format('Y-m-d H:i:s'),
        ];

        $this->connection->query($query, $params);
        return true;
    }

    /**
     * @throws InvalidComedianMetaException
     */
    public function getComedianMetas(string $id): array
    {

        $query = "select * from comedian_metas cm where cm.comedian_id = :comedian_id";
        $params = ['comedian_id' => $id];

        $comedianMetaData = $this->connection->query($query, $params);

        $response = [];

        if (count($comedianMetaData) == 0) {
            return [];
        }

        foreach ($comedianMetaData as $item) {
            $meta = new ComedianMeta(
                $item['id'],
                $item['comedian_id'],
                $item['name'],
                $item['value'],
            );
            $response[] = $meta;
        }
        return $response;
    }

    public function getAllComedians()
    {
        $query = "SELECT  c.*,
                c.name as comedianName,
                c.mini_bio as miniBio,
                cm.value as onFire,
                cmedia.src as imageMain

                FROM comedians c
                LEFT JOIN comedian_metas cm on cm.comedian_id = c.id and cm.name = 'onFire'
                LEFT JOIN comedian_media cmedia on cmedia.comedian_id = c.id and cmedia.name = 'image_main'
                ";

        $comedianData = $this->connection->query($query);

        if (count($comedianData) == 0) {
            return null;
        }

        $data = $this->mapper($comedianData);

        return count($data) == 0 ? null : $data;
    }

    public function mapper($comediansData = [])
    {

        if ($comediansData == []) {
            return $comediansData;
        }

        return array_map(function ($item) {
            $metas = $this->getComedianMetas($item['id']);

            return new Comedian(
                $item['id'],
                $item['name'],
                $item['miniBio'],
                $item['thumbnail'] ?? '',
                $item['imageMain'] ?? '',
                $item['onFire'] ?? false,
                $metas ?? [],
                $item['socialMedias'] ?? []
            );
        }, $comediansData);
    }
}
