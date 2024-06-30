@extends('layouts.app')
@section('content')
<div class="row" style="padding: 0 20px">
    <div class="col-lg-12">
        <a href="{{route('auction-products.index', ['auctionStage' => $auctionStage->id])}}" class="btn btn-success" style="border-radius:0;font-size:20px"> منتجات المزاد</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">تعديل المنتج</h3>
            </div>
            <form class="form" action="{{route('auction-products.update', ['auctionStage' => $auctionStage->id, $auction_product->id])}}" method="POST" enctype="multipart/form-data">
                @csrf
                {{method_field('PUT')}}
                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-lg-4">
                            <label>اسم العميل</label>
                            <select class="form-control" name="client_id" id="select_two_client" required>
                                @foreach($clients as $client)
                                <option value="{{$client->id}}" @if($client->id == $auction_product->client_id) selected @endif> {{$client->username}} </option>
                                @endforeach
                            </select>
                            @error('client_id')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-4">
                            <label>أسم المنتج</label>
                            <select class="form-control form-control-solid" name="product_id" required>
                                @foreach($proudcts as $product)
                                <option value="{{$product->id}}" @if($product->id == $auction_product->product_id) selected @endif> {{$product->name}} </option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-4">
                            <label> تعديل اسم المنتج </label>
                            <input type="text" min="0" class="form-control form-control-solid" name="product_name" value="{{@$auction_product->product->name}}">
                            @error('product_name')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>نوع الشراء</label>
                            <select class="form-control form-control-solid" name="purchase_type" required>
                                <option @if( $auction_product->purchase_type == 'قطعة') selected @endif value="قطعة"> قطعة</option>
                                <option @if($auction_product->purchase_type == 'مجموعة') selected @endif value="مجموعة"> مجموعة </option>
                            </select>
                            @error('purchase_type')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>عدد القطع</label>
                            <input type="number" min="0" class="form-control form-control-solid" name="count_pieces" value="{{$auction_product->count_pieces}}">
                            @error('count_pieces')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>سعر القطعة</label>
                            <input type="float" min="0" class="form-control form-control-solid" name="price" value="{{$auction_product->price}}">
                            @error('price')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>الكود</label>
                            <input type="text" class="form-control form-control-solid" name="code" value="{{$auction_product->code}}">
                            @error('code')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>


                        <div class="form-group col-lg-12">
                            <label>ملاحظات علي المزاد</label>
                            <textarea class="form-control form-control-solid ckeditor" name="notes" rows="6">
                                    {!! $auction_product->notes !!}
                            </textarea>
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

@push('css')
<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet" />
<script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush

@section('js')
    <script>
        $('#select_two_client').select2();
    </script>
@endsection
