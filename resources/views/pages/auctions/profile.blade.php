@extends('layouts.app')
@section('content')
<!--begin::Content-->
<div class="flex-row-fluid ml-lg-12">
  <!--begin::Card-->
  <div class="card card-custom">
    <!--begin::Header-->
    <div class="card-header py-3">
      <div class="card-title align-items-start flex-column">
        <h3 class="card-label font-weight-bolder text-dark">البيانات الشخصية</h3>
      </div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form class="form" action="{{route('profile.edit', $user->id)}}" method="POST">
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
          <label class="col-xl-3 col-lg-3 col-form-label">الأسم</label>
          <div class="col-lg-9 col-xl-6">
            <div>
              <input class="form-control form-control-lg form-control-solid" name="name" type="text" value="{{$user->name}}" />
              @error('name')
                <span class="text-danger">{{$message}} </span>
              @enderror
            </div>
          </div>
        </div>
        <!--begin::Form Group-->
        <div class="form-group row">
          <label class="col-xl-3 col-lg-3 col-form-label">البريد الألكتروني</label>
          <div class="col-lg-9 col-xl-6">
            <div class="input-group input-group-lg input-group-solid">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="la la-at"></i>
                </span>
              </div>
              <input type="text" name="email" class="form-control form-control-lg form-control-solid" value="{{$user->email}}">
              @error('email')
                <span class="text-danger">{{$message}} </span>
              @enderror
            </div>
          </div>
        </div>
        <!--begin::Form Group-->
        <div class="form-group row">
          <label class="col-xl-3 col-lg-3 col-form-label">موبايل 1</label>
          <div class="col-lg-9 col-xl-6">
            <div class="input-group input-group-lg input-group-solid">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="la la-at"></i>
                </span>
              </div>
              <input type="number" min="0" class="form-control form-control-lg form-control-solid" name="phone1" value="{{$user->phone1}}">
              @error('phone1')
                <span class="text-danger">{{$message}} </span>
              @enderror
            </div>
          </div>
        </div>
        <!--begin::Form Group-->
        <div class="form-group row">
          <label class="col-xl-3 col-lg-3 col-form-label">موبايل 2</label>
          <div class="col-lg-9 col-xl-6">
            <div class="input-group input-group-lg input-group-solid">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="la la-at"></i>
                </span>
              </div>
              <input type="number" min="0" class="form-control form-control-lg form-control-solid" name="phone1" value="{{$user->phone1}}">
              @error('phone2')
                <span class="text-danger">{{$message}} </span>
              @enderror
            </div>
          </div>
        </div>
        @if($user->shift_work != null)
        <!--begin::Form Group-->
        <div class="form-group row">
          <label class="col-xl-3 col-lg-3 col-form-label">شيفت العمل</label>
          <div class="col-lg-9 col-xl-6">
            <div class="input-group input-group-lg input-group-solid">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="la la-at"></i>
                </span>
              </div>
              <input disabled class="form-control form-control-lg form-control-solid" name="shift_work" value="{{$user->shift_work}}">
            </div>
          </div>
        </div>
        @endif

        @if($user->commission != null)
        <!--begin::Form Group-->
        <div class="form-group row">
          <label class="col-xl-3 col-lg-3 col-form-label">نسبة العمولة</label>
          <div class="col-lg-9 col-xl-6">
            <div class="input-group input-group-lg input-group-solid">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="la la-at"></i>
                </span>
              </div>
              <input disabled class="form-control form-control-lg form-control-solid" name="shift_work" value="{{$user->commission}}">
            </div>
          </div>
        </div>
        @endif
      </div>
      <div class="form-group row text-center">
        <div class="col-12"><button type="submit" class="btn btn-success mr-2">حفظ التعديلات</button></div>
      </div>
    </form>
    <!--end::Form-->
  </div>
  <!--end::Card-->
</div>
<!--end::Content-->
@endsection
