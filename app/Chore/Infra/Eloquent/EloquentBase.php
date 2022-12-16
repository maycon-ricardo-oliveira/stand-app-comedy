<?php

namespace App\Chore\Infra\Eloquent;

use App\Chore\Infra\MySql\DBConnection;

abstract class EloquentBase
{

    public  DBConnection $connection;

    abstract public function __construct(DBConnection $connection);

    public function getModel() {
        return $this->connection->model;
    }

    protected function query()
    {
        return $this->getModel()->query();
    }
}
