<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchases';

    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = ['id', 'ticket_id', 'user_id', 'payment_gateway_id', 'payment_profile_id', 'price', 'external_id', 'purchase_date', 'payment_date', 'status', 'src', 'created_at', 'updated_at'];

}
