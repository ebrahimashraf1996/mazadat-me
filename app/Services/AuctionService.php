<?php

namespace App\Services;

use App\Models\Auction;
use App\Models\City;
use Illuminate\Support\Facades\Auth;

class  AuctionService{

    public function checkUserAuth($request){
        if(Auth::guard('auction')->check()){
            return  Auction::filter($request->all())
            ->addSelect(['city_name' => City::select('name')->whereColumn('id','city_id')->take(1)])
            ->where('id', Auth::guard('auction')->user()->id)->paginate();
        }else{
            return  Auction::filter($request->all())
            ->addSelect(['city_name' => City::select('name')->whereColumn('id','city_id')->take(1)])
            ->paginate();
        };
    }
    
}