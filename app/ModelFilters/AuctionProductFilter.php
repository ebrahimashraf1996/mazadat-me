<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class AuctionProductFilter extends ModelFilter
{

    public function nameProduct($id)
    {
        return $this->Auction()->where('product_id', $id);
    }

    public function nameClient($id)
    {
        return $this->Auction()->where('client_id', $id);
    }

//    public function phone1Client($phone)
//    {
//        return $this->client()->where('phone1', $phone);
//    }

    public function nameStage($id)
    {
        return $this->Auction()->where('auction_stage_id', $id);
    }

    public function dateFrom($date_from)
    {
        return $this->Auction()->whereDate('created_at', '>=', $date_from);
    }

    public function dateTo($date_to){
        return $this->Auction()->whereDate('created_at', '<=', $date_to);
    }

}
