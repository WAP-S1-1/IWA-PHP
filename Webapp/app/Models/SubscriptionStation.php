<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionStation extends Model
{
    protected $table = 'subscription_station';

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = null;

    protected $fillable = [
        'subscription',
        'station',
    ];

    public function subscriptionRelation(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription');
    }

    public function stationRelation(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'station', 'name');
    }
}
