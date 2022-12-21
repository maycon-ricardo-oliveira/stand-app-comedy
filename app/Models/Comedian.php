<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *   schema="ComedianResponse",
 *   description="Comedian",
 *   title="Comedian Schema",
 *   @OA\Property(property="id", type="string", description="The place id"),
 *   @OA\Property(property="name", type="string", description="The place id"),
 *   @OA\Property(property="miniBio", type="string", description="The place id"),
 *   @OA\Property(property="socialMedias", type="string", description="The place id"),
 *   @OA\Property(property="attractions", type="string", description="The place id"),
 * )
 */

class Comedian extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comedians';

    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = ['id', 'name', 'seats', 'mini_bio', 'created_at', 'updated_at'];

    public function attractions(): HasMany
    {
        return $this->hasMany(Attraction::class);
    }

}
