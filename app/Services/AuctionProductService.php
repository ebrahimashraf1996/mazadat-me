<?php

namespace App\Services;

use App\Models\AuctionProduct;
use App\Models\AuctionStage;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\Product;


class  AuctionProductService
{

    public function queryGetData($request, $auction_id)
    {

        $result = AuctionProduct::query();
        if ($request->phone1 != null) {
            $phone = $request->phone1;
            $result = $result->whereHas('client', function ($q) use ($phone) {
                $q->where('phone1', $phone);
            });
        }
        $result = $result->filter($request->all())->whereHas('client', function ($query) {
            $query->whereNotNull('username');
        })
            ->where('auction_id', $auction_id)
            ->addSelect(['product_name' => Product::select('name')->whereColumn('id', 'auction_products.product_id')->take(1)])
            ->addSelect(['client_name' => Client::select('username')->whereColumn('id', 'auction_products.client_id')->take(1)])
            ->addSelect(['client_phone' => Client::select('phone1')->whereColumn('id', 'auction_products.client_id')->take(1)])
            ->orderBy('id', 'desc');
        return $result;
    }

    public function getAuctionProducts()
    {
        return Product::query()->where('auction_id', auth('auction')->user()->id)
            ->select('id', 'name')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function getAuctionClients()
    {
        return Client::whereNotNull('username')
            ->where('auction_id', auth('auction')->user()->id)
            ->select('id', 'username')
            ->pluck('username', 'id')
            ->toArray();
    }

    public function getAuctionStages()
    {
        return AuctionStage::where('auction_id', auth('auction')->user()->id)
            ->select('id', 'name')
            ->orderBy('id', 'desc')
            ->pluck('name', 'id')
            ->toArray();
    }

}
