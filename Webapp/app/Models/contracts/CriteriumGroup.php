<?php

namespace App\Models\contracts;

use App\Models\contracts\Criterium;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CriteriumGroup extends Model
{
    protected $table = 'criterium_group';

    protected $fillable = [
        'query',
        'type',
        'group_table',
        'operator',
    ];

    public function query_(): BelongsTo
    {
        return $this->belongsTo(Query::class, 'query');
    }

    public function criteriumType(): BelongsTo
    {
        return $this->belongsTo(CriteriumType::class, 'type');
    }

    public function operatorType(): BelongsTo
    {
        return $this->belongsTo(OperatorType::class, 'operator');
    }

    public function criteria(): HasMany
    {
        return $this->hasMany(Criterium::class, 'group');
    }
}
