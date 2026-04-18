<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    protected $table = 'contract';

    protected $fillable = [
        'company_id',
        'omschrijving',
        'start_datum',
        'eind_datum',
        'url',
    ];

    protected $casts = [
        'start_datum' => 'date',
        'eind_datum' => 'date',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function queries(): HasMany
    {
        return $this->hasMany(Query::class, 'contract_id');
    }
}
