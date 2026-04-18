<?php

namespace App\Models\contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Criterium extends Model
{
    protected $table = 'criterium';

    protected $fillable = [
        'group',
        'operator',
        'int_value',
        'string_value',
        'float_value',
        'value_type',
        'value_comparison',
    ];

    public function criteriumGroup(): BelongsTo
    {
        return $this->belongsTo(CriteriumGroup::class, 'group');
    }

    public function operatorType(): BelongsTo
    {
        return $this->belongsTo(OperatorType::class, 'operator');
    }

    public function comparisonType(): BelongsTo
    {
        return $this->belongsTo(ComparisonOperatorType::class, 'value_comparison');
    }
}
