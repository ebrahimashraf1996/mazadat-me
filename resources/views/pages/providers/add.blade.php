@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <a href="{{route('providers.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px"> الموردين</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">

                <h3 class="card-title">أضافة مورد</h3>
            </div>

            <form class="form" action="{{route('providers.store')}}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-lg-6">
                        <label>الأسم</label>
                        <input type="text" class="form-control form-control-solid" name="name">
                        @error('name')
                          <span class="text-danger">{{$message}} </span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-6">
                        <label>البريد الألكتروني</label>
                        <input type="email" class="form-control form-control-solid" name="email">
                        @error('email')
                          <span class="text-danger">{{$message}} </span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-6">
                        <label>موبايل 1</label>
                        <input type="number" class="form-control form-control-solid" name="phone1">
                        @error('phone1')
                          <span class="text-danger">{{$message}} </span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-6">
                        <label>موبايل 2</label>
                        <input type="number" class="form-control form-control-solid" name="phone2">
                        @error('phone2')
                          <span class="text-danger">{{$message}} </span>
                        @enderror
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
