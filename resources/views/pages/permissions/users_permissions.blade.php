@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">الصلاحيات</h3>
            </div>
            <form class="form" action="{{route('users.permissions', $user->id)}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <h4 class="alert alert-primary"> <input type="checkbox" class="check_all">  اختيار جميع الصلاحيات</h4>
                        </div>

                        @foreach(\Spatie\Permission\Models\Role::all() as $role)
                        <div class="form-group col-12">
                            <h4 class="alert alert-primary"> {{$role->name}}</h4>
                            <div class="row">
                            @foreach($role->permissions as $permission)
                            <div class="col-lg-3">
                              <div class="checkbox-list">
                                  <label class="checkbox" style="margin:10px 0">
                                    <input type="checkbox" class="check-permission" name="permissions[]" value="{{$permission->id}}"
                                      @if($user->hasPermissionTo($permission->id)) checked @endif
                                    >  <span></span> {{$permission->name}}
                                  </label>
                              </div>
                            </div>
                            @endforeach
                          </div>
                        </div>
                        @endforeach
                </div>

                    </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Card-->
@endsection
