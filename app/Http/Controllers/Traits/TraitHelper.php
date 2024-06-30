<?php

namespace App\Http\Controllers\Traits;

use App\Models\AuctionProduct;
use App\Models\Product;
use Illuminate\Support\Facades\File;

trait TraitHelper{

  function uploadImage($folder, $image)
  {
      $filename= date('YmdHi').$image->getClientOriginalName();
      $path = $image->move(public_path('uploads/'.$folder .'/'), $filename);
      $path = 'uploads/'.$folder .'/'.$filename;
      return $path;
  }

  function deleteImage($path){
        if(File::exists(public_path($path))){
            File::delete(public_path($path));
        }
  }

  function calcSalesProduct($product_name , $auction_id){
     $product =  Product::where('name' , $product_name)->first();
      if($product){
        $salesSum = AuctionProduct::where('product_id',$product->id)->where('auction_id',$auction_id)->get();
         return  collect([
            'saleSum' =>  $salesSum->sum('price'),
            'count'   =>  $salesSum->sum('count_pieces')
          ]);
      }
  }

}
