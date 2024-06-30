<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\StoreDeliveryRequest;
use App\Http\Requests\Delivery\UpdateDeliveryRequest;
use App\ModelFilters\InvoiceDeliveryFilter;
use App\Models\Auction;
use App\Models\City;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\DeliveryArea;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Deliveries extends Controller
{

    public function index(Request $request)
    { 
        $deliveries = [];
        if (Auth::guard('auction')->check()) {
            $deliveries = Delivery::filter($request->all())->where('auction_id', Auth::guard('auction')->user()->id)->paginate();
        }
        return view('pages.deliveries.index', compact('deliveries'));
    }
   
    public function create()
    {
        $cities = City::get();
        $auctions = Auction::get();
        return view('pages.deliveries.add', compact('cities', 'auctions'));
    }

    public function store(StoreDeliveryRequest $storeDeliveryRequest)
    {
      try{

        $delivery = Delivery::create($storeDeliveryRequest->validated() +
          ['auction_id'=> Auth::guard('auction')->check() ? 
          Auth::guard('auction')->user()->id : null]);
          
        $areas = $storeDeliveryRequest->area_id;
        foreach($areas as $area){
          DeliveryArea::create([
            'delivery_id' => $delivery->id,
            'area_id'     => $area
          ]);
        }

        alert()->success('تم الأضافة بنجاح');
        return redirect()->route('deliveries.index');
        
      }catch(\Exception $ex){
        alert()->error('عفوا هناك خطأ تقني');
        return back();
      }
    }

    public function edit($id)
    {
      $delivery = Delivery::where('id', $id)->first();
      $cities = City::get();
      return view('pages.deliveries.edit', compact('delivery', 'cities'));
    }

    public function update(UpdateDeliveryRequest $updateDeliveryRequest, $id)
    {
      try{

        $delivery = Delivery::where('id', $id)->first();
        $delivery->update($updateDeliveryRequest->validated());
    
        if($updateDeliveryRequest->has('area_id')){
          $areas = $updateDeliveryRequest->area_id;
          DeliveryArea::where('delivery_id', $delivery->id)->delete();
          
          foreach($areas as $area){
            DeliveryArea::create([
              'delivery_id' => $delivery->id,
              'area_id'     => $area
            ]);
          }
        }
        alert()->success('تم التحديث بنجاح');
        return redirect()->route('deliveries.index');
      }catch(\Exception $ex){
        alert()->error('عفوا هناك خطأ تقني');
        return back();
      }
    }

    public function destroy($id)
    {
       $delete = Delivery::where('id', $id)->first();
       $delete->delete();
       alert()->success('تم الحذف مؤقتا');
       return back();
    }

    public function ajax_name_clients(Request $request)
    {
      $value = $request->value;
  
      if($value != null){
        $clients = Client::where('name', 'LIKE', "%{$value}%")->orWhere('phone1', 'LIKE', "%{$value}%")->where('deleted_at', null)->get();
      }else{
          $clients = Client::where('deleted_at', null)->get();
      }
  
      $html = view('pages.clients.ajax_clients', compact('clients'))->render();
      return response()->json(['clients' => $html]);
    }

    public function ajax_date_clients(Request $request)
    {
      $date_from = $request->date_from;
      $date_to = $request->date_to;

      if($date_from != null && $date_to != null){
          $clients = Client::whereBetween('created_at', [$date_from, $date_to])->where('deleted_at', null)->get();
      }elseif($date_from != null && $date_to == null){
          $clients = Client::whereDate('created_at', '>=', $date_from)->where('deleted_at', null)->get();
      }elseif($date_from == null && $date_to != null){
          $clients = Client::whereDate('created_at', '<=', $date_from)->where('deleted_at', null)->get();
      }else{
          $clients = Client::where('created_by', auth()->user()->id)->where('deleted_at', null)->get();
      }

      $html = view('pages.clients.ajax_clients', compact('clients'))->render();
      return response()->json(['clients' => $html]);
    }

    public function getDeliveryInvoices(Request $request)
    {
        
        if( Auth::guard('delivery')->check())
        {
            $invoices = Invoice::filter($request->all() , InvoiceDeliveryFilter::class)->with('auctionProducts','client.area')
            ->addSelect(['client_name' => Client::select('username')->whereColumn('id','invoices.client_id')->take(1)]) 
            ->addSelect(['client_phone' => Client::select('phone1')->whereColumn('id','invoices.client_id')->take(1)]) 
            ->where('delivery_id' , Auth::guard('delivery')->user()->id)
            ->orderBy('invoice_number' , 'ASC');
        }else{
            return redirect()->back();
        }
        
        return view('pages.deliveries.all_invoice', [
          'invoices'    => $invoices->paginate() ,
          'print_data'  =>  $invoices->get() ,
        ]);
        
    }

    public function updateInvoiceNote(Request $request){
      $invoice = Invoice::where('id' , $request->invoice_id)
                          ->where('delivery_id' , Auth::guard('delivery')->user()->id)
                          ->first();
        if($invoice){
          $invoice->update(['notes' => $request->notes]);
        }
        
        alert()->success('تم التعديل بنجاح');
        return back();
    }
    
}
