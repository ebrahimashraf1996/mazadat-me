<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use App\Models\UserBranch;
use Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Validator;

class Employees extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $employees = User::where('deleted_at', null)->get();
        return view('pages.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $branchs = Branch::where('deleted_at', null)->get();
        return view('pages.employees.add', compact('branchs'));
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
          'email'         => 'sometimes|nullable|email|unique:users',
          'phone1'        => 'sometimes|nullable',
          'phone2'        => 'sometimes|nullable',
          'password'      => 'sometimes|nullable',
          'salary'        => 'sometimes|nullable',
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
          'name'        => $request->name,
          'email'       => $request->email,
          'password'    => Hash::make($request->password),
          'phone1'      => $request->phone1,
          'phone2'      => $request->phone2,
          'salary'      => $request->salary,
        ]);

        $roles = $request->roles;
        $user->assignRole($roles);

        alert()->success('تم الأضافة بنجاح');
        return back();
      }catch(\Exception $ex){
        return back()->withErrors($ex->getMessage())->withInput();
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
        $user = User::where('id', $id)->first();
        $branchs = Branch::where('deleted_at', null)->get();
        return view('pages.employees.edit', compact('user', 'branchs'));
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
          'email'         => 'sometimes|nullable|email|unique:users,email,'.$id,
          'phone1'        => 'sometimes|nullable',
          'phone2'        => 'sometimes|nullable',
          'password'      => 'sometimes|nullable',
          'salary'        => 'sometimes|nullable',
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('id', $id)->first();
        if($request->has('password') && $request->password != null){
          $password =  Hash::make($request->password);
        }else{
          $password = $user->password;
        }

        $user->update([
          'name'        => $request->name,
          'email'       => $request->email,
          'password'    => $password,
          'phone1'      => $request->phone1,
          'phone2'      => $request->phone2,
          'salary'      => $request->salary,
        ]);

        $roles = $request->roles;
        if(!empty($roles)){
          $user->syncRoles($roles);
          foreach($roles as $row){
             $role = Role::where('id',$row)->first();
             $permissions = $role->getAllPermissions();
             $user->syncPermissions($permissions);
          }
        }

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
      $user = User::where('id', $id)->first();
      $user->delete();
      alert()->success('تم الحذف مؤقتا');
      return back();
    }

    public function softDelete()
    {
        $employees = User::onlyTrashed()->get();
        return view('pages.employees.soft_delete', compact('employees'));
    }

    public function untrash(Request $request, $id)
    {
        User::where('id', $id)->restore();
        alert()->success('تم الغاء الحذف المؤقت');
        return back();
    }

    public function forceDelete(Request $request, $id)
    {
        User::where('id', $id)->forceDelete();
        alert()->success('تم الحذف نهائيا');
        return back();
    }

    public function updateSheift(Request $request, $id)
    {
        $value = $request->value;
        if($value == null){
          $value = 'لم يحدد';
        }
        User::where('id', $id)->update(['shift_work'  => $value]);
        return back();
    }        

}
