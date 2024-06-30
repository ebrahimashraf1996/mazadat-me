<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class AuctionFilter extends ModelFilter
{
    public function nameAuction($name)
    {
        return $this->where('name', 'LIKE', '%' . $name .'%');
    }
}
