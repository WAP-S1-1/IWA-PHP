<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    protected $table = 'measurement';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'station',
        'date',
        'time',
        'temperature',
        'dewpoint_temperature',
        'air_pressure_station',
        'air_pressure_sea_level',
        'visibility',
        'wind_speed',
        'percipation',
        'snow_depth',
        'conditions',
        'cloud_cover',
        'wind_direction',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class, 'station', 'name');
    }

    public function originalMeasurements()
    {
        return $this->hasMany(OriginalMeasurement::class, 'corrected_measurement', 'id');
    }
}
