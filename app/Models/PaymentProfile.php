<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentProfile extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_profiles';

    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'token', 'flag', 'last_four_digits', 'payment_type', 'created_at', 'updated_at'];

}
