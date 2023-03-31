<?php

namespace App\Chore\Modules\Adapters\EloquentAdapter;

use App\Chore\Modules\Adapters\MySqlAdapter\DBConnection;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentBase
{

    public  DBConnection $connection;

    abstract public function __construct(DBConnection $connection);

    public function getModel():Model {
        return $this->connection->model;
    }

    protected function query()
    {
        return $this->getModel()->query();
    }
}
