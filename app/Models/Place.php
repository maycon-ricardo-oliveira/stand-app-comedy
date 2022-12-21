<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
