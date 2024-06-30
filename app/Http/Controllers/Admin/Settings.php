<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\TraitHelper;
use App\Models\Setting;
use Auth;
use File;
use Illuminate\Http\Request;
use Validator;

class Settings extends Controller
{
    use TraitHelper;

    public function index()
    {
      if(auth('admin')->check()){
        $setting = Setting::where('auction_id' , null)->first();
      }elseif(auth('auction')->check()){
        $setting = Setting::firstOrCreate([
          'auction_id' => auth('auction')->user()->id
        ],[
          'name' => auth('auction')->user()->name,
          'auction_id' => auth('auction')->user()->id,
          'amount_invoice'=> 2
        ]);
      }
      return view('pages.settings.index', compact('setting'));
    }

    public function edit($id)
    {
      if(auth('admin')->check()){
        $setting = Setting::where('auction_id' , null)->first();
      }elseif(auth('auction')->check()){
        $setting = Setting::where('auction_id' , auth('auction')->user()->id)->first();
      }
      return view('pages.settings.edit', compact('setting'));
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
          'name'            => 'required|string',
          'logo'            => 'sometimes|nullable|image|mimes:jpg,png,svg,jpeg',
          'desc'            => 'sometimes|nullable',
          'amount_invoice'  => 'required',
        ],[
          'required'       => 'هذا الحقل مطلوب',
          'logo.mimes'     => 'ترميز الصورة ليس صحيحا'
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $check_setting = Setting::find($id);

        $logo_path = "";
        if($request->has("logo"))
        {
          if(file_exists(public_path($check_setting->logo)))
          {
            \File::delete(public_path($check_setting->logo));
          }

          $logo_path = $this->uploadImage('settings', $request->logo);
        }else{
            $logo_path = $check_setting->logo;
        }

      Setting::where('id', $id)->update([
          'name'            => $request->name,
          'logo'            => $logo_path,
          'desc'            => $request->desc,
          'amount_invoice'  => $request->amount_invoice,
          'updated_by'      => auth('auction')->user()->id
        ]);
        alert()->success('تم التحديث بنجاح');
        return back();
      }catch(\Exception $ex){
        alert()->error('عفوا هناك خطأ تقني');
      }

    }

}
