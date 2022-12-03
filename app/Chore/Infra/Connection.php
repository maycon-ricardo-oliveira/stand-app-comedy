<?php

namespace App\Chore\Infra;

interface Connection
{
    public function query(string $statement, array $params);
    public function close(): void;

}