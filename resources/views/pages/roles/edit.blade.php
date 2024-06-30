@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <h3 class="card-title alert alert-success text-center"> تعديل المجموعة </h3>
            <div>
                <a href="{{route('roles.index')}}" class="btn btn-primary title-page">المجموعات</a>
            </div>
            <form class="form" action="{{route('roles.update', $role->id)}}" method="POST">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>الأسم</label>
                            <input type="text" class="form-control form-control-solid" name="name" value="{{$role->name}}">
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group col-lg-12">
                            <h4 class="alert alert-danger"> <input type="checkbox" class="check_all">  اختيار جميع الصلاحيات</h4>
                        </div>
                        @foreach(\Spatie\Permission\Models\Permission::groupBy('page_name')->get('page_name') as $permission)
                          <div class="form-group col-12">
                              <div class="card card-custom gutter-b example example-compact" style="box-shadow: 1px  1px 2px 2px #eee;padding:20px">
                              <h4 class="alert alert-primary"> {{$permission->page_name}}</h4>
                              <div class="row">
                                @foreach(\Spatie\Permission\Models\Permission::where('page_name', $permission->page_name)->get() as $row)
                              <!-- Start -->
                              <div class="col-lg-3">
                                <div class="checkbox-list">
                                    <label class="checkbox" style="margin:10px 0">
                                      <input type="checkbox" class="check-permission" name="permissions[]" value="{{$row->id}}"
                                      @if($row->hasRole($role))
                                          checked
                                      @endif
                                      >  <span></span> {{$row->name}}
                                </div>
                              </div>
                              <!-- End -->
                              @endforeach
                            </div>
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
