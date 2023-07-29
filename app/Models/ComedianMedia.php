<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComedianMedia extends Model
{
    use HasFactory;
    use HasUuids;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comedian_media';

    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = ['id', 'comedian_id', 'name', 'src', 'src_thumb', 'url', 'type', 'created_at', 'updated_at'];

}
