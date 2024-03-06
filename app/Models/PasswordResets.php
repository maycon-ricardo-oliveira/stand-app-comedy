<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    use HasFactory;

    protected $table = 'password_resets';

    protected $connection = 'mysql';

    protected $primaryKey = 'email';

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

}
