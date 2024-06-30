<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\User;
use Validator;

class Providers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_check = User::where([['id', auth()->user()->id], ['is_admin', 'yes']])->first();
        $check_providers = Provider::where('created_by', auth()->user()->id)->where('deleted_at', null)->count();
        if($check_providers  > 0){
            $providers = Provider::where('created_by', auth()->user()->id)->where('deleted_at', null)->get();
        }else{
            if($user_check){
                $providers = Provider::where('deleted_at', null)->get();
            }else{
                  alert()->error('الصلاحية للمشرفين و الموظفين فقط');
                  return back();
            }
        }
        return view('pages.providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.providers.add');
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
          'email'         => 'sometimes|nullable|email|unique:providers',
          'phone1'        => 'sometimes|nullable',
          'phone2'        => 'sometimes|nullable',
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

      Provider::create([
          'name'        => $request->name,
          'email'       => $request->email,
          'phone1'      => $request->phone1,
          'phone2'      => $request->phone2,
        ]);

        alert()->success('تم الأضافة بنجاح');
        return redirect()->route('providers.index');
      }catch(\Exception $ex){
        return $ex;
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
      $provider = Provider::where('id', $id)->first();
      return view('pages.providers.edit', compact('provider'));
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
          'email'         => 'sometimes|nullable|email|unique:providers,email,'.$id,
          'phone1'        => 'sometimes|nullable',
          'phone2'        => 'sometimes|nullable',
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

      Provider::where('id', $id)->update([
          'name'        => $request->name,
          'email'       => $request->email,
          'phone1'      => $request->phone1,
          'phone2'      => $request->phone2,
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
      $provider = Provider::find($id);
      $provider->delete();
      alert()->success('تم الحذف مؤقتا');
      return back();
    }

    public function softDelete()
    {
        $providers = Provider::onlyTrashed()->get();
        return view('pages.providers.soft_delete', compact('providers'));
    }

    public function untrash(Request $request, $id)
    {
        Provider::where('id', $id)->restore();
        alert()->success('تم الغاء الحذف المؤقت');
        return back();
    }

    public function forceDelete(Request $request, $id)
    {
        Provider::where('id', $id)->forceDelete();
        alert()->success('تم الحذف نهائيا');
        return back();
    }
}
