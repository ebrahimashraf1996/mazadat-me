  <!--begin::Search Form-->
  @foreach($invoices as $invoice)
  <div class="mb-12">
      <div class="table-responsive show-invoice">
        <table id="" class="table table-striped text-center" cellspacing="0" width="100%" border="1px">
          <thead>
            <tr>
              <th colspan="2">رقم الفاتورة: {{ $invoice->invoice_number }}</th>
              <th colspan="3">كود المزاد: {{ $invoice->auction->code }}</th>
            </tr>

            <tr>
              <td> اسم العميل</td>
              <td>{{ @$invoice->client['username']	}}</td>
              <td>طريقة الدفع</td>
              <td colspan="2">{{ $invoice->payment}}</td>
            </tr>

            <tr>
              <td>اسم المندوب</td>
              <td>{{ @$invoice->delivery['name']	 }}</td>
              <td>رقم المندوب</td>
              <td colspan="2">{{ @$invoice->delivery['phone1']	}}</td>
            </tr>

            <tr>
              <td>العنوان</td>
              <td>{{ @$invoice->client['address'] }}</td>
              <td>تاريخ التوصيل</td>
              <td colspan="2">{{ $invoice->delivery_date }}</td>
            </tr>

            <tr>
              <td>اسم المزاد</td>
              <td>{{ @$invoice->auction['name'] }}</td>
              <td>تاريخ المزاد</td>
              <td colspan="2">{{ @$invoice->auction['date'] }}</td>
            </tr>

            <tr>
              <td>تسلسل</td>
              <td>الصنف</td>
              <td>السعر / الوحدة</td>
              <td>العدد</td>
              <td>الأجمالي</td>
            </tr>

            @if($products->count() > 0)
              @foreach($products->where('client_id', $invoice->client_id)->where('auction_id', $invoice->auction_id) as $row)
              <tr>
                <td> {{$loop->iteration}}  </td>
                <td> {{ $row->product['name'] }} </td>
                <td> {{ $row['price'] }} </td>
                <td> {{ $row['count_pieces'] }} </td>
                <td class="sum_product"> {{ $row['price'] * $row['count_pieces'] }} </td>
              </tr>
              @endforeach
            @else
            <tr>
              <td>  </td>
              <td>  </td>
              <td>  </td>
              <td>  </td>
              <td>  </td>
            </tr>
            @endif
          

            <tr>
              <td colspan="2"> رسو التوصيل </td>
              <td colspan="3" class="delivery_price"> {{ $invoice->delivery_price?:0}} </td>
            </tr>

            <tr>
              <td colspan="2"> الأجمالي </td>
              <td colspan="3" class="sum_total">  </td>
            </tr> 

          </thead>
         
        </table>
      </div> 
  </div>
  @endforeach