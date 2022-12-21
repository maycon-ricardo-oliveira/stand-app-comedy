<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attraction extends Model
{

    use HasUlids;
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
    protected $fillable = ['id', 'title', 'date', 'place', 'duration', 'place_id', 'comedian_id', 'created_at', 'updated_at'];

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    public function comedian(): BelongsTo
    {
        return $this->belongsTo(Comedian::class, 'comedian_id', 'id');
    }

}
