<?php

namespace App\Chore\Adapters;

use App\Chore\Infra\MySql\DBConnection;
use PDO;

class MySqlAdapter implements DBConnection
{

    public $connection;

    public function __construct()
    {
        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $database = env('DB_DATABASE');
        $this->connection = new PDO("mysql:host={$host}:{$port};dbname={$database}", env('DB_USERNAME'), env('DB_PASSWORD'));
    }

    public function query(string $statement, array $params = [])
    {

        $stmt = $this->connection->prepare($statement);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function close(): void
    {
        $this->connection = null;
    }
}
