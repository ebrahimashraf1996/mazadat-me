<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Hash;

class Mangers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('is_admin', 'yes')->get();
        return view('pages.admins.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admins.add');
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
          'email'         => 'required|email|unique:users',
          'phone1'        => 'required',
          'phone2'        => 'sometimes|nullable',
          'password'      => 'required',
          'salary'        => 'sometimes|nullable'
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
          'is_admin'    => 'yes'
        ]);

        $roles = $request->roles;
        $user->syncRoles($roles);
        alert()->success('تم الأضافة بنجاح');
        return back();
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
        $user = User::find($id);
        return view('pages.admins.edit', compact('user'));
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
          'email'         => 'required|email|unique:users,email,'.$id,
          'phone1'        => 'required',
          'phone2'        => 'sometimes|nullable',
          'password'      => 'sometimes|nullable',
          'salary'        => 'sometimes|nullable'
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        if($request->has('password')){
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

        $permissions = $request->permissions;
        $user->syncPermissions($permissions);
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
        //
    }
}
