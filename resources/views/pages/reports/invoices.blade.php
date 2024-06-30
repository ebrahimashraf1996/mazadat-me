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
                  <div class="row">
                      <div class="col-lg-3">
                          <label style="font-weight: bolder">من</label>
                          <input type="date" class="form-control date_from"> 
                      </div>

                      <div class="col-lg-3">
                        <label style="font-weight: bolder">الي</label>
                        <input type="date" class="form-control date_to"> 
                      </div>

                      <div class="col-lg-2">
                        <label style="font-weight: bolder">كود المزاد</label>
                        <input type="text" class="form-control code_auction">
                      </div>

                      <div class="col-lg-2">
                        <label style="font-weight: bolder">رقم الفاتورة</label>
                        <input type="number" class="form-control invoice_number">
                      </div>

                      <div class="col-lg-1">
                          <button type="button" class="btn btn-success filter-invoice" data-url="{{ route('report.ajax.invoices') }}" style="transform: translateY(30px)">فلتر <i class="fas fa-filter"></i></button>
                      </div>
                  </div>
                </div>
              </div>
                <div class="card-body ajax-report-invoices">
                    <!--begin: Search Form-->
                    <!--begin::Search Form-->
                    <div class="mb-12">
                        <div class="table-responsive">
                          <table id="example" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>رقم الفاتورة</th>
                              <th>اسم العميل</th>
                              <th>تاريخ الطلب</th>
                              <th>رسوم التوصيل</th>
                              <th>تاريخ التوصيل</th>
                              <th>أجمالي الفاتورة</th>
                              <th>حالة الفاتورة</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                              <td>{{$invoice->invoice_number?:'لم يحدد'}}</td>
                              <td>{{@$invoice->client['username']}}</td>
                              <td>{{$invoice->order_date?:''}}</td>
                              <td>{{$invoice->delivery_price?:$setting->amount_invoice}}</td>
                              <td>{{$invoice->delivery_date?:'لم يحدد'}}</td>
                              <td>{{(int)totalPriceProduct($invoice->client_id, $invoice->auction_id) + (int)($invoice->delivery_price?:$setting->amount_invoice)}} </td>
                              <td>
                                @if(checkClient($invoice->client_id) == "مكتمل")
                                    <span class="alert alert-success">{{ checkClient($invoice->client_id) }}</span>
                                @else
                                    <span class="alert alert-danger">{{ checkClient($invoice->client_id) }}</span>
                                @endif
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->
@endsection
