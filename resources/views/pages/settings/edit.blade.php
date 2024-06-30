@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
      <a href="{{route('settings.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px"> الأعدادات</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">تعديل الأعدادات</h3>
            </div>
            <form class="form" action="{{route('settings.update', $setting->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label>اسم السيستم</label>
                            <input type="text" class="form-control" name="name" value="{{$setting->name}}">
                            @error('name')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-4">
                            <label>اللوجو</label>
                            <input type="file" class="form-control" name="logo">
                            @error('logo')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-4">
                            <label>رسوم التوصيل</label>
                            <input type="float" class="form-control" name="amount_invoice" value="{{$setting->amount_invoice}}">
                            @error('amount_invoice')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label>الوصف</label>

                            <textarea type="text" class="form-control" rows="8" name="desc">
                                {{$setting->desc}}
                            </textarea>

                            @error('desc')
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
