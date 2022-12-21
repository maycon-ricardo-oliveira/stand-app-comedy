<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *   schema="PlaceResponse",
 *   description="Place",
 *   title="Place Schema",
 *   @OA\Property(property="id", type="string", description="The place id"),
 *   @OA\Property(property="name", type="string", description="The place id"),
 *   @OA\Property(property="seats", type="int", description="The place id"),
 *   @OA\Property(property="address", type="string", description="The place id"),
 *   @OA\Property(property="zipcode", type="string", description="The place id"),
 *   @OA\Property(property="lat", type="string", description="The place id"),
 *   @OA\Property(property="lng", type="string", description="The place id"),
 *   @OA\Property(property="distance", type="string", description="The place id"),
 * )
 */

class Place extends Model
{

    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'places';

    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = ['id', 'name', 'seats', 'address', 'zipcode', 'lat', 'lng', 'created_at', 'updated_at'];

    public function attractions(): HasMany
    {
        return $this->hasMany(Attraction::class);
    }
}
