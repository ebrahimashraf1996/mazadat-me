@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
      <a href="{{route('cities.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px">المدن</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">تعديل المدينة</h3>
            </div>
            <form class="form" action="{{route('cities.update', $city->id)}}" method="POST">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>اسم المدينة</label>
                            <input type="text" class="form-control form-control-solid" name="name" value="{{$city->name}}">
                            @error('name')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>اسم البلد</label>
                            <select class="form-control form-control-solid" name="country_id">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}"
                                  @if($country->id == $city->country_id) selected @endif
                                >{{$country->name}} </option>
                            @endforeach
                            </select>
                            @error('country_id')
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
