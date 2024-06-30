@if($invoices->count() > 0)
  <div class="mb-12">
      <form action="{{ route('print.invoices') }}" class="btn btn-success print-invoice">
        @csrf
        
        @foreach($invoices as $invoice)
        <input type="hidden" name="invoices_id[]" value="{{ $invoice->id }}">
        @endforeach
        <button type="submit" class="btn btn-success">طباعة الفواتير</button>
      </form>
      <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>رقم الفاتورة</th>
            <th>اسم العميل</th>
            <th>كود المزاد</th>
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
            <td>{{@$invoice->auction['code']}}</td>
            <td>{{$invoice->auction_date?:''}}</td>
            <td>{{ $invoice->delivery_price != '' ? $invoice->delivery_price : $setting->amount_invoice}}</td>
            <td>{{$invoice->delivery_date?:'لم يحدد'}}</td>
            <td>{{totalPriceProduct($invoice->client_id, $invoice->auction_id, $invoice->auction_date) + (int)($invoice->delivery_price != '' ? $invoice->delivery_price : $setting->amount_invoice)}} </td>
            <td>
              @if(checkClient($invoice->client) == "مكتمل")
                  <span class="alert alert-success">{{ checkClient($invoice->client) }}</span>
              @else
                  <span class="alert alert-danger">{{ checkClient($invoice->client) }}</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      </div>
  </div>
@else
<h4 class="alert alert-danger text-center"> لا يوجد نتائج بحث</h4>
@endif
           