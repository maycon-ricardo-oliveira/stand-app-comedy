<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sessions';

    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = ['id', 'attraction_id', 'session_code', 'tickets', 'tickets_sold', 'tickets_validated', 'start_at', 'finish_at', 'status', 'created_at', 'updated_at'];

}
