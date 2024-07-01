<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class AttractionClassification extends Model
{
    use HasUlids;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attraction_metas';

    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = ['id', 'name', 'image', 'created_at', 'updated_at'];

}
