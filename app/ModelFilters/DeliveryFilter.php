<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class DeliveryFilter extends ModelFilter
{
    public function nameDelivery($name)
    {
        return $this->Auction()->where('name', 'LIKE', '%' . $name .'%')
        ->orWhere('phone1',$name)
        ->orWhere('phone2',$name);
    }
}
