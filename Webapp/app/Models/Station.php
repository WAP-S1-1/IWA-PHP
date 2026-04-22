<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    // status constanten
    const STATUS_ONLINE = 'online';
    const STATUS_ERROR = 'error';
    const STATUS_OFFLINE = 'offline';


    protected $table = 'station';
    protected $primaryKey = 'name';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'longitude',
        'latitude',
        'elevation',
        'status',
    ];

    protected $casts = [
        'status_updated_at' => 'datetime'
    ];

    public function measurements()
    {
        return $this->hasMany(Measurement::class, 'station', 'name');
    }

    // TODO: I'm not sure if there's only one station per geolocation.
    public function geolocations()
    {
        return $this->hasMany(Geolocation::class, 'station_name', 'name');
    }

    public function subscriptions()
    {
        return $this->belongsToMany(
            Subscription::class,
            'subscription_station',
            'station',
            'subscription',
            'name',
            'id'
        );
    }

    public function latestMeasurement()
    {
        return $this->hasOne(Measurement::class, 'station', 'name')
            ->latest('date')
            ->latest('time');
    }
}

