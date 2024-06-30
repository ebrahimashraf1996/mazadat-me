<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAuction extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',
        'auction_id',
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
