@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
    @if(auth()->guard('admin')->check())
      <a href="{{route('clients.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px"> العملاء</a>
    @else
      <a href="{{route('auction.clients',auth()->guard('auction')->user()->id)}}"class="btn btn-success" style="border-radius:0;font-size:20px"> العملاء</a>
    @endif
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">أضافة عميل</h3>
            </div>
            <form class="form" action="{{route('clients.store')}}" method="POST">
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
                            <label>اسم المستخدم</label>
                            <input type="text" class="form-control form-control-solid" name="username">
                            @error('username')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>موبايل 1</label>
                            <input type="number" class="form-control form-control-solid" name="phone1" min="0">
                            @error('phone1')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>موبايل 2</label>
                            <input type="number" class="form-control form-control-solid" name="phone2" min="0">
                            @error('phone2')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>المدينة</label>
                            <select class="form-control form-control-solid" id="show_area" data-url="{{route('show.area.clients')}}">
                                <option value="">أختيار المدينة</option>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-lg-6">
                            <label>المناطق</label>
                            <select class="form-control form-control-solid" name="area_id" id="clients_areas"></select>
                            @error('area_id')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>العنوان</label>
                            <input type="text" class="form-control form-control-solid" name="address">
                            @error('address')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>القطعة</label>
                            <input type="text" class="form-control form-control-solid" name="piece">
                            @error('piece')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>الشارع</label>
                            <input type="text" class="form-control form-control-solid" name="street">
                            @error('street')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>جادة</label>
                            <input type="text" class="form-control form-control-solid" name="avenue">
                            @error('avenue')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>رقم المنزل</label>
                            <input type="text" min="0" class="form-control form-control-solid" name="house_number">
                            @error('house_number')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>


                        <div class="form-group col-lg-6">
                            <label>ملاحظة</label>
                            <input type="text" class="form-control form-control-solid" name="note">
                            @error('note')
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
