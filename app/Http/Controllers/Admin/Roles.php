<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.roles.add');
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
        $role_check = Role::where('name', $request->name)->first();
        $permissions = $request->permissions;

        if(!$role_check){
            $role = Role::create(['guard_name' => 'admin', 'name' => $request->name]);
            $role->givePermissionTo($permissions);
            alert()->success('تم الأضافة بنجاح');
        }else{
            alert()->error('عفوا هذه المجموعة موجودة بالفعل');
        }
        return back();
      }catch(\Exception $ex){
        return $ex;
        alert()->error('هناك خطا تقني يرجي المراجعة', 'Error');
        return back();
      }
    }


    public function edit($id)
    {
        $role = Role::where('id', $id)->first();
        return view('pages.roles.edit', compact('role'));
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
            Role::where('id', $id)->update(['name' => $request->name]);
            $role = Role::where('id', $id)->first();
            $permissions = $request->permissions;
            $role->syncPermissions($permissions);
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
        $role = Role::find($id);
        $role->delete();
        alert()->success('تم الحذف مؤقتا');
        return back();
    }
}
