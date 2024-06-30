@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
      <a href="{{route('employees.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px"> الموظفين</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">تعديل موظف</h3>
            </div>
            <form class="form" action="{{route('employees.update', $user->id)}}" method="POST">
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
                            <label> هل هو ادمن ؟</label>
                            <select class="form-control form-control-solid" name="is_admin">
                                <option value="yes" @if($user->is_admin == 'yes') selected @endif>نعم</option>
                                <option value="no" @if($user->is_admin == 'no') selected @endif>لا</option>
                            </select>
                            @error('is_admin')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        @if($user->is_admin == 'yes')
                        <div class="form-group col-lg-6">
                            <label>البريد الألكتروني</label>
                            <input type="email" class="form-control form-control-solid" name="email" value="{{$user->email}}">
                            @error('email')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>
                        @endif

                        <div class="form-group col-lg-6">
                            <label>موبايل 1</label>
                            <input type="number" class="form-control form-control-solid" name="phone1" value="{{$user->phone1}}" min="0">
                            @error('phone1')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        @if($user->is_admin == 'yes')
                        <div class="form-group col-lg-6">
                            <label>موبايل 2</label>
                            <input type="number" class="form-control form-control-solid" name="phone2" value="{{$user->phone2}}" min="0">
                            @error('phone2')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>
                        @endif

                        @if($user->is_admin == 'yes')
                        <div class="form-group col-lg-6">
                            <label>كلمة السر</label>
                            <input type="password" class="form-control form-control-solid" name="password">
                            @error('password')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>
                        @endif


                        <div class="form-group col-lg-6">
                            <label>الراتب</label>
                            <input type="number" class="form-control form-control-solid" name="salary" value="{{$user->salary}}" min="0">
                            @error('salary')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>


                        <div class="form-group col-lg-6">
                            <label>نسبة العمولة</label>
                            <input type="float" class="form-control" name="commission" value="{{$user->commission}}" min="0">
                            @error('commission')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

      
                        <div class="form-group col-lg-12">
                            <h4 class="alert alert-primary"> اختار الصلاحيات</h4>
                        </div>

                        <!-- Start Roles -->
                        @foreach(\Spatie\Permission\Models\Role::all() as $role)
                        <div class="form-group col-4">
                            <div class="checkbox-list">
                                <label class="checkbox" style="margin:10px 0">
                                  <input type="checkbox" name="roles[]" value="{{$role->id}}"
                                    @if($user->hasRole($role))
                                        checked
                                    @endif
                                  >  <span></span> {{$role->name}}
                                </label>
                            </div>
                        </div>
                        @endforeach


                <div class="col-12">
                  <div class="card-footer">
                      <button type="submit" class="btn btn-primary mr-2">حفظ</button>
                  </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Card-->
@endsection
