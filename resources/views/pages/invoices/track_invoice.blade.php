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
                    <h3 class="card-label alert alert-success text-center"> متابعة المناديب </h3>
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

                                {{-- <div class="col-lg-2">
                                    <label style="font-weight: bolder">العميل</label>
                                    <select class="form-control client" name="client">
                                        <option value="" disabled selected>---</option>
                                        @foreach ($clients as $key => $client)
                                            @if( $client != null)
                                                <option value="{{ $key }}" {{ $key ==  request()->client ? 'selected' : '' }}>{{ $client}}</option>
                                @endif
                                @endforeach
                                </select>
                            </div> --}}

                            <div class="col-lg-2">
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

                            <div class="col-lg-2">
                                <label style="font-weight: bolder">الحالة</label>
                                <select class="form-control client" name="status">
                                    <option value="" disabled selected>---</option>
                                    @foreach (getAllStatus() as $key => $status)
                                    <option value="{{ $key }}" {{ $key ==  request()->status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-1">
                                <button type="submit" class="btn btn-success" style="transform: translateY(30px)">فلتر <i class="fas fa-filter"></i></button>
                            </div>

                    </div>
                            <div class="row justify-content-end">
                                <div class="col-lg-1" style="margin-left: 17px;">
                                    <select name="limit" class="select-pagination" style="margin-left: 0px;" onchange="this.form.submit()">
                                        <option value="10" {{request()->limit ==  10 ? 'selected' : ''}}>10</option>
                                        <option value="25" {{request()->limit ==  25 ? 'selected' : ''}}>25</option>
                                        <option value="50" {{request()->limit ==  50 ? 'selected' : ''}}>50</option>
                                        <option value="100" {{request()->limit ==  100 ? 'selected' : ''}}>100</option>
                                        <option value="150" {{request()->limit ==  150 ? 'selected' : ''}}>150</option>
                                    </select>
                                </div>
                            </div>
                    </form>
                </div>
            </div>

            <div class="card-body ajax-report-invoices">
                <!--begin: Search Form-->
                <!--begin::Search Form-->
                <div class="mb-12">

                    {{-- <form action="{{ route('print.invoices') }}" class="btn btn-success print-invoice">
                    @csrf
                    @foreach($print_data as $invoice)
                    <input type="hidden" name="invoices_id[]" value="{{ $invoice->id }}">
                    @endforeach
                    <button type="submit" class="btn btn-success">طباعة الفواتير</button>
                    </form> --}}
                    @if(count($invoices) != 0)
                    <button type="button" onclick="printPage()" class="btn btn-success">طباعة الكشف</button>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>رقم الفاتورة</th>
                                    <th>اسم المندوب</th>
                                    <th>اسم العميل</th>
                                    <th>رقم العميل</th>
                                    <th> المنطقة</th>
                                    <th>تاريخ الفاتورة</th>
                                    <th>أجمالي الفاتورة</th>
                                    <th>حالة الفاتورة</th>
                                    <th>تغير حالة الفاتورة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{$invoice->invoice_number?:'لم يحدد'}}</td>
                                    <td>{{$invoice->delivery_name}}</td>
                                    <td>{{$invoice->client_name}}</td>
                                    <td>{{$invoice->client_phone}}</td>
                                    <td>{{$invoice->client->area->name?? ''}}</td>
                                    <td>{{$invoice->auction_date?:''}}</td>
                                    <td>
                                        {{(float)totalPriceProduct($invoice->auctionProducts) + (float)($invoice->delivery_price !== null ?  $invoice->delivery_price : $setting->amount_invoice)}}
                                    </td>
                                    @if($invoice->client != null)
                                        <td style="display: none;">{{ $invoice->getFirstAreaOfInvoice($invoice->client->area_id , $invoice->id)}}</td>
                                    @endif
                                    <td> {{ getInvoiceStatus($invoice->status_invoice) }} </td>
                                    <td>
                                        <select id="status_select_{{ $invoice->id }}" onchange="getStatus('{{  $invoice->id  }}')" style="padding: 8px; color: white; background: dodgerblue; border-radius: 5px; outline: none;">
                                            @foreach (getAllStatus() as $key => $status)
                                            <option value="{{ $key }}" data-id="{{ $invoice->id }}" data-date="{{ $invoice->order_date }}" data-url="{{ route('invoices.update' , $invoice->id) }}" {{ $key == $invoice->status_invoice ? 'selected' : ''; }}>{{ $status }}</option>
                                            @endforeach
                                        </select>
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

<div class="modal fade" id="status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافة تاريخ التاجيل</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="update-status-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="id_invoice">
                    <input type="date" name="order_date" class="form-control" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="status_invoice" id="status_invoice">
            </div>
            <div class="model-footer m-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-edit" aria-hidden="true"></i> تاجيل</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">غلق</button>
            </div>
               </form>
        </div>
    </div>
</div>
<!--end::Content-->
@endsection

@include('pages.invoices.print_track_invoices' , ['printInvoices'=> $print_data])

@section('js')

<script>
    var myStatusModal = new bootstrap.Modal('#status', {})

    function getStatus(id) {
        let select = $(`#status_select_${id} option:selected`);
        let url = select.data('url');
        let status = select.val();
        let data = {
            'status_invoice': status
            , 'order_date': select.data('date')
            , 'id': select.data('id')
            , '_method': 'PUT'
        }
        if (status == 'delared') {
            $('#update-status-form').attr('action', url);
            $('#update-status-form #id_invoice').val(data.id);
            $('#update-status-form #status_invoice').val(status);
            $('#status').modal('show');
        } else {
            sendAjax(url, data);
        }
    }


    function printPage() {
        var printContents = document.getElementById('print_invoice').innerHTML;
        // $('.table-striped').css('font-family', 'Almarai');
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        // location.reload();
        history.back();
    }

    function sendAjax(url, data) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url
            , method: 'POST'
            , data: data
            , beforeSend: function() {
                $('.btn-submit-status').attr('disabled', 'disabled');
            }
            , success: function(data) {
                location.reload();
            }
            , complete: function() {
                $('.btn-submit-status').attr('disabled', false);
            }
            , error: function(reject) {
                console.log(reject);
            }
        });
    }

</script>

@endsection
