@extends('layouts.app')
@section('content')

<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="m-auto">
            <!--begin::Card-->

            <div class="card gutter-b">
                <div class="card-header flex-wrap border-0 pt-2 pb-0">
                    <h3 class="card-label alert alert-success text-center"> الفواتير </h3>

                    <form action="#" method="GET">
                        <div class="row">
                            <div class="col-lg-4">
                                <label style="font-weight: bolder">من</label>
                                <input type="date" class="form-control date_from" name="date_from" value="{{ request()->date_from }}">
                            </div>
                            <div class="col-lg-4">
                                <label style="font-weight: bolder">الي</label>
                                <input type="date" class="form-control date_to" name="date_to" value="{{ request()->date_to }}">
                            </div>
                            <div class="col-lg-4">
                                <label style="font-weight: bolder">الدورة</label>
                                <select class="form-control client" name="stage">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}" {{ $stage->id  ==  request()->stage ? 'selected' : '' }}>{{ $stage->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label style="font-weight: bolder">المندوب</label>
                                <select class="form-control client" name="delivery">
                                    <option value="" disabled selected>---</option>
                                    @foreach ($deliveries as $key => $delivery)
                                    @if( $delivery != null)
                                    <option value="{{ $key }}" {{ $key ==  request()->delivery ? 'selected' : '' }}>{{ $delivery }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 mt-2" >
                                <label style="font-weight: bolder">الرقم التسلسلي</label>
                                <input type="number" class="form-control serial_number" name="serial_number" value="{{ request()->serial_number }}">
                            </div>

                            <div class="col-lg-2 mt-2">
                                <label style="font-weight: bolder">رقم الفاتورة</label>
                                <input type="number" class="form-control invoice_number" name="invoice_number" value="{{ request()->invoice_number }}">
                                <input type="hidden" value="{{$auction_id}}" class="auction_id" name="auction_id">
                            </div>
                            <div class="col-lg-1">
                                <button type="submit" class="btn btn-success " style="transform: translateY(30px)">فلتر <i class="fas fa-filter"></i></button>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <select name="limit" class="select-pagination" style="margin-left: 25px;" onchange="this.form.submit()">
                                <option value="10" {{request()->limit ==  10 ? 'selected' : ''}}>10</option>
                                <option value="25" {{request()->limit ==  25 ? 'selected' : ''}}>25</option>
                                <option value="50" {{request()->limit ==  50 ? 'selected' : ''}}>50</option>
                                <option value="100" {{request()->limit ==  100 ? 'selected' : ''}}>100</option>
                                <option value="150" {{request()->limit ==  150 ? 'selected' : ''}}>150</option>
                            </select>
                        </div>
                    </form>

                </div>
                <div class="card-body ajax-report-invoices mt-4">
                    <!--begin: Search Form-->
                    <!--begin::Search Form-->
                    <div class="mb-12">
                        @if(request()->invoice_number || request()->date_from || request()->date_to )
                            @if(count($invoices) != 0)
                                <form action="{{ route('print.invoices') }}" class="btn btn-success print-invoice">
                                    @csrf
                                    @foreach($invoices as $invoice)
                                        <input type="hidden" name="invoices_id[]" value="{{ $invoice->id }}">
                                    @endforeach
                                    <button type="submit" class="btn btn-success">طباعة الفواتير</button>
                                </form>
                            @endif
                        @endif
                        <div class="table-responsive">

                            <form action="{{ route('delete.all.invoices') }}" method="POST" class="text-left d-inline-block">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="selected" id="selected-input">
                                <button class="btn btn-danger btn-sm" style="display: none" id="delete-rows">
                                    <i class="fas fa-trash-alt"></i> مسح الكل </button>
                            </form>

                            <table class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" style="width:18px;height:18px;" class="check-all" /></th>
                                        <th>الرقم التسلسلي</th>
                                        <th> رقم الفاتورة</th>
{{--                                        <th> رقم الدورة</th>--}}
                                        <th>اسم العميل</th>
                                        @if(Auth::guard('admin')->check())
                                            <th>كود المزاد</th>
                                        @endif
{{--                                        <th>تاريخ الطلب</th>--}}
                                        <th>تاريخ المزاد</th>
                                        <th>رسوم التوصيل</th>
                                        <th>تاريخ التوصيل</th>
                                        <th>أجمالي الفاتورة</th>
                                        <th>حالة البيانات</th>
                                        <th>حالة الفاتوره</th>
                                        <th>الأعدادات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoices as $invoice)
                                    <tr>
                                        <td><input type="checkbox" style="width:18px;height:18px;" class="check" value="{{ $invoice->id }}"></td>
                                        <td>{{$invoice->serial_number?:'لم يحدد'}}</td>
                                        <td>{{$invoice->invoice_number? $invoice->invoice_number :'لم يحدد'}}</td>
{{--                                        <td>{{$invoice->auction_stage_id}}</td>--}}
                                        <td>{{@$invoice->client_name}}</td>
                                        @if(Auth::guard('admin')->check())
                                        <td>{{@$invoice->auction_code}}</td>
                                        @endif
{{--                                        <td>{{date('Y-m-d' ,strtotime($invoice->created_at))}}</td>--}}
                                        <td>{{$invoice->stage? $invoice->stage->getStartTime() :''}}</td>
{{--@dd($invoice->delivery_price == null && !is_int($invoice->delivery_price))--}}
                                        <td>{{ $invoice->delivery_price == null && !is_int($invoice->delivery_price)  ?  $setting_->amount_invoice : $invoice->delivery_price  }}</td>
{{--                                        <td>{{ $invoice->delivery_price != null ?  $invoice->delivery_price : "لم يحدد"  }}</td>--}}
                                        <td>{{$invoice->delivery_date?:'لم يحدد'}}</td>
                                        <td>{{ (float)totalPriceProduct($invoice->auctionProducts->where('is_return', 0)) + (float)($invoice->delivery_price !== null ?  $invoice->delivery_price : 0)}} </td>
                                        <td>
                                            @if(customCheckClient($invoice->client_name , $invoice->client_phone) == "مكتمل")
                                            <span class="alert alert-success">{{ customCheckClient($invoice->client_name , $invoice->client_phone)  }}</span>
                                            @else
                                            <span class="alert alert-danger">{{ customCheckClient($invoice->client_name , $invoice->client_phone)  }}</span>
                                            @endif
                                        </td>
                                        <td> {{ getInvoiceStatus($invoice->status_invoice) }} </td>
                                        @if($invoice->client != null)
                                        <td style="display: none;">{{ $invoice->getFirstAreaOfInvoice($invoice->client->area_id , $invoice->id)}}</td>
                                        @endif
                                        <td>
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">الاعدادات <i class="fas fa-caret-down"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
{{--                                                <a class="btn btn-info" href="{{route('edit.products.invoices', ['invoice_id' => $invoice->id, 'client_id' => $invoice->client_id])}}"><i class="fa fa-edit"></i> تعديل الفاتورة</a>--}}
                                                <a class="btn btn-primary" href="{{route('detailes.invoices', ['invoice_id' => $invoice->id, 'client_id' => $invoice->client_id])}}"><i class="fa fa-eye"></i> تفاصيل الفاتورة</a>
                                                {{-- <a class="btn btn-success" href="{{route('invoices.edit', $invoice->id)}}"><i class="fa fa-edit"></i> تعديل</a> --}}
{{--                                                <a class="btn btn-danger" data-toggle="modal" href="#myModal-{{$invoice->id}}"><i class="fa fa-trash"></i> حذف</a>--}}
                                            </div>
{{--                                            <div class="modal fade" id="myModal-{{$invoice->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
{{--                                                <div class="modal-dialog">--}}
{{--                                                    <div class="modal-content">--}}
{{--                                                        <div class="modal-header">--}}
{{--                                                            <h5 class="modal-title" id="exampleModalLabel">حذف</h5>--}}
{{--                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                                            </button>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="modal-body">--}}
{{--                                                            <form role="form" class="form_delete" action="{{route('invoices.destroy', $invoice->id)}}" method="POST">--}}
{{--                                                                <input name="_method" type="hidden" value="DELETE">--}}
{{--                                                                {{ csrf_field() }}--}}
{{--                                                                <p>هل انت متأكد ؟</p>--}}
{{--                                                                <button type="submit" class="btn btn-danger" name='delete_modal'><i class="fa fa-trash" aria-hidden="true"></i> حذف</button>--}}
{{--                                                            </form>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end::Card-->
                <div class="d-flex justify-content-center">{{ $invoices->appends(request()->query())->links() }}</div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
    @endsection

    @section('js')
        <script>
            $('.check-all').change(function() {
                if ($(this).is(":checked")) {
                    $('#delete-rows').css('display', 'block');
                    $('.check').prop('checked', true);
                    addselectedIdsToInput();
                } else {
                    $('#delete-rows').css('display', 'none');
                    $('.check').prop('checked', false);
                }
            });

            $('.check').change(function() {
                if ($('.check:checked').length >= 1) {
                    addselectedIdsToInput();
                    $('#delete-rows').css('display', 'block');
                } else {
                    $('#delete-rows').css('display', 'none');
                }
            });

            function addselectedIdsToInput() {
                var selected = [];
                $('.check:checked').each(function() {
                    selected.push($(this).val());
                });
                $('#selected-input').val(JSON.stringify(selected));
            }
        </script>
    @endsection
