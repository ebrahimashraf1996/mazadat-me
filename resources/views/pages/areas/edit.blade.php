@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
      <a href="{{route('areas.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px">المناطق</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">تعديل المنطقة</h3>
            </div>
            <form class="form" action="{{route('areas.update', $area->id)}}" method="POST">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>اسم المنطقة</label>
                            <input type="text" class="form-control form-control-solid" name="name" value="{{$area->name}}">
                            @error('name')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>اسم المدينة</label>
                            <select class="form-control form-control-solid" name="city_id">
                            @foreach($cities as $city)
                                <option value="{{$city->id}}"
                                  @if($city->id == $area->city_id) selected @endif
                                >{{$city->name}} </option>
                            @endforeach
                            </select>
                            @error('city_id')
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
