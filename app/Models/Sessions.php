<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="SessionResponse",
 *   description="Session",
 *   title="Session Schema",
 *   @OA\Property(property="id", type="string", description="The id name"),
 *   @OA\Property(property="attraction_id", type="string", description="The attraction_id name"),
 *   @OA\Property(property="session_code", type="string", description="The session_code name"),
 *   @OA\Property(property="tickets", type="string", description="The tickets name"),
 *   @OA\Property(property="tickets_sold", type="string", description="The tickets_sold name"),
 *   @OA\Property(property="tickets_validated", type="string", description="The tickets_validated name"),
 *   @OA\Property(property="start_at", type="string", description="The start_at name"),
 *   @OA\Property(property="finish_at", type="string", description="The finish_at name"),
 *   @OA\Property(property="status", type="string", description="The status name"),
 *   @OA\Property(property="created_at", type="string", description="The created_at name"),
 *   @OA\Property(property="updated_at", type="string", description="The updated_at name"),
 * )
 */

class Sessions extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sessions';

    protected $connection = 'mysql';

    /**
     * @var array
     */
    protected $fillable = ['id', 'attraction_id', 'session_code', 'tickets', 'tickets_sold', 'tickets_validated', 'start_at', 'finish_at', 'status', 'created_at', 'updated_at'];

}
