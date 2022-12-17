<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    protected $fillable = ['id', 'title', 'date', 'place', 'artist', 'place_id'];

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

}
