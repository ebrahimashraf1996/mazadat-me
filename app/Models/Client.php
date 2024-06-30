<?php

namespace App\Models;

use App\ModelFilters\ClientFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory , Filterable;
    protected $table = 'clients';

    protected $fillable = [
        'name',
        'username',
        'phone1',
        'phone2',
        'address',
        'area_id',
        'created_by',
        'updated_by',
        'piece',
        'street',
        'avenue',
        'house_number',
        'note',
        'auction_id',
    ];

    public function reservations()
    {
      return $this->hasMany('App\Models\Reservation', 'client_id', 'id');
    }

    public function area()
    {
      return $this->belongsTo(Area::class);
    }

    public function auctionProducts()
    {
        return $this->hasMany(AuctionProduct::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function auction()
    {
      return $this->belongsTo(Auction::class);
    }

    public function modelFilter()
    {
        return $this->provideFilter(ClientFilter::class);
    }
    
    /**
     * Scope a query to only include active auction.
     */
    public function scopeAuction(Builder $query): void
    {
        $query->where('auction_id', auth('auction')->user()->id);
    }
    
}
