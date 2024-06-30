<?php

namespace App\Services;

use App\Models\Invoice;

class  InvoiceService
{

    public function checkClientArea(){
        $data = Invoice::get();
        foreach($data as $invoice){
            if($invoice->client != null){
                if($invoice->client->area_id != null && $invoice->client->phone1 && $invoice->client->username){            
                    $invoice->getFirstAreaOfInvoice($invoice->client->area_id , $invoice->id);
                }else{
                    $invoice->update(['delivery_id'=>null,'status_invoice'=>'no_status']);
                }
            }
        }      
    }
    
}
