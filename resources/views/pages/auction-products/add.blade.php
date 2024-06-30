@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
          <a href="{{route('auction-products.index', ['auction_id' => $auction_id])}}"class="btn btn-success" style="border-radius:0;font-size:20px"> المنتجات</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">أضافة منتج</h3>
            </div>
            <form class="form" action="{{route('auction-products.store', ['auction_id' => $auction_id])}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                  
                    <div class="form-group col-lg-6">
                          <label>اسم العميل</label>
                          <select class="form-control form-control-solid" name="client_id" required>
                                @foreach($clients as $client)
                                    <option value="{{$client->id}}"> {{$client->username}} </option>
                                @endforeach
                          </select>
                          @error('client_id')
                            <span class="text-danger">{{$message}} </span>
                          @enderror
                    </div>

                    <div class="form-group col-lg-6">
                          <label>أسم المنتج</label>
                          <select class="form-control form-control-solid" name="product_id" required>
                                @foreach($proudcts as $product)
                                    <option value="{{$product->id}}"> {{$product->name}} </option>
                                @endforeach
                          </select>
                          @error('product_id')
                            <span class="text-danger">{{$message}} </span>
                          @enderror
                    </div>

                    <div class="form-group col-lg-6">
                          <label>نوع الشراء</label>
                          <select class="form-control form-control-solid" name="purchase_type" required>
                            <option value="قطعة"> قطعة</option>
                            <option value="مجموعة"> مجموعة </option>
                          </select>
                          @error('purchase_type')
                            <span class="text-danger">{{$message}} </span>
                          @enderror
                    </div>

                      <div class="form-group col-lg-6">
                          <label>عدد القطع</label>
                          <input type="number" min="0" class="form-control form-control-solid" name="count_pieces"  value="{{ old('count_pieces') }}" required>
                          @error('count_pieces')
                            <span class="text-danger">{{$message}} </span>
                          @enderror
                      </div>

                      <div class="form-group col-lg-6">
                          <label>سعر القطعة</label>
                          <input type="number" min="0" class="form-control form-control-solid" name="price" value="{{ old('price') }}" required>
                          @error('price')
                            <span class="text-danger">{{$message}} </span>
                          @enderror
                      </div>
                      
                      <div class="form-group col-lg-6">
                          <label>الكود</label>
                          <input type="text" class="form-control form-control-solid" name="code" value="{{ old('code') }}" required>
                          @error('code')
                            <span class="text-danger">{{$message}} </span>
                          @enderror
                      </div>

                        <div class="form-group col-lg-12">
                            <label>ملاحظات علي المزاد</label>
                            <textarea class="form-control form-control-solid ckeditor" name="notes" rows="6"> </textarea>
                            @error('notes')
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
