<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permissions extends Controller
{
    public function index()
    {
        return view('pages.permissions.index');
    }

    public function create()
    {
        return view('pages.permissions.add');
    }

    public function store(Request $request)
    {
      try{
          $role = Role::find($request->role_id);
          $permission_check = Permission::where(['name' => $request->name])->first();
          if(!$permission_check){
            $permission = Permission::create(['guard_name' => 'admin', 'name' => $request->name]);
            $role->givePermissionTo($permission);
            alert()->success('تم الأضافة بنجاح');
            return back();
          }else{
            alert()->error('عفوا تم أضافة هذه الصلاحية من قبل');
            return back();
          }
        }catch(\Exception $ex){
          alert()->error('هناك خطا تقني يرجي المراجعة', 'Error');
          return back();
        }
    }

    public function show($id)
    {
        $user = User::where('id', $id)->first();
        return view('pages.permissions.users_permissions', compact('user'));
    }

    public function users_permissions(Request $request, $id)
    {
        $user = User::find($id);
        $permissions = $request->permissions;
        $user->syncPermissions($permissions);
        alert()->success('تم تحديد الصلاحيات');
        return back();
    }

    public function edit($id)
    {
        $permission = Permission::where('id', $id)->first();
        return view('pages.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
      try{
          $role = Role::find($request->role_id);
          $permission = Permission::where('id', $id)->where(['name' => $request->name]);
          $role->givePermissionTo($id);
          alert()->success('تم التحديث بنجاح');
          return back();
        }catch(\Exception $ex){
          alert()->error('هناك خطا تقني يرجي المراجعة', 'Error');
          return back();
        }
    }

    public function destroy($id)
    {
        $permission = Permission::where('id', $id)->first();
        $permission->delete();
        alert()->success('تم الحذف مؤقتا');
        return back();
    }
    
}
