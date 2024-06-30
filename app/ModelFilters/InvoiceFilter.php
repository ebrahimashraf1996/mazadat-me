<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class InvoiceFilter extends ModelFilter
{

    public function dateFrom($date_from)
    {
        return $this->Auction()->where('order_date', '>=', $date_from);
    }

    public function dateTo($date_to){
        return $this->Auction()->where('order_date', '<=', $date_to);
    }

    public function invoiceNumber($invoice_number){
        return $this->Auction()->where('invoice_number',  $invoice_number);
    }

    public function serialNumber($serial_number){
        return $this->Auction()->where('serial_number',  $serial_number);
    }


    public function codeAuction($code_auction){
        return $this->Auction()->whereHas('auction', function ($q) use ($code_auction) {
            $q->where('code', $code_auction);
        });
    }

    public function client($client){
        return $this->Auction()->whereHas('client', function ($q) use ($client) {
            $q->where('id', $client);
        });
    }

    public function stage($stage){
        return $this->Auction()->where('auction_stage_id',  $stage);
    }

    public function delivery($client){
        return $this->Auction()->whereHas('delivery', function ($q) use ($client) {
            $q->where('id', $client);
        });
    }

    public function status($status){
        return $this->Auction()->where('status_invoice',  $status);
    }

}
