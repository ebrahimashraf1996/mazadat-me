<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryArea extends Model
{
    use HasFactory;

    protected $table = 'delivery_areas';

    protected $fillable = [
        'delivery_id',
        'area_id',
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
