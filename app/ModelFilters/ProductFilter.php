<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ProductFilter extends ModelFilter
{
    public function nameProduct($name)
    {
        return $this->Auction()->where('name', 'LIKE', '%' . $name .'%');
    }
}
