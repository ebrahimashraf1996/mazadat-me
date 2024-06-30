@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
      <a href="{{route('clients.index')}}" class="btn btn-success" style="border-radius:0;font-size:20px"> العملاء</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">تعديل العميل</h3>
            </div>
            <form class="form" action="{{route('clients.update', $client->id)}}" method="POST">
                @csrf
                {{method_field('PUT')}}
                <input type="hidden" name="original_url" value="{{request()->has('original_url') && request()->original_url != '' ? request()->original_url : ''}}">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>الأسم</label>
                            <input type="text" class="form-control form-control-solid" name="name" value="{{$client->name}}">
                            @error('name')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>اسم المستخدم</label>
                            <input type="text" class="form-control form-control-solid" name="username" value="{{$client->username}}">
                            @error('username')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>موبايل 1</label>
                            <input type="number" class="form-control form-control-solid" name="phone1" value="{{$client->phone1}}">
                            @error('phone1')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>موبايل 2</label>
                            <input type="number" class="form-control form-control-solid" name="phone2" value="{{$client->phone2}}">
                            @error('phone2')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>


                        <div class="form-group col-lg-6">
                            <label>المدينة</label>
                            <select class="form-control form-control-solid" id="show_area" data-url="{{route('show.area.clients')}}">
                                <option value="">أختيار المدينة</option>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}"  @if($city->id == @$client->area->city_id) selected @endif>{{$city->name}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-lg-6">
                            <label>المناطق</label>
                            <select class="form-control form-control-solid" name="area_id" id="clients_areas">
                                @foreach($areas as $area)
                                    <option value="{{$area->id}}"
                                        @if($area->id == $client->area_id) selected @endif
                                    >{{$area->name}}</option>
                                @endforeach
                            </select>
                            @error('area_id')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>العنوان</label>
                            <input type="text" class="form-control form-control-solid" name="address" value="{{$client->address}}">
                            @error('address')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>القطعة</label>
                            <input type="text" class="form-control form-control-solid" name="piece" value="{{$client->piece}}">
                            @error('piece')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>الشارع</label>
                            <input type="text" class="form-control form-control-solid" name="street" value="{{$client->street}}">
                            @error('street')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>جادة</label>
                            <input type="text" class="form-control form-control-solid" name="avenue" value="{{$client->avenue}}">
                            @error('avenue')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>رقم المنزل</label>
                            <input type="text" min="0" class="form-control form-control-solid" name="house_number" value="{{$client->house_number}}">
                            @error('house_number')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>


                        <div class="form-group col-lg-6">
                            <label>ملاحظة</label>
                            <input type="text" class="form-control form-control-solid" name="note" value="{{$client->note}}">
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
