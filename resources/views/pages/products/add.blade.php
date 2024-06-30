@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <a href="{{route('products.index')}}" class="btn btn-success" style="border-radius:0;font-size:20px"> المنتجات</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">

            <div class="card-header">
                <h3 class="card-title">أضافة منتج</h3>
            </div>

            <form class="form" action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label>أسم المنتج</label>
                            <input type="text" class="form-control form-control-solid" name="name" required>
                            @error('name')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>سعر القطعة</label>
                            <input type="number" min="0" class="form-control form-control-solid" name="price" required>
                            @error('price')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>الالوان</label>
                            <select name="colors" id="color_id" class="form-control">
                                <option value="" disabled selected> اختر الالوان لهذا المنتح</option>
                                <option value="0"> بدون لون</option>
                                @foreach ($colors as $key => $color)
                                <option value="{{ $key }}">{{ $color }}</option>
                                @endforeach
                            </select>
                            <div class="container-color"></div>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>الكمية</label>
                            <input type="number" min="0" id="quantity" class="form-control form-control-solid" name="qty" disabled required>
                            @error('qty')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label> التحذير</label>
                            <input type="number" min="0" class="form-control form-control-solid" name="warning_num">
                            @error('warning_num')
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
                            <textarea class="form-control form-control-solid ckeditor" name="notes" rows="6"> </textarea>
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

@section('js')
    @include('pages.products.scripts')
@endsection
