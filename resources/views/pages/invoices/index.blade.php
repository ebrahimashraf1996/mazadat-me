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
                    <h3 class="card-label alert alert-success text-center"> الفواتير </h3>
                    <div class="card-title">
                        <form action="#" method="get">
                            <div class="row">

                                <div class="col-lg-2">
                                    <label style="font-weight: bolder">من</label>
                                    <input type="date" name="date_from" value="{{ request()->date_from }}" class="form-control date_from">
                                </div>

                                <div class="col-lg-2">
                                    <label style="font-weight: bolder">الي</label>
                                    <input type="date" name="date_to" value="{{ request()->date_to }}" class="form-control date_to">
                                </div>

                                <div class="col-lg-2">
                                    <label style="font-weight: bolder">العميل</label>
                                    <select class="form-control client" name="client">
                                        <option value="" disabled selected>---</option>
                                        @foreach ($clients as $key => $client)
                                            @if( $client != null)
                                                <option value="{{ $key }}" {{ $key == request()->client ? 'selected' : '' }}>{{ $client}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <label style="font-weight: bolder">كود المزاد</label>
                                    <input type="text" name="code_auction" value="{{ request()->code_auction }}" class="form-control code_auction">
                                </div>

                                <div class="col-lg-2">
                                    <label style="font-weight: bolder">رقم الفاتورة</label>
                                    <input type="number" name="invoice_number" value="{{ request()->invoice_number }}" class="form-control invoice_number">
                                </div>

                                <div class="col-lg-1">
                                    <button type="submit" class="btn btn-success" style="transform: translateY(30px)">فلتر <i class="fas fa-filter"></i></button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body ajax-report-invoices">
                    <!--begin: Search Form-->
                    <!--begin::Search Form-->
                    <div class="mb-12">
                        @if(request()->invoice_number || request()->date_from || request()->date_to || request()->code_auction)
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
                            <table class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>رقم الفاتورة</th>
                                        <th>اسم العميل</th>
                                        <th>تاريخ الطلب</th>
                                        {{-- <th>رسوم التوصيل</th> --}}
                                        <th>تاريخ التوصيل</th>
                                        <th>أجمالي الفاتورة</th>
                                        <th>حالة البيانات</th>
                                        <th>حالة الفاتورة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoices as $invoice)
                                        <tr>
                                            <td>{{$invoice->invoice_number?:'لم يحدد'}}</td>
                                            <td>{{@$invoice->client_name}}</td>
                                            <td>{{$invoice->auction_date?:''}}</td>
                                            {{-- <td>{{ $invoice->delivery_price !== null ?  $invoice->delivery_price : $setting->amount_invoice  }}</td> --}}
                                            <td>{{$invoice->delivery_date?:'لم يحدد'}}</td>
                                            <td>  {{(float)totalPriceProduct($invoice->auctionProducts) + (float)($invoice->delivery_price !== null ?  $invoice->delivery_price : $setting->amount_invoice)}}  </td>
                                            <td>
                                                @if(customCheckClient($invoice->client_name , $invoice->client_phone) == "مكتمل")
                                                    <span class="alert alert-success">{{ customCheckClient($invoice->client_name , $invoice->client_phone) }}</span>
                                                @else
                                                    <span class="alert alert-danger">{{ customCheckClient($invoice->client_name , $invoice->client_phone) }}</span>
                                                @endif
                                            </td>
                                            @if($invoice->client != null)
                                                <td style="display: none;">{{ $invoice->getFirstAreaOfInvoice($invoice->client->area_id , $invoice->id)}}</td>
                                            @endif
                                            <td> {{ getInvoiceStatus($invoice->status_invoice) }} </td>
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
