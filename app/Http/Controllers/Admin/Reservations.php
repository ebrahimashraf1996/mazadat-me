<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceReservation;
use App\Models\UserResveration;
use App\Models\UserCommission;
use App\Models\Reservation;
use App\Models\InvoiceBranch;
use App\Models\Invoice;
use App\Models\Setting;
use App\Models\Service;
use App\Models\Branch;
use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Validator;
use Auth;
use DB;

class Reservations extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_check = User::where([['id', auth()->user()->id], ['is_admin', 'yes']])->first();
        $check_reservations = Reservation::where('created_by', auth()->user()->id)->where('deleted_at', null)->orderBy('id', 'desc')->count();
        if($check_reservations  > 0){
            $reservations = Reservation::where('created_by', auth()->user()->id)->where('deleted_at', null)->orderBy('id', 'desc')->get();
        }else{
            if($user_check){
                $reservations = Reservation::where('deleted_at', null)->orderBy('id', 'desc')->get();
            }else{
                  alert()->error('الصلاحية للمشرفين و الموظفين فقط');
                  return back();
            }
        }

        return view('pages.reservations.index', compact('reservations'));
    }

    public function nextReservations()
    {
        $user_check = User::where([['id', auth()->user()->id], ['is_admin', 'yes']])->first();
        $check_reservations = Reservation::where('created_by', auth()->user()->id)->where('deleted_at', null)->where('status', 'queue')->whereDate('date', '>', Carbon::now()->format('Y-m-d'))->count();
        if($check_reservations  > 0){
            $reservations = Reservation::where('created_by', auth()->user()->id)->where('deleted_at', null)->where('status', 'queue')->whereDate('date', '>', Carbon::now()->format('Y-m-d'))->get();
        }else{
            if($user_check){
                $reservations = Reservation::where('deleted_at', null)->where('status', 'queue')->whereDate('date', '>', Carbon::now()->format('y-m-d'))->get();
            }else{
                  alert()->error('الصلاحية للمشرفين و الموظفين فقط');
                  return back();
            }
        }
        return view('pages.reservations.next_reservations', compact('reservations'));
    }

    public function todayReservations()
    {

        $user_check = User::where([['id', auth()->user()->id], ['is_admin', 'yes']])->first();
        $check_reservations = Reservation::where('created_by', auth()->user()->id)->where('deleted_at', null)->whereDate('date', Carbon::now()->format('y-m-d'))->count();
        if($check_reservations  > 0){
            $reservations = Reservation::where('created_by', auth()->user()->id)->where('deleted_at', null)->whereDate('date', Carbon::now()->format('y-m-d'))->get();
        }else{
            if($user_check){
                $reservations = Reservation::where('deleted_at', null)->whereDate('date', Carbon::now()->format('y-m-d'))->get();
            }else{
                  alert()->error('الصلاحية للمشرفين و الموظفين فقط');
                  return back();
            }
        }
        return view('pages.reservations.today_reservations', compact('reservations'));
    }

    public function offReservations()
    {
        $user_check = User::where([['id', auth()->user()->id], ['is_admin', 'yes']])->first();
        $check_reservations = Reservation::where('created_by', auth()->user()->id)->where('deleted_at', null)->whereDate('date', '<', Carbon::now()->format('y-m-d'))->count();
        if($check_reservations  > 0){
            $reservations = Reservation::where('created_by', auth()->user()->id)->where('deleted_at', null)->whereDate('date', '<', Carbon::now()->format('y-m-d'))->get();
        }else{
            if($user_check){
                $reservations = Reservation::where('deleted_at', null)->whereDate('date', '<', Carbon::now()->format('y-m-d'))->get();
            }else{
                  alert()->error('الصلاحية للمشرفين و الموظفين فقط');
                  return back();
            }
        }
        return view('pages.reservations.off_reservations', compact('reservations'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branchs = Branch::get();
        $services = Service::get();
        $users = User::where('is_admin', 'no')->get();
        return view('pages.reservations.add', compact('branchs', 'services', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try{


        if($request->service_id == null){
          alert()->error('عفوا يجب أختيار الخدمات');
          return back();
        }

        $services[] = $request->service_id;
        $setting = Setting::latest()->first();
        $services_price = Service::whereIn('id', $request->service_id)->sum('avg_price');
        $discount_number = $request->discount_number;
        $discount_parcent = $request->discount_parcent;
        if($discount_number != null){
            $total_price = $services_price - $discount_number;
            $total = (int)($total_price) + ((int)($total_price) * (int)($setting->tax) /100);
        }elseif($discount_parcent != null){
            $total_price = (int)($services_price) - ((int)($services_price) * (int)($discount_parcent) /100);
            $total = (int)($total_price) + ((int)($total_price) * (int)($setting->tax) /100);
        }else{
            $total_price = $services_price;
            $total = (int)($total_price) + ((int)($total_price) * (int)($setting->tax) /100);
        }

        if($discount_number != null && $discount_parcent != null){
            alert()->error('عفوا يجب تحديد الخصم بالقيمة او بالنسبة');
        }

        if($request->date != null){
            $date =  $request->date;
            $time = $request->time;
        }else{
            $date =  Carbon::now()->format('y-m-d');
            $time = Carbon::now()->format('H:i');
        }

        $client;
        if($request->client_id == null){

          $validator = Validator::make($request->all(), [
            'branch_id'           => 'required|exists:branchs,id',
            'status'              => 'required',
            'date'                => 'sometimes|nullable',
            'time'                => 'sometimes|nullable',
            'discount_number'     => 'sometimes|nullable',
            'discount_parcent'    => 'sometimes|nullable',
            'name'                => 'sometimes|nullable',
            'phone1'              => 'required|unique:clients,phone1',
            'count_clients'       => 'sometimes|nullable|integer',
            'note'                => 'sometimes|nullable|string',
            'service_id'          => 'required|array|min:1',
            'user_id'             => 'required|array|min:1'
          ],[
            'required'            => 'هذا الحقل مطلوب',
            'phone1.required'     => 'يجب تسجيل هاتف العميل'
          ]);

          if($validator->fails())
          {
              return back()->withErrors($validator)->withInput();
          }

          $client_id = Client::insertGetId([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone1'        => $request->phone1,
            'phone2'        => $request->phone2,
            'address'       => $request->address,
            'created_by'    => auth()->user()->id
          ]);

          $client = $client_id;
          $reservation = Reservation::create([
              'client_id'         => $client,
              'branch_id'         => $request->branch_id,
              'status'            => $request->status,
              'date'              => $date,
              'time'              => $time,
              'discount_number'   => $discount_number,
              'discount_parcent'  => $discount_parcent,
              'total_price'       => $total,
              'count_clients'     => $request->count_clients,
              'note'              => $request->note,
              'status_paid'       => $request->status_paid,
              'created_by'        => auth()->user()->id
            ]);

        }else{

          $validator = Validator::make($request->all(), [
            'branch_id'           => 'required|exists:branchs,id',
            'status'              => 'required',
            'date'                => 'sometimes|nullable',
            'time'                => 'sometimes|nullable',
            'discount_number'     => 'sometimes|nullable',
            'discount_parcent'    => 'sometimes|nullable',
            'count_clients'       => 'sometimes|nullable|integer',
            'note'                => 'sometimes|nullable|string',
            'service_id'          => 'required|array|min:1',
            'user_id'             => 'required|array|min:1'
          ],[
            'required'      => 'هذا الحقل مطلوب',
          ]);

          if($validator->fails())
          {
              return back()->withErrors($validator)->withInput();
          }

          $client = $request->client_id;
          $reservation = Reservation::create([
              'client_id'           => $request->client_id,
              'branch_id'           => $request->branch_id,
              'status'              => $request->status,
              'date'                => $date,
              'time'                => $time,
              'discount_number'     => $discount_number,
              'discount_parcent'    => $discount_parcent,
              'total_price'         => $total,
              'status_reservation'  => $request->status_reservation,
              'count_clients'       => $request->count_clients,
              'note'                => $request->note,
              'status_paid'       => $request->status_paid,
              'created_by'          => auth()->user()->id
            ]);

        }

        foreach($request->service_id as $service){
          ServiceReservation::create([
              'service_id'          => $service,
              'reservation_id'      => $reservation->id,
              'created_by'          => auth()->user()->id
          ]);
        }

        foreach($request->user_id as $user){
            UserResveration::create([
              'user_id'             => $user,
              'reservation_id'      => $reservation->id,
              'created_by'          => auth()->user()->id
          ]);
        }

        $setting_invoice = InvoiceBranch::take(1)->first();
        $tax_number = 310223727500003;
        $number = ++$setting_invoice->number;
        $prefix = $setting_invoice->prefix;
        $invoice_number = $prefix .'' . str_pad($number, 5,"0", STR_PAD_LEFT);
        $count_views = Reservation::where('client_id', $request->client_id)->count();
        $amount_not_tax = (int)($total_price) - ((int)($total_price) * (int)($setting->tax) /100);

        Invoice::create([
          'reservation_id'        => $reservation->id,
          'tax_number'            => $tax_number,
          'invoice_number'        => $invoice_number,
          'amount_not_tax'        => $total_price,
          'count_views'           => $amount_not_tax,
          //'worker_commission'     =>  ,
          'created_by'            => auth()->user()->id,
        ]);
        DB::commit();
        alert()->success('تم الأضافة بنجاح');
        return redirect()->route('reservations.index');
      }catch(\Exception $ex){
        return $ex;
        DB::rollback();
        alert()->error('عفوا هناك خطأ تقني');
        return back();
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Reservation::where('id', $id)->first();
        return view('pages.reservations.show', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $branchs = Branch::get();
      $services = Service::get();
      $users = User::where('is_admin', 'no')->get();
      $reservation = Reservation::where('id', $id)->first();
      $client = Client::where('id', $reservation->client_id)->first();
      //===================================================================
      $discount_number = $reservation->discount_number;
      $discount_parcent = $reservation->discount_parcent;
      $total = $reservation->total_price;

      if($discount_number != null){
          $discount = $discount_number;
      }elseif($discount_parcent != null){
          $discount = $discount_parcent;
      }else{
          $discount = 0;
      }

      $service_price = 0;
      foreach ($reservation->service_reservation as $row) {
        $service_price += Service::where('id', $row->service_id)->first()->avg_price;

      }

      $total_price_services = $service_price;
      return view('pages.reservations.edit', compact('users', 'branchs', 'services', 'reservation', 'client', 'total', 'discount', 'total_price_services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      try{
        if($request->service_id == null){
          alert()->error('عفوا يجب أختيار الخدمات');
          return back();
        }
        $services[] = $request->service_id;
        $setting = Setting::latest()->first();
        $services_price = Service::whereIn('id', $request->service_id)->sum('avg_price');

        $discount_number = $request->discount_number;
        $discount_parcent = $request->discount_parcent;
        if($discount_number != null){
            $total_price = $services_price - $discount_number;
            $total = (int)($total_price) + ((int)($total_price) * (int)($setting->tax) /100);
        }elseif($discount_parcent != null){
            $total_price = (int)($services_price) - ((int)($services_price) * (int)($discount_parcent) /100);
            $total = (int)($total_price) + ((int)($total_price) * (int)($setting->tax) /100);
        }else{
            $total_price = $services_price;
            $total = (int)($total_price) + ((int)($total_price) * (int)($setting->tax) /100);
        }

        if($discount_number != null && $discount_parcent != null){
            alert()->error('عفوا يجب تحديد الخصم بالقيمة او بالنسبة');
        }

          $validator = Validator::make($request->all(), [
            'branch_id'           => 'required|exists:branchs,id',
            'status'              => 'required',
            'date'                => 'required',
            'time'                => 'required',
            'discount'            => 'sometimes|nullable',
            'discount_type'       => 'sometimes|nullable',
            'count_clients'       => 'sometimes|nullable|integer',
            'note'                => 'sometimes|nullable|string',
            'service_id'          => 'required|array',
            'user_id'             => 'required|array'
          ],[
            'required'      => 'هذا الحقل مطلوب',
          ]);

          if($validator->fails())
          {
              return back()->withErrors($validator)->withInput();
          }

          Reservation::where('id', $id)->update([
              'branch_id'           => $request->branch_id,
              'status'              => $request->status,
              'date'                => $request->date,
              'time'                => $request->time,
              'discount_number'     => $discount_number,
              'discount_parcent'    => $discount_parcent,
              'total_price'         => $total,
              'status_reservation'  => $request->status_reservation,
              'status_reservation'  => $request->status_reservation,
              'count_clients'       => $request->count_clients,
              'status_paid'       => $request->status_paid,
              'updated_by'    => auth()->user()->id
            ]);

            $service_reservations = ServiceReservation::where('reservation_id', $id)->get();
            foreach($service_reservations as $row){
                $sr = ServiceReservation::where('reservation_id', $id)->first();
                $sr->forceDelete();
            }
            foreach($request->service_id as $service){
              ServiceReservation::create([
                  'service_id'          => $service,
                  'reservation_id'      => $id,
                  'created_by'          => auth()->user()->id
              ]);
            }


            $user_reservations = UserResveration::where('reservation_id', $id)->get();
            foreach($user_reservations as $row){
                $sr = UserResveration::where('reservation_id', $id)->first();
                $sr->forceDelete();
            }

            foreach($request->user_id as $user){
                UserResveration::create([
                  'user_id'             => $user,
                  'reservation_id'      => $id,
                  'created_by'          => auth()->user()->id
              ]);
            }

          alert()->success('تم التحديث بنجاح');
          return back();
      }catch(\Exception $ex){
        return $ex;
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
      $invoice = Invoice::where('reservation_id', $id)->first();
      $invoice->delete();
      //========================================================================
      $user_reservation = UserResveration::where('reservation_id', $id)->first();
      $user_reservation->delete();
      //========================================================================
      $service_reservation = ServiceReservation::where('reservation_id', $id)->first();
      $service_reservation->delete();
      //========================================================================
      $reservation = Reservation::find($id);
      $reservation->delete();
      alert()->success('تم الحذف مؤقتا');
      return back();
    }

    public function search_clients(Request $request)
    {
        $mobile = $request->mobile;
        if($mobile != null){
          $client = Client::where('phone1', $mobile)->orWhere('phone2', $mobile)->first();
          if($client)
          {
                $html = view('pages.reservations.search_clients', compact('client'))->render();
                return response()->json(['status' => 'success', 'client' => $html]);
          }else{
                $html = view('pages.reservations.search_clients')->render();
                return response()->json(['status' => 'success', 'client' => $html]);
          }
        }else{
          $html = view('pages.reservations.search_clients')->render();
          return response()->json(['status' => 'success', 'client' => $html]);
        }

    }


    public function search_reservations(Request $request)
    {
        $mobile = $request->mobile;
        if($mobile != null){
          $reservations = Reservation::whereHas('client', function($query) use($mobile){
              $query->where('phone1', 'LIKE', "%{$mobile}%")->orWhere('phone2', 'LIKE', "%{$mobile}%");
          })->get();
          $html = view('pages.reservations.ajax_reservations', compact('reservations'))->render();
          return response()->json(['status' => 'success', 'reservations' => $html]);
        }else{

          $reservations = Reservation::get();
          $html = view('pages.reservations.ajax_reservations', compact('reservations'))->render();
          return response()->json(['status' => 'success', 'reservations' => $html]);
        }
    }

    public function softDelete()
    {
        $reservations = Reservation::onlyTrashed()->get();
        return view('pages.reservations.soft_delete', compact('reservations'));
    }

    public function untrash(Request $request, $id)
    {
      $invoice = Invoice::where('reservation_id', $id)->first();
      $invoice->restore();
      //========================================================================
      $user_reservation = UserResveration::where('reservation_id', $id)->first();
      $user_reservation->restore();
      //========================================================================
      $service_reservation = ServiceReservation::where('reservation_id', $id)->first();
      $service_reservation->restore();
      //========================================================================
        Reservation::where('id', $id)->restore();
        alert()->success('تم الغاء الحذف المؤقت');
        return back();
    }

    public function forceDelete(Request $request, $id)
    {
        Reservation::where('id', $id)->forceDelete();
        alert()->success('تم الحذف نهائيا');
        return back();
    }

    public function price_reservations(Request $request)
    {
        $services = $request->services;
        $discount_number = $request->discount_number;
        $discount_parcent = $request->discount_parcent;
        $setting = Setting::latest()->first();
        $services_price = Service::whereIn('id', $services)->sum('avg_price');

        $discount = 0;
        if($discount_number != null){
            $total_price = $services_price - $discount_number;
            $discount =  $discount_number;
            $total = (int)($total_price) + ((int)($total_price) * (int)($setting->tax) /100);
        }elseif($discount_parcent != null){
            $total_price = (int)($services_price) - ((int)($services_price) * (int)($discount_parcent) /100);
            $discount =  ((int)($services_price) * (int)($discount_parcent) /100);
            $total = (int)($total_price) + ((int)($total_price) * (int)($setting->tax) /100);
        }else{
            $total_price = $services_price;
            $total = (int)($total_price) + ((int)($total_price) * (int)($setting->tax) /100);
        }

        $total_services = $services_price;
        return response()->json([
          'status'          => 'success',
          'total_price'     => $total,
          'discount'        => $discount,
          'total_services'  => $total_services
        ]);

    }


    public function reservations_services_delete($id)
    {
      $sr = ServiceReservation::where('id', $id)->first();
      $sr->delete();
      alert()->success('تم الحذف مؤقتا');
      return back();
    }

    public function reservations_approve($id)
    {

      $resveration = Reservation::where('id', $id)->first();

      $resveration->update([
          'status_reservation' => 'موافقة'
      ]);

      $user_reservations = UserResveration::where('reservation_id', $id)->get();
      foreach($user_reservations as $user){
          $user_commission = User::where('id', $user->user_id)->first()->commission;
          $total_commission = ceil((int)($resveration->total_price) * (int)($user_commission) /100);
          UserResveration::where([['reservation_id', $id], ['user_id', $user->user_id]])->update([
            'commission'          => $total_commission,
        ]);

        $user_commission = UserCommission::where('user_id', $user->user_id)->first();
        if($user_commission){
          $user_commission->update(['commission' => $user_commission->commission + $total_commission]);
        }else{
          UserCommission::create([
              'user_id'     => $user->user_id,
              'commission'  => $total_commission
          ]);
        }
      }


      alert()->success('تم الموافقة بنجاح');
      return back();
    }

    public function reservations_cancel($id)
    {
      Reservation::where('id', $id)->update([
          'status_reservation' => 'الغاء'
      ]);

      alert()->success('تم الغاء الحجز بنجاح');
      return back();
    }

}
