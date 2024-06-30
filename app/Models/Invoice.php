<?php

namespace App\Models;

use App\ModelFilters\InvoiceFilter;

use App\Models\AuctionStage;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Invoice extends Model
{
    use HasFactory;
    use Filterable;
    protected $guarded  = [];

    public function getStatus()
    {
        return [
            'no_status' => 'لم يعين مندوب',
            'delivery'  => 'قيد التوصيل',
            'delivered' => 'تم التوصيل',
            'delared'   => 'تم التاجيل',
            'canceled'  => 'تم الالغاء',
        ];
    }

    public function modelFilter()
    {
        return $this->provideFilter(InvoiceFilter::class);
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

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function areas()
    {
        return $this->auction->city->areas();
    }

    public function areaClient()
    {
        return $this->hasOneThrough(
            Area::class,
            Client::class,
            'area_id', // Foreign key on the clients table...
            'id', // Foreign key on the areas table...
        );
    }

    public function auctionProducts()
    {
        return $this->hasMany(AuctionProduct::class , 'invoice_id');
    }

    public function stage()
    {
        return $this->belongsTo(AuctionStage::class , 'auction_stage_id' , 'id');
    }

    /**
     * Scope a query to only include active auction.
    */
    public function scopeAuction(Builder $query): void
    {
        $query->where('auction_id', auth('auction')->user()->id);
    }

    /**
     * Scope a query to only include active auction.
    */
    public function scopeDelivery(Builder $query): void
    {
        $query->where('delivery_id', auth('delivery')->user()->id);
    }

    public function getFirstAreaOfInvoice($client_area, $invoice_id)
    {

        $invoice = Invoice::where('id', $invoice_id)->first();

        if(Auth::guard('auction')->check()){
            $auction_id = Auth::guard('auction')->user()->id;
            $delivery = Delivery::whereHas('deliveries_areas', function($query) use($client_area){
                            $query->where('area_id', $client_area);
                        })->where('auction_id', $auction_id)->first();
            if($invoice->delivery_id != null ){
                if($delivery){
                    if($invoice->delivery_id == $delivery->id){
                        if($invoice->status_invoice == 'no_status'){
                            $invoice->update(['delivery_id' => $delivery->id , 'status_invoice' => 'delivery']);
                        }
                        return $invoice->delivery?->name;
                    }else{
                        $invoice->update(['delivery_id' => $invoice->delivery_id , 'status_invoice' => 'delivery']);
                        return $invoice->delivery?->name;
                    }
                }else{

                     $invoice->update(['delivery_id' => $invoice->delivery_id, 'status_invoice' => 'no_status']);
                }
            }else{
                if($delivery){
                   $invoice->update(['delivery_id' => $delivery->id , 'status_invoice' => 'delivery']);
                    return $invoice->delivery?->name;
                }
            }
        }

    }


}
