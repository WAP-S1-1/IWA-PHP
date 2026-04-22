<?php

namespace App\Models;

use App\Models\contracts\CriteriumGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Query extends Model
{
    protected $table = 'query';

    protected $fillable = [
        'contract_id',
        'omschrijving',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function criteriumGroups(): HasMany
    {
        return $this->hasMany(CriteriumGroup::class, 'query');
    }
}
