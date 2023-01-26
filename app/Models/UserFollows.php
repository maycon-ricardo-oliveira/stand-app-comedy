<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFollows extends Model
{
    protected $table = 'user_follows';

    protected $connection = 'mysql';

    protected $fillable = ['id', 'comedian_id', 'user_id', 'created_at', 'updated_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comedian(): BelongsTo
    {
        return $this->belongsTo(Comedian::class, 'comedian_id', 'id');
    }
}
