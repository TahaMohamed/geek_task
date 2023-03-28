<?php

namespace App\Models;

use App\Traits\StatisticOperation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory, StatisticOperation;
    protected $guarded = ['id','created_at','updated_at','deleted_at'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}
