<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class Areas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::get();
        return view('pages.areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $cities = City::get();
        return view('pages.areas.add', compact('cities'));
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
          'city_id'       => 'required',
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        Area::create([
          'name'        => $request->name,
          'city_id'     => $request->city_id
        ]);

        alert()->success('تم الأضافة بنجاح');
        return redirect()->route('areas.index');
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
      $area = Area::where('id', $id)->first();
      $cities = City::get();
      return view('pages.areas.edit', compact('area', 'cities'));
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
          'city_id'       => 'required',
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }


        Area::where('id', $id)->update([
          'name'        => $request->name,
          'city_id'     => $request->city_id
        ]);

        alert()->success('تم التحديث بنجاح');
        return redirect()->route('areas.index');
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
      $country = Area::where('id', $id)->first();
         if($country->clinets  != null){
          alert()->error('  عفوا المنطقة مربوطة ببيانات فى السيستم ولا بمكن مسحها' ); 
       }else{    
          $country->delete();
          alert()->success('تم الحذف مؤقتا'); 
       }
     
      return back();
    }

}
