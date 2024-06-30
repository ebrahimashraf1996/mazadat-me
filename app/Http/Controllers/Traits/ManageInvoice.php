<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Admin\Invoices;
use App\Models\Area;
use App\Models\AuctionProduct;
use App\Models\AuctionStage;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\Invoice;
use App\Models\Product;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


trait ManageInvoice{

    public function trackInvoice(Request $request ,InvoiceService $invoiceService)
    {
        if( Auth::guard('auction')->check()){
                $invoices = Invoice::filter($request->all())->with('auctionProducts','client.area')
                ->addSelect(['client_name' => Client::select('username')->whereColumn('id','invoices.client_id')->take(1)])
                ->addSelect(['client_phone' => Client::select('phone1')->whereColumn('id','invoices.client_id')->take(1)])
                ->addSelect(['delivery_name' => Delivery::select('name')->whereColumn('id','invoices.delivery_id')->take(1)])
                ->whereNotNull('delivery_id')
                ->where('auction_id' , Auth::guard('auction')->user()->id)
                ->orderBy('invoice_number' , 'ASC');
            }else{
                return redirect()->back();
            }

            $deliveries = Delivery::select('id','name')
            ->where('auction_id', Auth::guard('auction')->user()->id)
            ->pluck('name' , 'id')->toArray();

            return view('pages.invoices.track_invoice', [
            'invoices'    => $invoices->paginate($request->limit ?? '10') ,
            'deliveries'  => $deliveries ,
            'print_data'  =>  $invoices->get() ,
            ]);
    }

    public function detailsInvoices($invoice_id, $client_id)
    {
        $invoice = Invoice::with(['auctionProducts' => function ($q) {
            $q->where('is_return', 0);
        }], 'stage')->where('id', $invoice_id)->first();

        if(Auth::guard('auction')->check()) {
            $deliveries = Delivery::where('auction_id', Auth::guard('auction')->user()->id)->get();
            $stages = AuctionStage::where('auction_id' , auth('auction')->user()->id)->orderBy('id', 'desc')->get();

        }else{
            $stages = AuctionStage::orderBy('id', 'desc')->get();

            $deliveries = Delivery::get();
        }
        return view('pages.invoices.detailes_invoice', compact('invoice', 'deliveries', 'stages'));
    }

    public function editProducts($invoice_id, $client_id)
    {
        $invoice = Invoice::with(['auctionProducts' => function ($q) {
            $q->where('is_return', 0);
        }])->where('id', $invoice_id)->first();
        return view('pages.invoices.editProducts', compact('invoice'));
    }

    public function updateProducts(Request $request)
    {
        $data = $request['row'];
        foreach($data as $key => $row){
            $product = $this->checkProduct($row['product']);
            AuctionProduct::where('id',$key)->update([ 'count_pieces' => $row['count_pieces'] , 'price' => $row['price'] , 'product_id' => $product ]);
        }
        alert()->success('تم التعديل بنجاح');
        return redirect()->route('auction.invoices' , auth('auction')->user()->id);
    }

    public function checkProduct($productName)
    {
        $product = Product::where('name', $productName)
            ->where('auction_id', auth('auction')->user()->id)
            ->first();

            if($product){
                return  $product->id;
            }else{
                $product =  Product::create([
                            'name' => $productName ,
                            'price' => 0,
                            'auction_id' => Auth::guard('auction')->check() ?
                            Auth::guard('auction')->user()->id : null]);
                return $product->id;
            }
    }

}
