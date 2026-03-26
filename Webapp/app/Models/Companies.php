<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $table = 'companies';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'city',
        'street',
        'number',
        'number_additional',
        'zip_code',
        'country',
        'email',
    ];

    protected $casts = [
        'number' => 'integer',
    ];

    public function countryRelation(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country', 'country_code');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'company');
    }
}
