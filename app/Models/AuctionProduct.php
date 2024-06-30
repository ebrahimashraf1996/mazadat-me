<?php

namespace App\Models;

use App\Http\Controllers\Admin\Invoices;
use App\ModelFilters\AuctionProductFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionProduct extends Model
{

    use HasFactory;
    use Filterable;

    protected $table = 'auction_products';

    protected $guarded  = ['id'];


    public function modelFilter()
    {
        return $this->provideFilter(AuctionProductFilter::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class , 'invoice_id');
    }
    public function stage()
    {
        return $this->belongsTo(AuctionStage::class , 'auction_stage_id');
    }

    /**
     * Scope a query to only include active auction.
    */
    public function scopeAuction(Builder $query): void
    {
        $query->where('auction_id', auth('auction')->user()->id);
    }
}
