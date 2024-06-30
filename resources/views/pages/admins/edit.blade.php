@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">أضافة مشرف</h3>
            </div>
            <form class="form" action="{{route('mangers.update', $user->id)}}" method="POST">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>الأسم</label>
                            <input type="text" class="form-control form-control-solid" name="name" value="{{$user->name}}">
                            @error('name')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>البريد الألكتروني</label>
                            <input type="email" class="form-control form-control-solid" name="email" value="{{$user->email}}">
                            @error('email')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>موبايل 1</label>
                            <input type="number" class="form-control form-control-solid" name="phone1" value="{{$user->phone1}}">
                            @error('phone1')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>موبايل 2</label>
                            <input type="number" class="form-control form-control-solid" name="phone2" value="{{$user->phone2}}">
                            @error('phone2')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>كلمة السر</label>
                            <input type="password" class="form-control form-control-solid" name="password">
                            @error('password')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>


                        <div class="form-group col-lg-6">
                            <label>الراتب</label>
                            <input type="number" class="form-control form-control-solid" name="salary" value="{{$user->salary}}">
                            @error('salary')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>


                        <div class="form-group col-lg-12">
                            <h4 class="alert alert-primary"> اختار الصلاحيات</h4>
                        </div>

                        @foreach(\Spatie\Permission\Models\Role::all() as $role)
                        <div class="form-group col-4">
                            <h4 class="alert alert-primary"> {{$role->name}}</h4>
                            @foreach($role->permissions as $permission)
                            <div class="checkbox-list">
                                <label class="checkbox" style="margin:10px 0">
                                  <input type="checkbox" name="permissions[]" value="{{$permission->id}}"
                                  @if($user->hasPermissionTo($permission->id))
                                    checked
                                  @endif
                                  >  <span></span> {{$permission->name}}
                                </label>
                            </div>
                            @endforeach
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
