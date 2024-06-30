@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
      <a href="{{route('branchs.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px"> الفروع</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">

            <div class="card-header">
                <h3 class="card-title">تعديل الفرع</h3>
            </div>
            <form class="form" action="{{route('branchs.update', $branch->id)}}" method="POST">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>اسم الفرع</label>
                            <input type="text" class="form-control form-control-solid" name="name" value="{{$branch->name}}">
                            @error('name')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>أختيار مدير الفرع</label>
                            <select class="form-control" name="branch_manger">
                                @foreach($users as $user)
                                <option value="{{$user->id}}" @if($branch->branch_manger == $user->id) selected @endif> {{$user->name}} </option>
                                @endforeach
                            </select>
                            @error('branch_manger')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>ساعات العمل من</label>
                            <input type="number" class="form-control form-control-solid" name="work_hours_from" value="{{$branch->work_hours_from}}">
                            @error('work_hours_from')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>ساعات العمل الي</label>
                            <input type="number" class="form-control form-control-solid" name="work_hours_to" value="{{$branch->work_hours_to}}">
                            @error('work_hours_to')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>العنوان</label>
                            <input type="text" id="address" name="address" class="form-control map-input">
                            @error('address')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <!-- Start Show Map -->
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>رابط الخريطة</label>
                            <input type="text" value="{{$branch->map}}" name="map" class="form-control">
                            @error('map')
                              <span class="text-danger">{{$message}} </span>
                            @enderror
                          </div>
                        </div>
                        <!-- End Show Map -->
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
