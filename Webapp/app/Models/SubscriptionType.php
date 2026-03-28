<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionType extends Model
{
    protected $table = 'subscription_types';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'nr_stations',
        'frequency_in_hours',
        'frequency_in_days',
        'continuous',
        'price_per_station',
        'valid_through',
    ];

    protected $casts = [
        'nr_stations' => 'integer',
        'frequency_in_hours' => 'integer',
        'frequency_in_days' => 'integer',
        'continuous' => 'boolean',
        'price_per_station' => 'float',
        'valid_through' => 'date',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'type');
    }
}
