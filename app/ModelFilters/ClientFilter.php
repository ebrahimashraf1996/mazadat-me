<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ClientFilter extends ModelFilter
{
    public function nameClient($name)
    {
        return $this->Auction()->where(function ($query) use ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%')
                ->orWhere('phone1', 'LIKE', '%' . $name . '%')
                ->orWhere('phone2', 'LIKE', '%' . $name . '%')
                ->orWhere('username', 'LIKE', '%' . $name . '%');
        });
    }
}
