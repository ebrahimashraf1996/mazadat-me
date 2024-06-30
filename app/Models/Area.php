<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function deliveries_areas()
    {
        return $this->hasMany(DeliveryArea::class);
    }

    public function clinets()
    {
        return $this->hasMany(Client::class);
    }
}
