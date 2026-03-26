<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model


{

    protected $keyType = 'string';

    protected $table = 'country';
    protected $primaryKey = 'country_code';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'country_code',
        'country',
    ];

    public function geolocations()
    {
        return $this->hasMany(Geolocation::class, 'country_code', 'country_code');
    }
}
