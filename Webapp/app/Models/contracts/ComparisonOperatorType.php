<?php

namespace App\Models\contracts;

use Illuminate\Database\Eloquent\Model;

class ComparisonOperatorType extends Model
{
    protected $table = 'comparison_operator_type';
    public $timestamps = false;

    protected $fillable = [
        'omschrijving',
    ];
}
