<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BannerMeta extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'banner_meta';
    protected $connection = 'mysql';

    protected $fillable = [
        'banner_id',
        'name',
        'value'
    ];

    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banners::class);
    }
}
