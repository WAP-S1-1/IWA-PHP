<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $table = 'station';
    protected $primaryKey = 'name';
    public $incrementing = false; // primary key is string
    public $timestamps = false;

    protected $fillable = [
        'name',
        'longitude',
        'latitude',
        'elevation',
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
}

