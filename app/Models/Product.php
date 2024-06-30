<?php

namespace App\Models;

use App\ModelFilters\ProductFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
      use HasFactory;
      use Filterable;
      protected $guarded  = ['id'];


      public function modelFilter()
      {
         return $this->provideFilter(ProductFilter::class);
      }
   
      public function auctions()
      {
         return $this->hasMany(Auction::class);
      }

      public function invoices()
      {
         return $this->hasMany(Invoice::class);
      }
      
      public function auctionProducts(){
         return $this->hasMany(AuctionProduct::class , 'product_id');
      }
      
      /**
     * Scope a query to only include active auction.
     */
    public function scopeAuction(Builder $query): void
    {
        $query->where('auction_id', auth('auction')->user()->id);
    }

    
}
