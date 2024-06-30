<?php  

namespace App\Http\Controllers\Traits;

use App\Models\Auction;
use App\Models\AuctionStage;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

trait clientManyBuy {

    public function checkClient(Request $request){
    
        $name = $request->search_client != null ?  $request->search_client : $request->name;
        $delivery = null;
        $client = Client::where('username', $name)->where('auction_id', $request->auction_id)->first();
        
        if($client == null){
          $client =  $this->addNewClient($request);
        }
            
        if ($client->area_id != null) {
            $delivery = Delivery::whereHas('deliveries_areas', function ($query) use ($client) {
                $query->where('area_id', $client->area_id);
            })->where('auction_id', $request->auction_id)->first();
        }
            
        return ['client' => $client, 'delivery' => $delivery != null ? $delivery->id : null ];
    }

    public function clientManyProducts(Request $request , AuctionStage $auctionStage){
        $auction = auth('auction')->user();
        foreach($request->products as $key => $product){
           $auctionProduct =  $this->addAuctionProduct($auction ,
                                $this->addProductAction($product , $request->price[$key]),
                                $request->client_id,
                                $request->count_pieces[$key],
                                $request->price[$key],
                                $request->notes[$key],
                                $request->code[$key],
                                $auctionStage
                            );
           $this->addInvoice($auctionProduct , 
           $auction , 
           $request->client_id,
           $request->delivery_id,
           $auctionStage
           );
        }
    }

    public function addProductAction($productName , $price){
        $product = Product::where('name', $productName)->where('auction_id', auth('auction')->user()->id)->first();
        if($product === null){
            $product = $this->addNewProduct($productName , $price); 
        }
        return $product->id;
    }

    public function addNewClient(Request $request){
        $this->validate($request,['name' =>  ['required', 'max:225', Rule::unique('clients', 'username')
                ->where('auction_id', auth('auction')->user()->id)]]);
        return Client::create(['username'=>$request->name, 'auction_id'=>$request->auction_id]);
    }

    public function addNewProduct($productName , $price){
        $this->validate( new Request(['name' => $productName]),['name' =>  ['required', 'max:225', Rule::unique('products', 'name')
                ->where('auction_id', auth('auction')->user()->id)]]);
        return Product::create([
                    'name'=>$productName , 
                    'price'=>$price,
                    'auction_id' => Auth::guard('auction')->check() ? 
                    Auth::guard('auction')->user()->id : null]);
    }

}