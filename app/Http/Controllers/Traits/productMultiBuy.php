<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Admin\Auctions;
use App\Models\Auction;
use App\Models\AuctionProduct;
use App\Models\AuctionStage;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\Invoice;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


trait productMultiBuy{

    use clientManyBuy;

    public function addProduct(Request $request)
    {
        if($request->search_product != null){
            $product = Product::where('id',$request->search_product)->first();
            $product->update(['price'=>$request->price]);
            return response(['product'=>$product]);
        }
        $product = Product::where('name', $request->name)
            ->where('auction_id', auth('auction')->user()->id)
            ->first();

            if($product){
                $product->update(['price'=>$request->price]);
            }else{
                $product = $this->addNewProduct($request->name , $request->price);
            }
        return response(['product'=>$product]);
    }

    public function buyProduct(Request $request , AuctionStage $auctionStage)
    {
        $auction = auth('auction')->user();
        foreach($request->client as $key => $client){
                $this->addClientAction($client);
                $auctionProduct =  $this->addAuctionProduct($auction ,
                                                $request->product[$key] ,
                                                $this->addClientAction($client)['client'],
                                                $request->count_pieces[$key],
                                                $request->price[$key],
                                                $request->notes[$key],
                                                $request->code[$key],
                                                $auctionStage
                                            );
                $this->addInvoice($auctionProduct ,
                $auction ,
                $this->addClientAction($client)['client'],
                $this->addClientAction($client)['delivery'],
                $auctionStage
           );
        }

    }

    public function newBuyProduct(Request $request , AuctionStage $auctionStage)
    {
//
        $auction = auth('auction')->user();
        foreach($request->new_client as $key => $client){
            $this->addClientAction($client);
            $auctionProduct =  $this->addAuctionProduct($auction ,
                $request->new_product[$key] ,
                $this->addClientAction($client)['client'],
                $request->new_count_pieces[$key],
                $request->new_price[$key],
                $request->new_notes[$key],
                $request->new_code[$key],
                $auctionStage
            );
            $this->addInvoice($auctionProduct ,
                $auction ,
                $this->addClientAction($client)['client'],
                $this->addClientAction($client)['delivery'],
                $auctionStage
            );
        }

    }
    public function addClientAction($username)
    {
        $delivery_id = null;
        $check_client  = Client::where('username', $username)->where('auction_id', auth('auction')->user()->id)->first();
        if ($check_client) {

            $client_id = $check_client->id;
            $client_area_id = $check_client->area_id;

            if ($client_area_id != null) {
                $delivery = Delivery::whereHas('deliveries_areas', function ($query) use ($client_area_id) {
                    $query->where('area_id', $client_area_id);
                })->where('auction_id', auth('auction')->user()->id)->first();

                if ($delivery) {
                    $delivery_id = $delivery->id;
                }
            }

        } else {
            $client_id = $this->addNewClientCustom($username);
        }
       return ['client' => $client_id , 'delivery' => $delivery_id];
    }

    public function addAuctionProduct($auction_id,$product_id,$client_id,$count_pieces,$price,$notes,$code,$auctionStage)
    {
        return  AuctionProduct::create([
            'client_id'          => $client_id,
            'product_id'         => $product_id,
            'count_pieces'       => $count_pieces,
            'price'              => $price,
            'notes'              => $notes,
            'auction_id'         => $auction_id->id,
            'auction_date'       => $auction_id->date,
            'code'               => $code,
            'auction_stage_id'   => $auctionStage->id,
        ]);
    }

    public function addInvoice($auction_product , $auction_id , $client_id , $delivery_id,$auctionStage)
    {

            $check_invoice = Invoice::where([
                    ['auction_id', $auction_id->id],
                    ['client_id', $client_id],
                    ['auction_date', $auction_id->date],
                    ['auction_stage_id' , $auctionStage->id]
                ])->first();

            if (!$check_invoice) {

                $auction = Auction::where('id', $auction_id->id)->first();

                if ($auction) {
                    $auction->update(['invoice_number' => $auction->invoice_number + 1]);
                }

                $invoice = Invoice::create([
                    'auction_id'        => $auction_id->id,
                    'auction_date'      => $auction_id->date,
                    'client_id'         => $client_id,
                    // 'invoice_number' => $auction->invoice_number,
                    'delivery_id'       => $delivery_id,
                    'order_date'        => Carbon::now(),
                    'auction_stage_id'  => $auctionStage->id,
                ]);

                $auction_product->update(['invoice_id' => $invoice->id]);
            }else{
                $auction_product->update(['invoice_id' => $check_invoice->id]);
            }
    }

    public function addNewClientCustom($username)
    {
        $this->validate( new Request(['name' => $username]),['name' =>  ['required', 'max:225', Rule::unique('clients', 'username')
                ->where('auction_id', auth('auction')->user()->id)]]);
        return  Client::insertGetId(['username' => $username ,'auction_id' => Auth::guard('auction')->check() ? Auth::guard('auction')->user()->id : null]);
    }

    public function addNewProductCustom($productName)
    {
        $this->validate( new Request(['name' => $productName]),['name' =>  ['required', 'max:225', Rule::unique('products', 'name')
                ->where('auction_id', auth('auction')->user()->id)]]);
        return Product::insertGetId([
                    'name'=>$productName ,
                    'status'=> 0,
                    'auction_id' => Auth::guard('auction')->check() ?
                    Auth::guard('auction')->user()->id : null]);
    }

}
