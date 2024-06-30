@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
      <a href="{{route('items.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px"> المنتجات</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">تعديل هذا المنتج</h3>
            </div>
            <form class="form" action="{{route('items.update', $item->id)}}" method="POST">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>أسم المنتج</label>
                            <input type="text" class="form-control form-control-solid" name="name" value="{{$item->name}}">
                            @error('name')
                							<span class="text-danger">{{$message}} </span>
                						@enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>السعر</label>
                            <input type="number" class="form-control form-control-solid" name="avg_price" min="0" value="{{$item->avg_price}}">
                            @error('avg_price')
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
