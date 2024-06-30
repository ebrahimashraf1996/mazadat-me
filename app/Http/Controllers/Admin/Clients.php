<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Area;
use App\Models\AuctionProduct;
use App\Models\City;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use App\Services\AuctionProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Clients extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth('admin')->user()){
            $clients = Client::paginate();

            return view('pages.clients.index', get_defined_vars());
        }else{
          abort(404);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $cities = City::get();
      return view('pages.clients.add', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreClientRequest  $storeRequest
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $storeRequest)
    {
      try{

        Client::create($storeRequest->validated() +
        ['auction_id'=> Auth::guard('auction')->check() ? Auth::guard('auction')->user()->id : null]);

        alert()->success('تم الأضافة بنجاح');

        if(Auth::guard('auction')->check()){
              return redirect()->route('auction.clients', Auth::guard('auction')->user()->id);
        }

      }catch(\Exception $ex){
          alert()->error('عفوا هناك خطأ تقني');
          return back();
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
//        return $request;
      $client = Client::where('id', $id)->first();
      $cities = City::get();
      $areas = Area::get();
      return view('pages.clients.edit', compact('client', 'cities', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateClientRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateClientRequest $updateRequest, $id)
    {
//       dd($updateRequest->all());
        try{
            Client::where('id', $id)->update($updateRequest->validated());
            alert()->success('تم التحديث بنجاح');

            if(Auth::guard('auction')->check()){
                if ($updateRequest->has('original_url') && $updateRequest->original_url != '') {
                    return redirect(url($updateRequest->original_url));
                } else {
                    return redirect()->route('auction.clients', Auth::guard('auction')->user()->id);
                }
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $client = Client::where('id', $id)->first();
       $client->invoices()->delete();
       $client->auctionProducts()->delete();
       $client->delete();
       alert()->success('تم الحذف نهائيا');
       return back();
    }

    public function softDelete()
    {
      $clients = Client::onlyTrashed()->get();
      return view('pages.clients.soft_delete', compact('clients'));
    }

    public function untrash($id)
    {
      Client::where('id', $id)->restore();
      alert()->success('تم الغاء الحذف المؤقت');
      return back();
    }

    public function forceDelete($id)
    {
        Client::where('id', $id)->forceDelete();
        alert()->success('تم الحذف نهائيا');
        return back();
    }

    public function ajax_name_clients(Request $request)
    {
      $value = $request->value;
      $user_check = User::where([['id', auth()->user()->id], ['is_admin', 'yes']])->first();
      $check_clients = Client::where('created_by', auth()->user()->id)->where('deleted_at', null)->count();
      if($check_clients  > 0){
          if($value != null){
              $clients = Client::where(function ($query) use ($value) {
                $query->where('name', 'LIKE', "%{$value}%")->orWhere('phone1', 'LIKE', "%{$value}%")->orWhere('username', 'LIKE', "%{$value}%");
              })->where('created_by', auth()->user()->id)->where('deleted_at', null)->get();
          }else{
              $clients = Client::where('created_by', auth()->user()->id)->where('deleted_at', null)->get();
          }
      }else{
          if($user_check){
              if($value != null){
                $clients = Client::where(function ($query) use ($value) {
                    $query->where('name', 'LIKE', "%{$value}%")->orWhere('phone1', 'LIKE', "%{$value}%")->orWhere('username', 'LIKE', "%{$value}%");
                  })->get();
              }else{
                  $clients = Client::where('deleted_at', null)->get();
              }
          }else{
              alert()->error('الصلاحية للمشرفين و العملاء فقط');
              return back();
          }
      }

      $html = view('pages.clients.ajax_clients', compact('clients'))->render();
      return response()->json(['clients' => $html]);
    }

    public function ajax_date_clients(Request $request)
    {
      $date_from = $request->date_from;
      $date_to = $request->date_to;
      $user_check = User::where([['id', auth()->user()->id], ['is_admin', 'yes']])->first();
      $check_clients = Client::where('created_by', auth()->user()->id)->where('deleted_at', null)->count();
      if($check_clients  > 0){
          if($date_from != null && $date_to != null){
              $clients = Client::whereBetween('created_at', [$date_from, $date_to])->where('created_by', auth()->user()->id)->where('deleted_at', null)->get();
          }elseif($date_from != null && $date_to == null){
              $clients = Client::whereDate('created_at', '>=', $date_from)->where('created_by', auth()->user()->id)->where('deleted_at', null)->get();
          }elseif($date_from == null && $date_to != null){
              $clients = Client::whereDate('created_at', '<=', $date_from)->where('created_by', auth()->user()->id)->where('deleted_at', null)->get();
          }else{
              $clients = Client::where('created_by', auth()->user()->id)->where('deleted_at', null)->get();
          }

      }else{

          if($user_check){
            if($date_from != null && $date_to != null){
                $clients = Client::whereBetween('created_at', [$date_from, $date_to])->where('deleted_at', null)->get();
            }elseif($date_from != null && $date_to == null){
                $clients = Client::whereDate('created_at', '>=', $date_from)->where('deleted_at', null)->get();
            }elseif($date_from == null && $date_to != null){
                $clients = Client::whereDate('created_at', '<=', $date_from)->where('deleted_at', null)->get();
            }else{
                $clients = Client::where('created_by', auth()->user()->id)->where('deleted_at', null)->get();
            }

          }else{
              alert()->error('الصلاحية للمشرفين و العملاء فقط');
              return back();
          }
      }

      $html = view('pages.clients.ajax_clients', compact('clients'))->render();
      return response()->json(['clients' => $html]);
    }

    public function show_area_clients(Request $request)
    {
      $city = $request->city_id;
      $areas = Area::where('city_id', $city)->get();
      $html = view('pages.clients.ajax_area', compact('areas'))->render();
      return response()->json(['status' => true, 'areas' => $html]);
    }
    public function getClientsData(Request $request) {


        $query = $request->input('q');
        $data = Client::whereNotNull('username')
            ->where('username', 'like', "%$query%")
            ->where('auction_id', auth('auction')->user()->id)
            ->select('id', 'username')
            ->get()
            ->toArray();
        return response()->json($data);
    }
    public function getProductsData(Request $request) {

        $query = $request->input('query');
        $data = Product::query()->where('auction_id', auth('auction')->user()->id)
            ->where('name', 'like', "%$query%")
            ->select('id', 'name')
            ->get()
            ->toArray();
        return response()->json($data);
    }

    public function search_clients(Request $request)
    {
        $mobile = $request->mobile;
        if($mobile != null){
          $client = Client::where('phone1', $mobile)->orWhere('phone2', $mobile)
          ->where('auction_id',auth('auction')->user()->id)->first();
          if($client)
          {
                $html = view('pages.clients.search_clients', compact('client'))->render();
                return response()->json(['status' => 'success', 'client' => $html]);
          }else{
                $html = view('pages.clients.search_clients')->render();
                return response()->json(['status' => 'success', 'client' => $html]);
          }
        }else{
          $html = view('pages.clients.search_clients')->render();
          return response()->json(['status' => 'success', 'client' => $html]);
        }
    }

    public function search_clients_auctions(Request $request)
    {

        $clients = Client::where('username', 'LIKE', '%' . $request->username . '%')
        ->where('auction_id',auth('auction')->user()->id)->get();

        if ($clients->count() > 0) {
            if($clients) {
                $html = view('pages.auction-products.get_clients', compact('clients'))->render();
                return response()->json(['status' => 'success', 'client' => $html]);
            }
        }
    }
    public function new_search_clients_auctions(Request $request)
    {

        $clients = Client::where('username', 'LIKE', '%' . $request->username . '%')
        ->where('auction_id',auth('auction')->user()->id)->get();

        if ($clients->count() > 0) {
            if($clients) {
                $html = view('pages.auction-products.new_get_clients', compact('clients'))->render();
                return response()->json(['status' => 'success', 'client' => $html]);
            }
        }
    }

    public function search_products_auctions(Request $request)
    {
        $name = $request->name;
        $products = Product::where('name', 'LIKE', '%' . $name . '%')
        ->where('auction_id',auth('auction')->user()->id)->get();

        if ($products->count() > 0) {
            if($products) {
                $html = view('pages.auction-products.get_products', compact('products'))->render();
                return response()->json(['status' => 'success', 'client' => $html]);
            }
        }
    }

    public function checkClient()
    {
      $cities = City::get();
      return view('pages.clients.check_client', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCheckClient(Request $request)
    {
      try {

          $client = Client::where('username', $request->username)->orWhere('phone1', $request->phone1)->first();

          if ($client) {

              $code = $request->code;
              $checkAuction = AuctionProduct::whereHas('auction', function ($query) use ($code) {
                  $query->where('code', $code);
              })->where('client_id', $client->id)->get();

              if ($checkAuction->count() > 0) {

                  Client::where('id', $client->id)->update([
                    'username'      => $request->username,
                    'phone1'        => $request->phone1,
                    'area_id'       => $request->area_id,
                    'piece'         => $request->piece,
                    'street'        => $request->street,
                    'avenue'        => $request->avenue,
                    'house_number'  => $request->house_number,
                     //'address'       => $request->address,
                    //'note'          => $request->note
                  ]);
              }else{
                alert()->error('كود المزاد ليس صحيحا');
                return back();
              }
          }else{

              Client::create([
                'username'      => $request->username,
                'phone1'        => $request->phone1,
                'area_id'       => $request->area_id,
                'piece'         => $request->piece,
                'street'        => $request->street,
                'avenue'        => $request->avenue,
                'house_number'  => $request->house_number,
                //'address'       => $request->address,
                //'note'          => $request->note
              ]);
          }

          alert()->success('تم أعتماد بياناتك بنجاح');
          return back();

      }catch(\Exception $ex){
        return $ex;
        alert()->error('عفوا هناك خطأ تقني');
        return back();
      }
    }

}


