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
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'longitude',
        'latitude',
        'elevation',
        'status',
        'status_updated_at',
        'status_message'
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

    // status constanten

    const STATUS_GREEN = 'green';
    const STATUS_ORANGE = 'orange';
    const STATUS_RED = 'red';

    // station status updates gebaseerd op recente measurements

    public function updateStatus()
    {

        $last30Measurements = $this->measurements()
            ->orderBy('date', 'DESC')
            ->orderBy('time', 'DESC')
            ->limit(30)
            ->get();

        if ($last30Measurements->isEmpty()) {
            $this->setStatus(self::STATUS_RED, "geen metingen");
            return; // prevent overwrite to green
        }

        $errorCount = 0;
        $warningCount = 0;

        foreach ($last30Measurements as $measurement) {
            if ($this->hasError($measurement)) {
                $errorCount++;
            } elseif ($this->hasWarning($measurement)) {
                $warningCount++;
            }
        }

// status bepalen op foutmeldingen gebaseerd
        if ($errorCount >= 3 || $warningCount >= 10) {
            $this->setStatus(self::STATUS_RED, "te veel foutmeldingen");
        } elseif ($errorCount >= 1 || $warningCount >= 5) {
            $this->setStatus(self::STATUS_ORANGE, "Veel foutmeldingen en waarschuwingen ontvangen");
        } else {
            $this->setStatus(self::STATUS_GREEN, "Alle metingen zijn correct");
        }


    }

    public function hasError($measurement){

        // Ontbrekende verplichte velden (any missing = error)
        if (is_null($measurement->time) || is_null($measurement->station) || is_null($measurement->date)){
            return true;
        }

        // Ontbrekende kritieke meetwaarden (any missing = error)
        if (is_null($measurement->temperature) || is_null($measurement->air_pressure_station)) {
            return true;
        }

        // Onrealistische waarden voor temperatuur
        if (!is_null($measurement->temperature) && ($measurement->temperature < -50 || $measurement->temperature > 60)) {
            return true;
        }

        // Onrealistische waarden voor luchtdruk
        if (!is_null($measurement->air_pressure_station) &&
            ($measurement->air_pressure_station < 800 || $measurement->air_pressure_station > 1100)) {
            return true;
        }

        // Onrealistische waarden voor windsnelheid
        if (!is_null($measurement->wind_speed) && $measurement->wind_speed < 0) {
            return true;
        }

        // Onrealistische waarden voor neerslag
        if (!is_null($measurement->percipation) && $measurement->percipation < 0) {
            return true;
        }

        return false;
    }

    public function hasWarning($measurement){

        // Gecorrigeerde meting (waarschuwing dat data aangepast is)
        if ($measurement->is_corrected == 1) {
            return true;
        }

        // Count missing optional fields; warn if 2 or more are missing
        $missingCount = 0;
        if (is_null($measurement->wind_speed)) $missingCount++;
        if (is_null($measurement->visibility)) $missingCount++;
        if (is_null($measurement->air_pressure_sea_level)) $missingCount++;

        return $missingCount >= 2;
    }

    public function setStatus($status, $message = null){

        $this->status = $status;
        $this->status_updated_at = now();
        if ($message) {
            $this->status_message = $message;
        }
        $this->save();
    }

    // css class voor status button
    public function getStatusClassAttribute(): string
    {
        return match($this->status) {
            self::STATUS_GREEN => 'status-green',
            self::STATUS_ORANGE => 'status-orange',
            self::STATUS_RED => 'status-red',
            default => 'status-gray'
        };
    }

}

