<?php

namespace App\Chore\Infra\MySql;

interface Connection
{
    public function query(string $statement, array $params);
    public function close(): void;

}