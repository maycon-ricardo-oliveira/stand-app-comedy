<?php

namespace App\Chore\Adapters;

use App\Chore\Infra\MySql\DBConnection;
use Illuminate\Database\Eloquent\Model;

class EloquentAdapter implements DBConnection
{

    public Model $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function query(string $statement, array $params)
    {
        return $this->model->query();
    }

    public function close(): void
    {
        $this->model->setConnection(null);
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
