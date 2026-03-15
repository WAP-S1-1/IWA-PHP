<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userrole extends Model
{
    use HasFactory;

    // Explicitly define the table name
    protected $table = 'userroles';

    // Primary key
    protected $primaryKey = 'id';

    // Mass assignable attributes
    protected $fillable = [
        'role',
        'description',
    ];

    // Disable timestamps if not used
    public $timestamps = false;

    /**
     * Get the users that belong to this role.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'user_role', 'id');
    }
}
