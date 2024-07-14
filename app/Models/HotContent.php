<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotContent extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hot_contents';

    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = ['id', 'content_type', 'content_id', 'created_at', 'updated_at'];
}
