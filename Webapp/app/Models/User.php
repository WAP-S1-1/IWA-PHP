<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'first_name',
        'initials',
        'prefix',
        'email',
        'employee_code',
        'user_role',
        'password',
    ];

    /**
     * Hide sensitive fields
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relationship: user belongs to a role
     */
    public function role()
    {
        return $this->belongsTo(Userrole::class, 'user_role', 'id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * Check if the user has a specific role name
     *
     * @param string|array $role
     * @return bool
     */
    public function hasRole(string|array $role): bool
    {
        if (!$this->role) {
            return false;
        }

        if (is_array($role)) {
            return in_array($this->role->role, $role);
        }

        return $this->role->role === $role;
    }

}
