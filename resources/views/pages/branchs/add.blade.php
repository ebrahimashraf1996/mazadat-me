@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
      <a href="{{route('branchs.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px"> الفروع</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">أضافة فرع</h3>
            </div>
            <form class="form" action="{{route('branchs.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>اسم الفرع</label>
                            <input type="text" class="form-control form-control-solid" name="name">
                            @error('name')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>أختيار مدير الفرع</label>
                            <select class="form-control" name="branch_manger">
                                @foreach($users as $user)
                                <option value="{{$user->id}}"> {{$user->name}} </option>
                                @endforeach
                            </select>
                            @error('branch_manger')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>ساعات العمل من</label>
                            <input type="number" class="form-control form-control-solid" name="work_hours_from" min="0">
                            @error('work_hours_from')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>ساعات العمل الي</label>
                            <input type="number" class="form-control form-control-solid" name="work_hours_to" min="0">
                            @error('work_hours_to')
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

                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>رابط الخريطة</label>
                            <input type="text"  name="map" class="form-control">
                            @error('map')
                              <span class="text-danger">{{$message}} </span>
                            @enderror
                          </div>
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
