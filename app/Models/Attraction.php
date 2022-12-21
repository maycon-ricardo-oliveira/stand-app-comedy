<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *   schema="AttractionResponse",
 *   description="Attraction",
 *   title="Attraction Schema",
 *   @OA\Property(property="id", type="string", description="The place id"),
 *   @OA\Property(property="title", type="string", description="The place name"),
 *   @OA\Property(property="date", type="object", ref="#/components/schemas/DateTimeResponse"),
 *   @OA\Property(property="comedian", type="object", ref="#/components/schemas/ComedianResponse"),
 *   @OA\Property(property="place", type="object", ref="#/components/schemas/PlaceResponse"),
 *   @OA\Property(property="timeToEvent", type="string", description="The place address"),
 * )
 */

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
