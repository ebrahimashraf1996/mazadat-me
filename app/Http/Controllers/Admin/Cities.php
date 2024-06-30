<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class Cities extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::get();
        return view('pages.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $countries = Country::get();
        return view('pages.cities.add', compact('countries'));
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
          'name'          => 'required|string',
          'country_id'    => 'required',
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        City::create([
          'name'        => $request->name,
          'country_id'  => $request->country_id
        ]);

        alert()->success('تم الأضافة بنجاح');
        return redirect()->route('cities.index');
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
    public function edit($id)
    {
      $city = City::where('id', $id)->first();
      $countries = Country::get();
      return view('pages.cities.edit', compact('city', 'countries'));
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
          'name'          => 'required|string',
          'country_id'    => 'required',
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }


        City::where('id', $id)->update([
          'name'        => $request->name,
          'country_id'  => $request->country_id
        ]);

        alert()->success('تم التحديث بنجاح');
       return redirect()->route('cities.index');
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
      $delete = City::where('id', $id)->first();
      $delete->delete();
      alert()->success('تم الحذف مؤقتا');
      return back();
    }


    public function softDelete()
    {
        $services = City::onlyTrashed()->get();
        return view('pages.cities.soft_delete', compact('ountrie'));
    }

    public function untrash(Request $request, $id)
    {
        City::where('id', $id)->restore();
        alert()->success('تم الغاء الحذف المؤقت');
        return back();
    }

    public function forceDelete(Request $request, $id)
    {
      City::where('id', $id)->forceDelete();
        alert()->success('تم الحذف نهائيا');
        return back();
    }
}
