@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
          <a href="{{route('categories.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px"> الأقسام</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">تعديل القسم</h3>
            </div>
            <form class="form" action="{{route('categories.update', $category->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                    <div class="row">
                      <div class="form-group col-lg-6">
                          <label>اسم القسم</label>
                          <input type="text" class="form-control form-control-solid" name="name" value="{{$category->name}}">
                          @error('name')
                            <span class="text-danger">{{$message}} </span>
                          @enderror
                      </div>

                        <div class="form-group col-lg-6">
                            <label>الرمز</label>
                            <input type="file" class="form-control form-control-solid" name="icon">
                            @error('icon')
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
