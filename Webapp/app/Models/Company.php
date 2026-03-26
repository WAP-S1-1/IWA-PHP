<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Tests\Integration\Http\Fixtures\Subscription;

class Company extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'city',
        'street',
        'number',
        'number_additional',
        'zip_code',
        'country',
        'email',
    ];

    public function country() {
        return $this->belongsTo(Country::class, 'country', 'country_code');
    }
}
