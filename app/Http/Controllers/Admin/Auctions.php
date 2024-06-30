<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionStage;
use App\Models\City;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\Invoice;
use App\Models\Setting;
use App\Services\AuctionProductService;
use App\Services\AuctionService;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;


class Auctions extends Controller
{
    public $auctionProductService;

    public function __construct()
    {
        $this->auctionProductService = new AuctionProductService();
    }
    public function index(Request $request,AuctionService $auctionService)
    {
      // $auctions = Auction::where('id','!=',14)->get();
      // foreach($auctions as $auction){
      //   $auction->delete();
      // }
      // dd($auctions);
      $auctions = $auctionService->checkUserAuth($request);
      return view('pages.auctions.index', compact('auctions'));
    }

    public function create()
    {
        $cities = City::get();
        return view('pages.auctions.add', compact('cities'));
    }

    public function store(Request $request)
    {

      try{

        $validator = Validator::make($request->all(), [
          'name'          => 'required|string',
          'code'          => 'required|string',
          'email'         => 'sometimes|nullable|email',
          'date'          => 'sometimes|nullable',
          'link'          => 'sometimes|nullable',
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }


        $auction =Auction::create([
          'name'        => $request->name,
          'email'       => $request->email,
          'password'    => Hash::make($request->password),
          'date'        => $request->date,
          'city_id'     => $request->city_id,
          'details'     => $request->details,
          'link'        => $request->link,
          'phone'       => $request->phone,
          'code'        => $request->code
        ]);

        if($request->has('clients_backup')){
          $this->addClientsToNewAuction($auction->id);
        }

        alert()->success('تم الأضافة بنجاح');
        return redirect()->route('auctions.index');
      }catch(\Exception $ex){
        return back()->withErrors($ex->getMessage())->withInput();
        alert()->error('عفوا هناك خطأ تقني');
        return redirect()->route('auctions.index');
      }
    }

    public function addClientsToNewAuction($auctionId)
    {
        $clients =  Client::groupBy('phone1')->inRandomOrder()->take(500)
                  ->select(['name','username','phone1','phone2','address','area_id','piece','street','avenue','house_number','note'])
                  ->get()->toArray();
        $handleClients= [];
        foreach($clients as $client){
            $actionId = ['auction_id' => $auctionId];
            $client = array_merge($client ,$actionId);
            $handleClients[] = $client;
        }

        foreach (array_chunk($handleClients, 100) as $chunk) {
            Client::insert($chunk);
        }
    }

    public function edit($id)
    {
        $auction = Auction::where('id', $id)->first();
        $cities = City::get();
        return view('pages.auctions.edit', compact('auction', 'cities'));
    }

    public function update(Request $request, $id)
    {
      try{

        $validator = Validator::make($request->all(), [
          'name'          => 'required|string',
          'email'         => 'sometimes|nullable|email|unique:auctions,email,'.$id,
          'date'          => 'sometimes|nullable',
          'link'          => 'sometimes|nullable',
          'code'          => 'sometimes|nullable|string',
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $auction = Auction::where('id', $id)->first();
        if($request->has('password') && $request->password != null){
          $password =  Hash::make($request->password);
        }else{
          $password = $auction->password;
        }

        $auction->update([
          'name'        => $request->name,
          'email'       => $request->email,
          'password'    => $password,
          'date'        => $request->date,
          'city_id'     => $request->city_id,
          'details'     => $request->details,
          'link'        => $request->link,
          'phone'       => $request->phone,
          'code'        => $request->code,
        ]);

        alert()->success('تم التحديث بنجاح');

        if(Auth::guard('auction')->check()){
             return redirect()->route('auctions.index', Auth::guard('auction')->user()->id);
        }else{
            return redirect()->route('auctions.index');
        }

      }catch(\Exception $ex){

        alert()->error('عفوا هناك خطأ تقني');
        return back();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = Auction::where('id', $id)->first();
        $user->delete();
        alert()->success('تم الحذف بنجاح');
        return back();
    }

    public function auctionInvoices(Request $request , $id)
    {
        // $invoices = Invoice::get();
        // foreach($invoices as $key => $invoice){
        //   $invoice->update(['serial_number' => $key + 1]);
        // }
        // dd(Invoice::count());

        if ($request->has('limit') && $request->limit != '') {
            Session::put('invoice_limit', $request->limit);
        }
        if (Session::has('invoice_limit') && Session::get('invoice_limit') != '') {
            $request->merge(['limit' => Session::get('invoice_limit')]);
//            dd($request->all());
        }
//        dd($request->all());

        $invoices = Invoice::filter($request->all())->with('auctionProducts')
                    ->addSelect(['client_name' => Client::select('username')->whereColumn('id','invoices.client_id')->take(1)])
                    ->addSelect(['client_phone' => Client::select('phone1')->whereColumn('id','invoices.client_id')->take(1)])
                    ->addSelect(['auction_code' => Auction::select('code')->whereColumn('id','invoices.auction_id')->take(1)])
                    ->whereHas('client', function($query){
                        $query->whereNotNull('username');
                    })->where('auction_id', $id)->paginate($request->limit ?? '10');

        $auction_id = $id;
        $deliveries =  Delivery::select('id','name')
            ->where('auction_id', Auth::guard('auction')->user()->id)
            ->pluck('name' , 'id')->toArray();
        $stages = AuctionStage::where('auction_id' , auth('auction')->user()->id)->orderBy('id', 'desc')->get();
        $setting_ = Setting::where('auction_id' , auth('auction')->user()->id)->first();
        if (!$setting_) {
            $setting_ = Setting::where('auction_id' , null)->first();
        }
        return view('pages.auctions.invoices-auction', compact('deliveries','invoices', 'auction_id','stages', 'setting_'));
    }

    public function auctionClients(Request $request , $id )
    {
        if ($request->has('limit') && $request->limit != '') {
            Session::put('clients_limit', $request->limit);
        }

        if (Session::has('clients_limit') && Session::get('clients_limit') != '') {
            $request->merge(['limit' => Session::get('clients_limit')]);
        }
        if ($request->has('name_stage') && $request->name_stage != '') {
            Session::put('clients_name_stage', $request->name_stage);
        }
        if (Session::has('clients_name_stage') && Session::get('clients_name_stage') != '') {
            $request->merge(['name_stage' => Session::get('clients_name_stage')]);
        }
//        return $request->all();
        $clients = [];
          if(Auth::guard('auction')->check()){
              if ($request->has('name_stage') && $request->name_stage != null) {
                  $stage = AuctionStage::find($request->name_stage);
                  $stage_clients_ids = $stage->auctionProducts->pluck('client_id')->toArray();
                  $clients = Client::filter($request->all())->where('auction_id', Auth::guard('auction')->user()->id)->whereIn('id', $stage_clients_ids)->paginate($request->limit ?? '10');
              } else {
                  $clients = Client::filter($request->all())->where('auction_id', Auth::guard('auction')->user()->id)->paginate($request->limit ?? '10');

              }
//              return $stage_clients_ids;
              $stages = $this->auctionProductService->getAuctionStages();
          }
        return view('pages.auctions.clients-auction', get_defined_vars());
    }

    public function getNotes($id) {
        $notes = AuctionStage::find($id);
        if($notes) {
            $notes = json_decode($notes->notes);
            return response()->json(['status' => 1, 'message' => 'notes', 'data' => $notes]);

        } else {
            return response()->json(['status' => 0, 'message' => 'notes', 'data' => null]);

        }
    }

    public function updateNotes(Request $request, $id) {
        $notes = AuctionStage::find($id);
//        return json_encode($request->notes);
        if($notes) {
            $notes->notes = json_encode($request->notes);
            $notes->save();
            alert()->success('تم تعديل الملاحظات بنجاح');
            return back();

        } else {
            return response()->json(['status' => 0, 'message' => 'notes', 'data' => null]);

        }
//        return $id;
    }

    public function burn_clients_session() {
        Session::forget(['clients_limit','clients_name_stage']);
        return redirect()->route('auction.clients', Auth::guard('auction')->user()->id);
    }
}
