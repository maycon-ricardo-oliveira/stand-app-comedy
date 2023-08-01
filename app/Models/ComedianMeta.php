<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComedianMeta extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comedian_metas';

    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = ['id', 'comedian_id', 'name', 'value', 'created_at', 'updated_at'];

}
