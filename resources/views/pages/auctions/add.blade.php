@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <a href="{{route('auctions.index')}}" class="btn btn-success" style="border-radius:0;font-size:20px"> المزادات</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">أضافة مزاد</h3>
            </div>
            <form class="form" action="{{route('auctions.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>الأسم</label>
                            <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>الكود</label>
                            <input type="text" class="form-control form-control-solid" name="code" value="{{ old('code') }}">
                            @error('code')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>البريد الألكتروني</label>
                            <input type="email" class="form-control form-control-solid" name="email" value="{{old('email')}}">
                            @error('email')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>


                        <div class="form-group col-lg-6">
                            <label>تاريخ المزاد</label>
                            <input type="date" class="form-control form-control-solid" name="date" min="0" value="{{old('date')}}">
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
                            <label>الرابط</label>
                            <input type="link" class="form-control form-control-solid" name="link">
                            @error('password')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>المدينة</label>
                            <select class="form-control form-control-solid" name="city_id">
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}"> {{ $city->name }} </option>
                                @endforeach
                            </select>
                            @error('password')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>الموبايل</label>
                            <input type="number" class="form-control form-control-solid" name="phone">
                            @error('phone')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-12">
                            <label>تفاصيل أخري</label>
                            <textarea class="form-control form-control-solid ckeditor" name="details"> </textarea>
                            @error('password')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-12 mx-3">
                            <input type="checkbox" name="clients_backup" class="form-check-input" >
                            <label class="form-check-label"> اضافة نسخة من العملاء لهذا المزاد</label>
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
