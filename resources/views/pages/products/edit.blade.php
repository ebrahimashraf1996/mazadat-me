@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
          <a href="{{route('products.index')}}"class="btn btn-success" style="border-radius:0;font-size:20px"> المنتجات</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">تعديل المنتج</h3>
            </div>
            <form class="form" action="{{route('products.update', $product->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                    <div class="row">
                      <div class="form-group col-lg-6">
                          <label>أسم المنتج</label>
                          <input type="text" class="form-control form-control-solid" name="name" value="{{$product->name}}" required>
                          @error('name')
                            <span class="text-danger">{{$message}} </span>
                          @enderror
                      </div>

                      <div class="form-group col-lg-6">
                          <label>الكمية</label>
                          <input type="number" min="0" class="form-control form-control-solid" name="qty" value="{{$product->qty}}" required>
                          @error('qty')
                            <span class="text-danger">{{$message}} </span>
                          @enderror
                      </div>

                      <div class="form-group col-lg-6">
                          <label>سعر القطعة</label>
                          <input type="number" min="0" class="form-control form-control-solid" name="price" value="{{$product->price}}" required>
                          @error('price')
                            <span class="text-danger">{{$message}} </span>
                          @enderror
                      </div>

                        <div class="form-group col-lg-6">
                            <label>صورة المنتج</label>
                            <input type="file" class="form-control form-control-solid" name="image">
                            @error('image')
                                <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-12">
                            <label>ملاحظات علي المنتج</label>
                            <textarea class="form-control form-control-solid ckeditor" name="notes" rows="6"> 
                                {!! $product->notes !!}
                            </textarea>
                            @error('image')
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
