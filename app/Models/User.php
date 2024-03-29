<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(
 *   schema="UserResponse",
 *   description="User",
 *   title="User Schema",
 *   @OA\Property(property="id", type="string", description="The place id"),
 *   @OA\Property(property="name", type="string", description="The place id"),
 *   @OA\Property(property="email", type="string", description="The place id"),
 * )
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject

{
    use Authenticatable, HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'email_verified_at', 'password', 'remember_token', 'google_id', 'facebook_id', 'apple_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $keyType = 'string';


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function can($abilities, $arguments = [])
    {
    }

    public function followingComedians(): HasMany
    {
        return $this->hasMany(UserFollows::class, 'user_id');
    }

}
