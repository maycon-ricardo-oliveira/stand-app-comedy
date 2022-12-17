<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Place extends Model
{

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
    protected $fillable = ['id', 'name', 'address', 'zipcode', 'lat', 'lng'];

    public function attractions(): HasMany
    {
        return $this->hasMany(Attraction::class);
    }
}
