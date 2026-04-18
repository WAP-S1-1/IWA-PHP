<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CriteriumType extends Model
{
    protected $table = 'criterium_type';
    public $timestamps = false;

    protected $fillable = [
        'omschrijving',
        'referenced_table',
        'referenced_field',
    ];

    public function criteriumGroups(): HasMany
    {
        return $this->hasMany(CriteriumGroup::class, 'type');
    }
}
