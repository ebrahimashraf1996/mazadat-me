@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
      <a href="{{route('services.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px"> الخدمات</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">أضافة خدمة</h3>
            </div>
            <form class="form" action="{{route('services.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>أسم الخدمة</label>
                            <input type="text" class="form-control form-control-solid" name="name">
                            @error('name')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-3">
                            <label>السعر</label>
                            <input type="number" class="form-control form-control-solid" name="avg_price" min="0">
                            @error('avg_price')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-3">
                            <label> وقت الخدمة </label>
                            <input type="number" class="form-control form-control-solid" name="time" min="0">
                            @error('time')
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
