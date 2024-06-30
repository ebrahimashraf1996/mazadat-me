<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class InvoiceDeliveryFilter extends ModelFilter
{

    public function dateFrom($date_from)
    {
        return $this->Delivery()->where('order_date', '>=', $date_from);
    }

    public function dateTo($date_to){
        return $this->Delivery()->where('order_date', '<=', $date_to);
    }

    public function invoiceNumber($invoice_number){
          return $this->Delivery()->where('invoice_number',  $invoice_number);
    }

    public function client($client){
        return $this->Delivery()->whereHas('client', function ($q) use ($client) {
            $q->where('id', $client);
        });
    }

    public function status($status){
        return $this->Delivery()->where('status_invoice',  $status);
    }

}
