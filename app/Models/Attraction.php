<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attractions';

    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = ['id', 'title', 'date', 'place', 'artist'];

}