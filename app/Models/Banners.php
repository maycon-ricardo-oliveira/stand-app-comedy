<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'banners';
    protected $connection = 'mysql';

    protected $fillable = [
        'id',
        'name',
        'image',
        'url',
        'status',
        'type',
        'screen',
        'start_date',
        'end_date'
    ];

}
