<?php

namespace App\ViewModels;

use App\Models\Color;
use Spatie\ViewModels\ViewModel;

class ColorViewModel extends ViewModel
{
    public  $color;

    public function __construct(Color $color = null)
    {
        $this->color = $color == null ? new Color(old()) : $color;
    }
    
    public function  method()
    {
        return  is_null($this->color->id) ? 'POST' :  'PUT';
    }

    public function action(){
        return  is_null($this->color->id) ?
            route('colors.store') : 
            route('colors.update' , [ 'color' => $this->color->id  ]) ;
    }
    
}
