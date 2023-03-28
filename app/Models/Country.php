<?php

namespace App\Models;

use App\Traits\StatisticOperation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory, StatisticOperation;
    protected $guarded = ['id','created_at','updated_at','deleted_at'];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class);
    }
}
