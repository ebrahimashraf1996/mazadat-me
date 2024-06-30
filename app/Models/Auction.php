<?php

namespace App\Models;

use App\ModelFilters\AuctionFilter;
use App\Models\AuctionStage;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Auction extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles, Filterable;

    protected $guarded  = ['id'];
    
    public function modelFilter()
    {
      return $this->provideFilter(AuctionFilter::class);
    }

    protected $hidden = [
        'password',
    ];

    public function auctionProducts()
    {
        return $this->hasMany(AuctionProduct::class);
    }

    public function auctionStages(){
        return $this->hasMany(AuctionStage::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function deliveryAuctions()
    {
        return $this->hasMany(DeliveryAuction::class);
    }

}
