<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class AuctionStageFilter extends ModelFilter
{

    public function name($name)
    {
        return $this->Auction()->where('name', $name);
    }

    public function dateFrom($date_from)
    {
        return $this->Auction()->whereDate('start_time', '>=', $date_from);
    }

    public function dateTo($date_to){
        return $this->Auction()->whereDate('end_time', '<=', $date_to);
    }

}
