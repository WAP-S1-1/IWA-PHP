<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    public $timestamps = false;

    protected $fillable = [
        'company',
        'type',
        'start_date',
        'end_date',
        'price',
        'notes',
        'identifier',
        'token',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'float',
    ];

    public function stations()
    {
        return $this->belongsToMany(
            Station::class,
            'subscription_station',
            'subscription',
            'station',
            'id',
            'name'
        );
    }

    public function companyRelation(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company');
    }

    public function subscriptionType(): BelongsTo
    {
        return $this->belongsTo(SubscriptionType::class, 'type');
    }
}
