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
                        <h3 class="card-label alert alert-success text-center none-print"> تفاصيل الفاتورة </h3>
                        <div class="card-title none-print">
                            @if(Auth::guard('admin')->check())
                                <a href="{{route('invoices.index')}}" class="btn btn-primary none-print">الفواتير</a>
                            @endif
                        </div>

                        <hr>

                        <h4 class="alert alert-success none-print">تعديل الفاتورة</h4>
                        <form class="form none-print" action="{{ route('invoices.update', $invoice->id) }}"
                              method="POST">
                            @csrf
                            {{method_field('PUT')}}
                            <div class="row">


                                <div class="col-lg-12">
                                    <div class="mb-12">
                                        <div class="table-responsive show-invoice">
                                            <table id="" class="table table-striped text-center" cellspacing="0"
                                                   width="100%" border="1px">
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
                                                @foreach($invoice->auctionProducts as $product)
                                                    <tr class="parent_row">
                                                        <td> {{$loop->iteration}} </td>
                                                        <td><input type="text"
                                                                   name="row[{{ $product->id }}][product]"
                                                                   value="{{ $product->product != null ? $product->product->name  : ''}}"
                                                                   required/></td>
                                                        <input type="hidden"
                                                               name="row[{{ $product->id }}][product_id]"
                                                               value="{{ $product->product != null ? $product->product->id  : ''}}"
                                                               required/>
                                                        <td><input class="price" type="text"
                                                                   name="row[{{ $product->id }}][price]"
                                                                   value="{{ $product->price }}" required/></td>
                                                        <td><input class="sum_qty_product" type="text"
                                                                   name="row[{{ $product->id }}][count_pieces]"
                                                                   value="{{ $product->count_pieces  }}" required/>
                                                        </td>
                                                        <td class="sum_product"> {{ $product->price * $product->count_pieces }} </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="3"> الاجمالى</td>
                                                    <td class="sum_qty"></td>
                                                    <td class="sum_total"></td>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                @if(Auth::guard('auction')->check())
                                    <div class="form-group col-lg-6">
                                        <label>المناديب</label>
                                        <select class="form-control" name="delivery_id">
                                            <option value="">أختر المندوب</option>
                                            <option value="">ألغاء أختيار المندوب المسجل</option>
                                            @foreach($deliveries as $delivry)
                                                <option value="{{ $delivry->id }}"
                                                        @if($delivry->id == $invoice->delivery_id) selected @endif> {{ $delivry->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('delivery_id')
                                        <span class="text-danger">{{$message}} </span>
                                        @enderror
                                    </div>
                                @endif

                                <div class="form-group col-lg-6">
                                    <label>تاريخ التوصيل</label>
                                    <input type="date" class="form-control" name="delivery_date"
                                           value="{{ $invoice->delivery_date }}">
                                    @error('delivery_date')
                                    <span class="text-danger">{{$message}} </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>سعر التوصيل</label>
                                    <input type="number" class="form-control" name="delivery_price" min="0"
                                           value="{{ $invoice->delivery_price }}">
                                    @error('delivery_price')
                                    <span class="text-danger">{{$message}} </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>طريقة الدفع</label>
                                    <input type="text" class="form-control" name="payment"
                                           value="{{ $invoice->payment }}">
                                    @error('payment')
                                    <span class="text-danger">{{$message}} </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-6">
                                    <label> الحالة </label>
                                    <select name="status_invoice" id="invoice_status" class="form-control">
                                        @foreach ($invoice->getStatus() as $key => $status)
                                            <option
                                                value="{{ $key }}" {{ $key == $invoice->status_invoice ? 'selected' : '' }} {{ old('status_invoice') ==  $key ? 'selected' : ''}}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-6" id="deffer-date">
                                    <label>تاريخ التاجيل</label>
                                    <input type="date" class="form-control" name="order_date"
                                           value="{{ $invoice->order_date}}">
                                    @error('order_date')
                                    <span class="text-danger">{{$message}} </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label style="font-weight: bolder">الدورة</label>
                                    <select class="form-control client" name="auction_stage_id">
                                        <option value="" disabled selected>---</option>
                                        @foreach ($stages as $stage)
                                            <option
                                                value="{{ $stage->id }}" {{ $stage->id  ==  $invoice->auction_stage_id ? 'selected' : '' }}>{{ $stage->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2">حفظ</button>
                                    </div>
                                </div>

                        </form>

                    </div>
                    <div class="card-body">

                        <!--begin::Search Form-->
                        <div class="mb-12">
                            <div class="table-responsive show-invoice">
                                <table id="" class="table table-striped text-center" cellspacing="0" width="100%"
                                       border="1px">
                                    <thead>
                                    <tr>
                                        <th colspan="2">رقم الفاتورة: {{ $invoice->invoice_number }}</th>
                                        <th colspan="3">كود المزاد: {{ $invoice->auction->code }}</th>
                                    </tr>
                                    <tr>
                                        <td> اسم العميل</td>
                                        <td>{{ @$invoice->client['username']}}</td>
                                        <td>رقم العميل</td>
                                        <td colspan="2">{{ @$invoice->client->phone1 }}</td>
                                    </tr>
                                    <tr>
                                        <td>اسم المندوب</td>
                                        @if(customCheckClient(@$invoice->client['username'] , @$invoice->client->phone1) == "مكتمل")
                                            <td>{{ $invoice->getFirstAreaOfInvoice($invoice->client->area_id , $invoice->id)}}</td>
                                        @else
                                            {{ "لم يعين مندوب" }}
                                        @endif
                                        <td>طريقة الدفع</td>
                                        <td colspan="2">{{ $invoice->payment}}</td>
                                    </tr>
                                    <tr>
                                        <td>اسم المزاد</td>
                                        <td>{{ @$invoice->stage->name }}</td>
                                        <td>تاريخ المزاد</td>
                                        <td colspan="2">{{$invoice->stage? $invoice->stage->getStartTime() :''}}</td>
                                    </tr>
                                    @if($invoice->client->address != null)
                                        <tr>
                                            <td>العنوان</td>
                                            <td colspan="4"
                                                style="text-align:right;padding-right: 15px">{{ @$invoice->client->address }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>مدينة</td>
                                        <td>قطعة</td>
                                        <td>شارع</td>
                                        <td>جاده</td>
                                        <td>رقم المنزل</td>
                                    </tr>
                                    <tr>
                                        <td> {{ @$invoice->client->area->name }}</td>
                                        <td> {{ @$invoice->client->piece }} </td>
                                        <td> {{ @$invoice->client->street }} </td>
                                        <td> {{ @$invoice->client->avenue }} </td>
                                        <td> {{ @$invoice->client->house_number }} </td>
                                    </tr>
                                    <tr>
                                        <td>تسلسل</td>
                                        <td>الصنف</td>
                                        <td>السعر / الوحدة</td>
                                        <td>العدد</td>
                                        <td>الأجمالي</td>
                                    </tr>
                                    @foreach($invoice->auctionProducts as $product)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            <td> {{ $product->product != null ? $product->product->name  : ''}} </td>
                                            <td> {{ $product->price }} </td>
                                            <td> {{ $product->count_pieces  }} </td>
                                            <td class="sum_product"> {{ $product->price * $product->count_pieces }} </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2"> رسو التوصيل</td>
                                        <td colspan="3" class="delivery_price">
                                            {{--                                            @if($invoice->delivery_price == '')--}}
                                            {{--                                                {{ amountInvoice() }}--}}
                                            {{--                                                لم يحدد--}}
                                            {{--                                            @else--}}
                                            {{--                                                {{ $invoice->delivery_price >= 0 ? $invoice->delivery_price : $setting->amount_invoice}}--}}
                                            {{--                                                {{ $invoice->delivery_price >= 0 ? $invoice->delivery_price : "لم يحدد"}}--}}
                                            {{--                                            @endif--}}

                                            @if(auth('auction')->check())
                                                @php($setting_ = App\Models\Setting::where('auction_id' , auth('auction')->user()->id)->first())
                                                {{ $invoice->delivery_price == null && !is_int($invoice->delivery_price)  ?  $setting_->amount_invoice : $invoice->delivery_price  }}
                                            @else
                                                {{ $invoice->delivery_price >= 0 ? $invoice->delivery_price : $setting->amount_invoice}}
                                            @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> تاريخ التوصيل</td>
                                        <td colspan="3"> {{ $invoice->delivery_date }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> الأجمالي</td>
                                        <td colspan="3" class="sum_total"></td>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            @if(checkClient($invoice->client) == 'مكتمل')
                                <h2 class="none-print"><a class="btn btn-success none-print" onclick="window.print();"
                                                          style="font-size:20px;color:#fff">طباعة الفاتورة</a></h2>
                            @endif

                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>
        <!--end::Content-->

        <script>
            $(function () {

                var sum_product = 0;
                $('.sum_product').each(function () {
                    sum_product += parseFloat($(this).text());
                });

                var sum_delivery_price = $('.delivery_price').text();
                console.log(typeof sum_delivery_price)
                if (typeof sum_delivery_price == 'string') {
                    $('.sum_total').text(parseFloat(sum_product));
                } else {
                    $('.sum_total').text(parseFloat(sum_product) + parseInt(sum_delivery_price));

                }
            });

        </script>

        <script>
            $('#invoice_status').on('change', function () {
                if (this.value == 'delared') {
                    console.log('delared')
                    $('#deffer-date').css('display', 'block');
                } else {
                    $('#deffer-date').css('display', 'none');
                }
            });
            $(window).on('load', function () {
                if ($('#invoice_status').val() == 'delared') {
                    $('#deffer-date').css('display', 'block');
                }
            });

        </script>

@endsection
