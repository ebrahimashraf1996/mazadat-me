@extends('layouts.app')
@section('content')
<div class="row" style="padding-right:20px">
    <div class="col-lg-12">
      <a href="{{route('deliveries.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px"> المناديب</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">تعديل المندوب</h3>
            </div>
            <form class="form" action="{{route('deliveries.update', $delivery->id)}}" method="POST">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>الأسم</label>
                            <input type="text" class="form-control form-control-solid" name="name" value="{{$delivery->name}}">
                            @error('name')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>موبايل 1</label>
                            <input type="number" class="form-control form-control-solid" name="phone1" value="{{$delivery->phone1}}">
                            @error('phone1')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>موبايل 2</label>
                            <input type="number" class="form-control form-control-solid" name="phone2" value="{{$delivery->phone2}}">
                            @error('phone2')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>العنوان</label>
                            <input type="text" class="form-control form-control-solid" name="address" value="{{$delivery->address}}">
                            @error('address')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>البريد الألكتروني</label>
                            <input type="email" class="form-control form-control-solid" name="email" value="{{ $delivery->email }}">
                            @error('email')
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

                        <div class="form-group col-lg-12">
                            <h4 class="alert alert-success text-center">أختيار مناطق المندوب</h4>
                        </div>

                        @foreach($cities as $city)
                            <div class="form-group col-12"> 
                                <h4 class="alert alert-primary">{{$city->name}}</h4>
                            </div>
                            
                            @foreach($city->areas as $area)
                            <div class="form-group col-4">
                                <div class="checkbox-list">
                                    <label class="checkbox">
                                    <input type="checkbox" name="area_id[]" value="{{$area->id}}"
                                        @if($delivery->deliveries_areas->where('area_id', $area->id)->count() > 0) checked @endif>
                                        <span></span> {{$area->name}}
                                    </label>
                                </div>
                            </div>
                            @endforeach
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
