<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\User;
use Validator;
use Auth;

class Services extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_check = User::where([['id', auth()->user()->id], ['is_admin', 'yes']])->first();
        $check_services = Service::where('created_by', auth()->user()->id)->where('deleted_at', null)->count();
        if($check_services  > 0){
            $services = Service::where('created_by', auth()->user()->id)->where('deleted_at', null)->get();
        }else{
            if($user_check){
                $services = Service::where('deleted_at', null)->get();
            }else{
                  alert()->error('الصلاحية للمشرفين و الموظفين فقط');
                  return back();
            }
        }
        return view('pages.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.services.add');
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

        $validator = Validator::make($request->all(), [
          'name'          => 'required|string|unique:services,name',
          'avg_price'     => 'required',
          'time'          => 'sometimes|nullable'
        ],[
          'required'      => 'هذا الحقل مطلوب',
          'name.unique'   => 'تم أضافة هذه الخدمة من قبل',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }


        Service::create([
          'name'        => $request->name,
          'avg_price'   => $request->avg_price,
          'time'        => $request->time,
          'created_by'  => auth()->user()->id
        ]);

        alert()->success('تم الأضافة بنجاح');
        return back();
      }catch(\Exception $ex){
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $service = Service::where('id', $id)->first();
      return view('pages.services.edit', compact('service'));
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

        $validator = Validator::make($request->all(), [
          'name'          => 'required|string|unique:services,name,'.$id,
          'avg_price'     => 'required',
          'time'          => 'sometimes|nullable'
        ],[
          'required'      => 'هذا الحقل مطلوب',
          'name.unique'   => 'تم أضافة هذه الخدمة من قبل',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }


        Service::where('id', $id)->update([
          'name'        => $request->name,
          'avg_price'   => $request->avg_price,
          'time'        => $request->time,
          'updated_by'  => auth()->user()->id
        ]);

        alert()->success('تم التحديث بنجاح');
        return back();
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
      $service = Service::where('id', $id)->first();
      $service->delete();
      alert()->success('تم الحذف مؤقتا');
      return back();
    }


    public function softDelete()
    {
        $services = Service::onlyTrashed()->get();
        return view('pages.services.soft_delete', compact('services'));
    }

    public function untrash(Request $request, $id)
    {
        Service::where('id', $id)->restore();
        alert()->success('تم الغاء الحذف المؤقت');
        return back();
    }

    public function forceDelete(Request $request, $id)
    {
        Service::where('id', $id)->forceDelete();
        alert()->success('تم الحذف نهائيا');
        return back();
    }
}
