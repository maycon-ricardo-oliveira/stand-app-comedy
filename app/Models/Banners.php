<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banners extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'banner';
    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'url',
        'active',
        'type',
        'start_date',
        'end_date'
    ];

    public function bannerMeta(): HasMany
    {
        return $this->hasMany(BannerMeta::class);
    }

}
