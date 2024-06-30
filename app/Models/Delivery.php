<?php

namespace App\Models;

use App\ModelFilters\DeliveryFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Delivery extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , Filterable;

    protected $table = 'deliveries';
    
    protected $guarded  = ['id'];
    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }

    public function deliveries_areas()
    {
        return $this->hasMany(DeliveryArea::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function deliveryAuctions()
    {
        return $this->hasMany(DeliveryAuction::class);
    }
    
    public function modelFilter()
    {
        return $this->provideFilter(DeliveryFilter::class);
    }
    
    /**
     * Scope a query to only include active auction.
     */
    public function scopeAuction(Builder $query): void
    {
        $query->where('auction_id', auth('auction')->user()->id);
    }
    
}
