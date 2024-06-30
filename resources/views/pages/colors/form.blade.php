@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
          <a href="{{route('colors.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px"> الالوان</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">أضافة لون</h3>
            </div>
            <form class="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($method == 'PUT')
                    @method('PUT')
                @endif
                
                <div class="card-body">
                    <div class="row">

                    <div class="form-group col-lg-6">
                        <label>أسم اللون</label>
                        <input type="text" class="form-control form-control-solid" name="name" value="{{ $color->name }}" required>
                        @error('name')
                        <span class="text-danger">{{$message}} </span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-6">
                        <label>الكمية</label>
                        <input type="color"  class="form-control form-control-solid" name="code" value="{{ $color->code }}" required>
                        @error('code')
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
