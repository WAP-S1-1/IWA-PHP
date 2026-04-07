<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OriginalMeasurement extends Model
{
    use HasFactory;

    protected $table = 'original_measurement';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'corrected_measurement',
        'missing_field',
        'inavlid_temperature',
    ];

    public function correctedMeasurement()
    {
        return $this->belongsTo(Measurement::class, 'corrected_measurement', 'id');
    }
}
