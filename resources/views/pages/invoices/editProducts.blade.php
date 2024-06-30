@extends('layouts.app')
@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card gutter-b">
                <div class="card-header flex-wrap border-0 pt-2 pb-0">
                    <h3 class="card-label alert alert-success text-center none-print"> تعديل الفاتورة </h3>
                    <div class="card-title none-print">
                        @if(Auth::guard('admin')->check())
                        <a href="{{route('invoices.index')}}" class="btn btn-primary none-print">الفواتير</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!--begin::Search Form-->
                    <div class="mb-12">
                        <div class="table-responsive show-invoice">
                            <table id="" class="table table-striped text-center" cellspacing="0" width="100%" border="1px">
                                <thead>
                                    <tr>
                                        <th colspan="2">رقم الفاتورة: {{ $invoice->invoice_number }}</th>
                                        <th colspan="3">كود المزاد: {{ $invoice->auction->code }}</th>
                                    </tr>
                                    <tr>
                                        <td>تسلسل</td>
                                        <td>الصنف</td>
                                        <td>السعر / الوحدة</td>
                                        <td>العدد</td>
                                        <td>الأجمالي</td>
                                    </tr>
                                    <form action="{{ route('update.products.invoices' , $invoice->id) }}" method="POST">
                                        @csrf
                                        @foreach($invoice->auctionProducts as $product)
                                            <tr class="parent_row">
                                                <td> {{$loop->iteration}} </td>
                                                <td> <input type="text" name="row[{{ $product->id }}][product]" value="{{ $product->product != null ? $product->product->name  : ''}}" required /> </td>
                                                <input type="hidden" name="row[{{ $product->id }}][product_id]" value="{{ $product->product != null ? $product->product->id  : ''}}" required />
                                                <td> <input class="price" type="text" name="row[{{ $product->id }}][price]" value="{{ $product->price }}" required /> </td>
                                                <td> <input class="sum_qty_product" type="text" name="row[{{ $product->id }}][count_pieces]" value="{{ $product->count_pieces  }}" required /> </td>
                                                <td class="sum_product"> {{ $product->price * $product->count_pieces }} </td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td colspan="3"> الاجمالى </td>
                                                <td class="sum_qty"> </td>
                                                <td class="sum_total"> </td>
                                            </tr>
                                </thead>
                            </table> 
                        </div>
                            <button class="btn btn-success text-center mx-auto" style="font-size:20px;color:#fff"> تعديل </button>
                        </form>
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>
        <!--end::Content-->

        <script>
            $(function(){
                changeQty();
                changeTotalPrice();
            });

            $('.price').keyup(function(){
                priceRow       = $(this).parent().parent().find('.price').val();
                qtyRow         = $(this).parent().parent().find('.sum_qty_product').val();
                totalPriceRow  = $(this).parent().parent().find('.sum_product').text( priceRow * qtyRow);
                changeQty();
                changeTotalPrice();
            });

            $('.sum_qty_product').keyup(function(){
                priceRow       = $(this).parent().parent().find('.price').val();
                qtyRow         = $(this).parent().parent().find('.sum_qty_product').val();
                totalPriceRow  = $(this).parent().parent().find('.sum_product').text( priceRow * qtyRow);
                changeQty();
                changeTotalPrice();
            });

            $('.sum_product').change(function(){
                changeTotalPrice();
            });

            function changeQty(){
                var qty = 0;
                $('.sum_qty_product').each(function(){
                    qty += parseInt($(this).val());
                });
                $('.sum_qty').text(parseInt(qty));
            }

            function changeTotalPrice(){
                var sum_product = 0;
                $('.sum_product').each(function(){
                    sum_product += parseFloat($(this).text());
                });
                $('.sum_total').text(parseFloat(sum_product));
            }
        </script>

        @endsection
