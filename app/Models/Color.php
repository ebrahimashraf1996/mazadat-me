<?php

namespace App\Models;

use App\ModelFilters\ColorFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    use Filterable;
    protected $guarded  = ['id'];

   public function modelFilter()
   {
      return $this->provideFilter(ColorFilter::class);
   }
   
}
