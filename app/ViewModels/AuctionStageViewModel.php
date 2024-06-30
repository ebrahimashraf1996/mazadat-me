<?php

namespace App\ViewModels;

use App\Models\AuctionStage;
use App\Models\Color;
use Spatie\ViewModels\ViewModel;

class AuctionStageViewModel extends ViewModel
{
    public  $auctionStage;

    public function __construct(AuctionStage $auctionStage = null)
    {
        $this->auctionStage = $auctionStage == null ? new AuctionStage(old()) : $auctionStage;
    }
    
    public function  method()
    {
        return  is_null($this->auctionStage->id) ? 'POST' :  'PUT';
    }

    public function action(){
        return  is_null($this->auctionStage->id) ?
            route('auctionStages.store') : 
            route('auctionStages.update' , [ 'auctionStage' => $this->auctionStage->id  ]) ;
    }
}
