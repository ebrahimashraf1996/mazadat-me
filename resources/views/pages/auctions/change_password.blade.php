@extends('layouts.app')
@section('content')
<!--begin::Content-->
<div class="flex-row-fluid ml-lg-12">
  <!--begin::Card-->
  <div class="card card-custom">
    <!--begin::Header-->
    <div class="card-header py-3">
      <div class="card-title align-items-start flex-column">
        <h3 class="card-label font-weight-bolder text-dark">تغير كلمة السر</h3>
      </div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form class="form" action="{{route('change.password', $user->id)}}" method="POST">
      @csrf
      {{method_field('PUT')}}
      <div class="card-body">
        <!--begin::Heading-->
        <div class="row">
          <label class="col-xl-3"></label>
          <div class="col-lg-9 col-xl-6">
            <h5 class="font-weight-bold mb-6">البيانات</h5>
          </div>
        </div>
        <!--begin::Form Group-->
        <div class="form-group row">
          <label class="col-xl-3 col-lg-3 col-form-label">كلمة السر القديمة</label>
          <div class="col-lg-9 col-xl-6">
            <div>
              <input class="form-control form-control-lg form-control-solid" name="old_password" type="password" required>
              @error('old_password')
                <span class="text-danger">{{$message}} </span>
              @enderror
            </div>
          </div>
        </div>
        <!--begin::Form Group-->
        <div class="form-group row">
          <label class="col-xl-3 col-lg-3 col-form-label">كلمة السر الجديدة</label>
          <div class="col-lg-9 col-xl-6">
            <div class="input-group input-group-lg input-group-solid">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="la la-at"></i>
                </span>
              </div>
              <input type="password" name="new_password" class="form-control form-control-lg form-control-solid" required>
              @error('new_password')
                <span class="text-danger">{{$message}} </span>
              @enderror
            </div>
          </div>
        </div>
      </div>
      <div class="form-group row text-center">
        <div class="col-12"><button type="submit" class="btn btn-success mr-2">تغير كلمة السر</button></div>
      </div>
    </form>
    <!--end::Form-->
  </div>
  <!--end::Card-->
</div>
<!--end::Content-->
@endsection
