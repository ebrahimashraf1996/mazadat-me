@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">أضافة صلاحية</h3>
            </div>
            <form class="form" action="{{route('permissions.update', $permission->id)}}" method="POST">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>الصلاحية</label>
                            <input type="text" class="form-control form-control-solid" name="name" value="{{$permission->name}}">
                        </div>

                        <div class="form-group col-lg-6">
                            <label>الأقسام</label>
                            <select class="form-control form-control-solid" name="role_id">
                              @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                  <option value="{{$role->id}}" @if($role->hasPermissionTo($permission->id)) selected @endif> {{$role->name}} </option>
                              @endforeach
                            </select>
                        </div>
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
