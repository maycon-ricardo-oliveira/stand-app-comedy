<?php

namespace App\Chore\Infra\MySql;

interface DBConnection
{
    public function query(string $statement, array $params);
    public function close(): void;

}
