<?php

use App\Models\Delivery;
use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


if(!function_exists('getAllStatus'))
{
    function getAllStatus(){
         return [
            'no_status' => 'لم يعين مندوب',
            'delivery'  => 'قيد التوصيل',
            'delivered' => 'تم التوصيل',
            'delared'   => 'تم التاجيل',
            'canceled'  => 'تم الالغاء',
        ];   

    }
}

if(!function_exists('getInvoiceStatus'))
{
    function getInvoiceStatus($status){
        if($status == 'no_status'){
           echo  "<span class='alert alert-danger'>لم يعين مندوب</span>";
        }
        elseif($status == 'delivery'){
           echo "<span class='alert alert-primary'>قيد التوصيل </span>";
        }
        elseif($status == 'delivered'){
           echo "<span class='alert alert-success'>نم التوصيل </span>";
        }
        elseif($status == 'delared'){
           echo "<span class='alert alert-warning'>نم التاجيل </span>";
        }
         elseif($status == 'canceled'){
           echo "<span class='alert alert-danger'>نم الالغاء </span>";
        }
    }
}

if(!function_exists('customCheckClient'))
{
    function customCheckClient($client_username,$client_phone1){
       
            if($client_username != null && $client_phone1 != null){
                return "مكتمل";
            }else{
                return 'معلق';
            }
            return 'معلق';

    }

    function checkClient($client)
    {
        if($client){
            if($client->username != null && $client->phone1 != null){
                return "مكتمل";
            }else{
                return 'معلق';
            }
        }
            return 'معلق';
    }
}

if(!function_exists('amountInvoice'))
{
    function amountInvoice()
    {
        $setting = auth('auction')->check()
                    ? Setting::where('auction_id' , auth('auction')->user()->id)->first() 
                    : Setting::where('auction_id' , null)->first();
        if($setting->amount_invoice){
            return $setting->amount_invoice;
        }else{
            return 0;
        }
    }
}

if(!function_exists('totalPriceProduct'))
{
    function totalPriceProduct($products)
    {
        $total_price_product = [];
            foreach($products as $product){
                $total_price_product[] = $product['price'] * $product['count_pieces'];
            }
        return array_sum($total_price_product);
    }
}