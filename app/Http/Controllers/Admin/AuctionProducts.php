<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\clientManyBuy;
use App\Http\Controllers\Traits\productMultiBuy;
use App\Http\Controllers\Traits\TraitHelper;
use App\Http\Requests\Product\StoreAuctionProductRequest;
use App\Models\Auction;
use App\Models\AuctionProduct;
use App\Models\AuctionStage;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\Invoice;
use App\Models\Note;
use App\Models\Product;
use App\Services\AuctionProductService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuctionProducts extends Controller
{
    use TraitHelper, productMultiBuy, clientManyBuy;
    public $auctionProductService;

    public function __construct()
    {
        $this->auctionProductService = new AuctionProductService();
    }

    public function index(AuctionStage $auctionStage, Request $request)
    {
        $auction = auth('auction')->user();
        $query = $this->auctionProductService->queryGetData($request, $auction->id);
        $auction_products = $query->with('product')->where('is_return', 0)->where('auction_stage_id', $auctionStage->id)->paginate();

        $productSearch = [];
        if ($request->has('name_product')) {
            $productSearch = collect(['saleSum' => $query->sum('price'), 'count' => $query->sum('count_pieces')]);
        }

//        $products = $this->auctionProductService->getAuctionProducts();
//        $clients = $this->auctionProductService->getAuctionClients();
        $auction_id = $auction->id;
        // fixed loop iteration count items
        $skipped = ($auction_products->currentPage() * $auction_products->perPage()) - $auction_products->perPage();

        $notes = Note::where('stage_id', $auctionStage->id)->get();

        $stage_id = $auctionStage->id;
//          $new_products = Product::query()->with(['auctionProducts' => function($q) {
//            $q->orderBy('price', 'desc');
//        }])->whereHas('auctionProducts', function ($q) use ($stage_id) {
//            $q->where('auction_stage_id', $stage_id);
//        })->get();
//        return Product::find(12241);
         $new_products = Product::query()->join('auction_products', 'products.id', '=', 'auction_products.product_id')
            ->where('auction_products.auction_stage_id', $stage_id)
            ->select([
                'auction_products.id as auction_product_id',
                'products.id as product_id',
                'products.name as name',
                'auction_products.created_at as auction_product_created_at',
                'auction_products.price as auction_product_price',
                'auction_products.count_pieces as count_pieces',
                'auction_products.invoice_id as invoice_id',
                'auction_products.auction_stage_id as auction_stage_id',
                'auction_products.is_return as is_return',
            ])
            ->orderBy('auction_product_id', 'desc')
            ->get()
            ->groupBy(function ($q){
                return $q->name;
            });
//        return $new_products->auctionProducts->first()->price;

//        return $new_products;

        return view('pages.auction-products.index', get_defined_vars());
    }

    public function generalSearchProduct(Request $request)
    {
        $auction = auth('auction')->user();
        $query = $this->auctionProductService->queryGetData($request, $auction->id);
        $all_auction_products = $query->where('is_return', 0)->paginate();

        $productSearch = [];
        if ($request->has('name_product')) {
            $productSearch = collect(['saleSum' => $query->sum('price'), 'count' => $query->sum('count_pieces')]);
        }

//        $products = $this->auctionProductService->getAuctionProducts();
//        $clients = $this->auctionProductService->getAuctionClients();
        $stages = $this->auctionProductService->getAuctionStages();
        // fixed loop iteration count items
        $skipped = ($all_auction_products->currentPage() * $all_auction_products->perPage()) - $all_auction_products->perPage();
        return view('pages.auction-products.generalView', get_defined_vars());
    }

    public function getProductAuction(AuctionStage $auctionStage)
    {
        $auction_id = auth('auction')->user()->id;
        $auction_products = AuctionProduct::where('auction_id', $auction_id)
            ->where('auction_stage_id', $auctionStage->id)->orderBy('id', 'desc')->get();
        $html = view('pages.auction-products.ajax_get_data', get_defined_vars())->render();
        return response()->json(['status' => true, 'auction_products' => $html]);
    }

    public function create(AuctionStage $auctionStage)
    {
        $auction_id = auth('auction')->user()->id;
        return view('pages.auction-products.add', compact('proudcts', 'clients', 'auction_id'));
    }

    public function store(StoreAuctionProductRequest $request, AuctionStage $auctionStage)
    {
        $auction_id = auth('auction')->user();
        $delivery_id = null;

        if ($request->search_client != null) {
            $username = $request->search_client;
            $check_client = Client::where('username', $username)->where('auction_id', auth('auction')->user()->id)->first();
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
        } else {
            if ($request->has('client') && $request->client != null) {
                $check_client = Client::where('username', $request->client)->where('auction_id', auth('auction')->user()->id)->first();
                if ($check_client) {
                    $client_id = $check_client->id;
                } else {
                    $client_id = $this->addNewClientCustom($request->client);
                }
            }
        }

        if ($request->search_product != null) {
            $product_id = $request->search_product;
            $check_product = Product::where('id', $product_id)->where('auction_id', auth('auction')->user()->id)->first();

            if ($check_product) {
                $product_id = $check_product->id;
            } else {
                $product_id = $this->addNewProductCustom($request->product);
            }

            // if ($check_product->status != 0 or $check_product->qty != null) {
            //     if ($check_product->qty != null or $check_product->qty) {
            //         if ($request->count_pieces > $check_product->qty) {
            //             return response()->json(['status' => false, 'errors' => 'عفوا عدد القطع المضافة أكبر من عدد القطع المتاحة للمنتج']);
            //         }
            //     } else {
            //         return response()->json(['status' => false, 'errors' => 'لا يوجد قطع متاحة للمنتج']);
            //     }
            // }

        } else {
            if ($request->has('product') && $request->product != null) {
                $check_product = Product::where('name', $request->product)->where('auction_id', auth('auction')->user()->id)->first();
                if ($check_product) {
                    $product_id = $check_product->id;
                } else {
                    $product_id = $this->addNewProductCustom($request->product);
                }
            }
        }

        $auction_product = AuctionProduct::create([
            'client_id' => $client_id,
            'product_id' => $product_id,
            'purchase_type' => $request->purchase_type,
            'count_pieces' => $request->count_pieces,
            'price' => $request->price,
            'notes' => $request->notes,
            'auction_id' => $auction_id->id,
            'auction_stage_id' => $auctionStage->id,
            'auction_date' => $auction_id->date,
            'code' => $request->code,
        ]);

        // if ($request->search_product != null) {
        //     $check_product = Product::where('id', $product_id)->where('auction_id', auth('auction')->user()->id)->first();
        //     if ($check_product->status != 0 or $check_product->qty != null) {
        //         $check_product->update(['qty' => $check_product->qty - (int) $request->count_pieces]);
        //     }
        // }

        $check_invoice = Invoice::where([
            ['auction_id', $auction_id->id],
            ['client_id', $client_id],
            ['auction_date', $auction_id->date],
            ['auction_stage_id', $auctionStage->id]
        ])->first();

        if (!$check_invoice) {
            $auction = Auction::where('id', $auction_id->id)->first();
            if ($auction) {
                $auction->update(['invoice_number' => $auction->invoice_number + 1]);
            }
//            dd('test 3');

            $invoice = Invoice::create([
                'auction_id' => $auction_id->id,
                'auction_date' => $auction_id->date,
                'client_id' => $client_id,
                // 'invoice_number'   => $auction->invoice_number,
                'delivery_id' => $delivery_id,
                'auction_stage_id' => $auctionStage->id,
                'order_date' => Carbon::now(),
            ]);

            $auction_product->update(['invoice_id' => $invoice->id]);
        } else {
            $auction_product->update(['invoice_id' => $check_invoice->id]);
        }
        return response()->json(['status' => true]);
    }

    public function edit(AuctionStage $auctionStage, $id)
    {
        return view('pages.auction-products.edit',
            [
                'auction_product' => AuctionProduct::where('id', $id)->first(),
                'proudcts' => Product::get(),
                'clients' => Client::get(),
                'auction_id' => auth('auction')->user()->id,
                'auctionStage' => $auctionStage
            ]);
    }

    public function update(Request $request, AuctionStage $auctionStage, $id)
    {
//        return $request;
        $auction_id = auth('auction')->user();

        $validator = Validator::make($request->all(), [
            'client_id' => 'required|string',
            'product_id' => 'sometimes|nullable',
            'purchase_type' => 'required',
            'count_pieces' => 'required',
            'price' => 'required',
            'notes' => 'sometimes|nullable',
            'code' => 'sometimes|nullable|unique:auction_products,code,' . $id,
        ], [
            'required' => 'هذا الحقل مطلوب',
            'code.unique' => 'هذا الكود مستخدم من قبل',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $auction = AuctionProduct::where('id', $id)->first();
        ///////////////////////////////
//            return $auctionStage->id;
//            return $auction_id->id;
//            return $request->client_id;
//            return $auction->client_id;
        $oldUserInvoice = Invoice::where('auction_stage_id', $auctionStage->id)->where('auction_id', $auction_id->id)->where('client_id', $auction->client_id)->where('auction_date', $auction_id->date)->first();
        $newUserInvoice = Invoice::where('auction_stage_id', $auctionStage->id)->where('auction_id', $auction_id->id)->where('client_id', $request->client_id)->where('auction_date', $auction_id->date)->first();
        if (!$newUserInvoice) {
            $newUserInvoice = Invoice::create([
                'auction_stage_id' => $auctionStage->id,
                'auction_id' => $auction_id->id,
                'client_id' => $request->client_id,
            ]);
        }

//        return$oldUserInvoice;
        $old_id = $auction->client_id;
        $new_id = $request->client_id;

        if ($auction->client_id != $request->client_id) {

            if ($oldUserInvoice && count($oldUserInvoice->auctionProducts) >= 1) {
                $products = AuctionProduct::where('invoice_id', $oldUserInvoice->id)->get();
                foreach ($products as $product) {
                    $product->client_id = $new_id;
                    $product->invoice_id = $auction->client_id != $request->client_id ? $newUserInvoice->id : $oldUserInvoice->id;
                    $product->save();
                }
                Invoice::find($oldUserInvoice->id)->delete();
//                    $oldUserInvoice->delete();
            }
            $newUserInvoice = $newUserInvoice->id;
        }
        //////////////////////////////
//        dd($old_id);
        $auction->update([
            'client_id' => $request->client_id,
            'product_id' => $request->product_id,
            'purchase_type' => $request->purchase_type,
            'count_pieces' => $request->count_pieces,
            'price' => $request->price,
            'notes' => $request->notes,
            'code' => $request->code,
            'invoice_id' => $auction->client_id != $request->client_id ? $newUserInvoice : $oldUserInvoice->id,
        ]);

        if ($request->product_name != null) {
            $checkProduct = Product::where('id', $request->product_id)->first();
            if ($checkProduct) {
                $checkProduct->update(['name' => $request->product_name]);
            }
        }

        alert()->success('تم التحديث بنجاح');
        return redirect()->route('auction-products.index', ['auctionStage' => $auctionStage->id]);


    }

    public function updateReturn(Request $request, AuctionStage $auctionStage, $id)
    {
//        return $request;


    }

    public function destroy(AuctionStage $auctionStage, $id)
    {
        $row = AuctionProduct::where('id', $id)->first();
        $row->delete();
        alert()->success('تم الحذف');
        return back();
    }

    public function returnProduct($id)
    {
        $row = AuctionProduct::findOrFail($id);
        $row->is_return = 1;
        $row->save();
        alert()->success('تم تحويل المنتج لمرتجع');
        return back();
    }

    public function returnEdit(AuctionStage $auctionStage, $id)
    {
        return view('pages.auction-products.returnsEdit',
            [
                'auction_product' => AuctionProduct::where('id', $id)->first(),
                'proudcts' => Product::get(),
                'clients' => Client::get(),
                'auction_id' => auth('auction')->user()->id,
                'auctionStage' => $auctionStage
            ]);

    }

    public function returnUpdate(Request $request, AuctionStage $auctionStage, $id)
    {
        $auction_id = auth('auction')->user();

        $validator = Validator::make($request->all(), [
            'client_id' => 'required|string',
            'product_id' => 'sometimes|nullable',
            'purchase_type' => 'required',
            'count_pieces' => 'required',
            'price' => 'required',
            'notes' => 'sometimes|nullable',
            'code' => 'sometimes|nullable|unique:auction_products,code,' . $id,
        ], [
            'required' => 'هذا الحقل مطلوب',
            'code.unique' => 'هذا الكود مستخدم من قبل',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $auction = AuctionProduct::where('id', $id)->first();
        ///////////////////////////////
//            return $auctionStage->id;
//            return $auction_id->id;
//            return $request->client_id;
//            return $auction->client_id;
        $oldUserInvoice = Invoice::where('auction_stage_id', $auctionStage->id)->where('auction_id', $auction_id->id)->where('client_id', $auction->client_id)->where('auction_date', $auction_id->date)->first();
        $newUserInvoice = Invoice::where('auction_stage_id', $auctionStage->id)->where('auction_id', $auction_id->id)->where('client_id', $request->client_id)->where('auction_date', $auction_id->date)->first();
        if (!$newUserInvoice) {
            $newUserInvoice = Invoice::create([
                'auction_stage_id' => $auctionStage->id,
                'auction_id' => $auction_id->id,
                'client_id' => $request->client_id,
            ]);
        }

//        return$oldUserInvoice;
        $old_id = $auction->client_id;
        $new_id = $request->client_id;

        if ($auction->client_id != $request->client_id) {

            if ($oldUserInvoice && count($oldUserInvoice->auctionProducts) >= 1) {
                $products = AuctionProduct::where('invoice_id', $oldUserInvoice->id)->get();
                foreach ($products as $product) {
                    $product->client_id = $new_id;
                    $product->invoice_id = $auction->client_id != $request->client_id ? $newUserInvoice->id : $oldUserInvoice->id;
                    $product->save();
                }
                Invoice::find($oldUserInvoice->id)->delete();
//                    $oldUserInvoice->delete();
            }
            $newUserInvoice = $newUserInvoice->id;
        }
        //////////////////////////////
//        dd($old_id);
        $auction->update([
            'client_id' => $request->client_id,
            'product_id' => $request->product_id,
            'purchase_type' => $request->purchase_type,
            'count_pieces' => $request->count_pieces,
            'price' => $request->price,
            'notes' => $request->notes,
            'code' => $request->code,
            'invoice_id' => $auction->client_id != $request->client_id ? $newUserInvoice : $oldUserInvoice->id,
        ]);

        if ($request->product_name != null) {
            $checkProduct = Product::where('id', $request->product_id)->first();
            if ($checkProduct) {
                $checkProduct->update(['name' => $request->product_name]);
            }
        }

        alert()->success('تم التحديث بنجاح');
        return redirect()->route('get.return-products');
    }

    public function generalReturnProducts(Request $request)
    {
        $auction = auth('auction')->user();
        $query = $this->auctionProductService->queryGetData($request, $auction->id);
        $all_auction_products = $query->where('is_return', 1)->paginate();

        $productSearch = [];
        if ($request->has('name_product')) {
            $productSearch = collect(['saleSum' => $query->sum('price'), 'count' => $query->sum('count_pieces')]);
        }

        $products = $this->auctionProductService->getAuctionProducts();
        $clients = $this->auctionProductService->getAuctionClients();
        $stages = $this->auctionProductService->getAuctionStages();
        // fixed loop iteration count items
        $skipped = ($all_auction_products->currentPage() * $all_auction_products->perPage()) - $all_auction_products->perPage();
        return view('pages.auction-products.returnsView', get_defined_vars());
    }

    public function renewSell(Request $request) {
//        return $request;
        $auction = auth('auction')->user();
        $auctionStage = AuctionStage::find($request->auctionStage);
        foreach($request->new_client as $key => $client) {
            $this->addClientAction($client);
            $auctionProduct =  $this->addAuctionProduct($auction ,
                $request->new_product[$key] ,
                $this->addClientAction($client)['client'],
                $request->count_pieces[$key],
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
        alert()->success('تم البيع بنجاح');
        return redirect()->back();

    }

}
