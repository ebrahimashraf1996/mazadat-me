<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ColorFilter extends ModelFilter
{
    public function nameColor($name)
    {
        return $this->where('name', 'LIKE', '%' . $name .'%');
    }
}
