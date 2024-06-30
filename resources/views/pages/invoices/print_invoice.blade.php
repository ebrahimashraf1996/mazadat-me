<!DOCTYPE html>
<html lang="ar">
<head>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300&display=swap" rel="stylesheet"> --}}
    <style>
        body,
        html {
            font-family: 'Cairo';
            background: #eee !important;
        }
        
         @page { size: 20cm 40cm portrait; }

        table tr td {
            display: block;
            font-size: 15px
        }

    </style>
</head>
<body>

    <!--begin::Search Form-->
    @foreach($invoices as $invoice)
    @php
    $total_products = 0;
    @endphp
    <div class="container">
        <table border="1" style="text-align:center;background:#fff;color:#111;page-break-inside: avoid !important; page-break-after:always !important;">
            <thead>
                <tr>
                    <td colspan="2">رقم الفاتورة: {{ @$invoice->invoice_number }}</td>
                    <td colspan="3">كود المزاد: {{ @$invoice->auction->code }}</td>
                </tr>
                {{-- @dd($invoice->payment) --}}

                <tr>
                    <td> اسم العميل</td>
                    <td>{{ @$invoice->client['username']}}</td>

                    <td>رقم العميل</td>
                    <td colspan="2">{{ @$invoice->client['phone1']}}</td>

                </tr>
                <tr>
                    <td>اسم المندوب</td>
                    <td>{{-- @$invoice->delivery['name']	 --}} {{ $invoice->getFirstAreaOfInvoice(@$invoice->client->area_id, $invoice->id) }}</td>

                    <td>طريقة الدفع</td>
                    <td colspan="2">{{ @$invoice->payment == null ? 0 : @$invoice->payment}}</td>

                </tr>

                <tr>
                    <td>اسم المزاد</td>
                    <td>{{ @$invoice->auction['name'] }}</td>
                    <td>تاريخ المزاد</td>
                    <td colspan="2">{{ @$invoice->auction_date }}</td>
                </tr>

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

                @if($products->count() > 0)

                @if($products->where('client_id', $invoice->client_id)->where('auction_id', $invoice->auction_id)->count() > 1)

                @foreach($products->where('client_id', $invoice->client_id)->where('auction_id', $invoice->auction_id)->where('auction_date', $invoice->auction_date) as $row)
                <tr>
                    <td> {{$loop->iteration}} </td>
                    <td style="width:50%"> {{ @$row->product['name'] }} </td>
                    <td> {{ @$row['price'] }} </td>
                    <td> {{ @$row['count_pieces'] }} </td>
                    <td class="sum_product"> {{ @$row['price'] * $row['count_pieces'] }} </td>
                </tr>
                @php
                $total_products += $row['price'] * $row['count_pieces'];
                @endphp
                @endforeach

                @elseif($products->where('client_id', $invoice->client_id)->where('auction_id', $invoice->auction_id)->count() == 1)

                @foreach($products->where('client_id', $invoice->client_id)->where('auction_id', $invoice->auction_id) as $row)

                <tr>
                    <td> {{$loop->iteration}} </td>
                    <td style="width:50%;"> {{ @$row->product['name'] }} </td>
                    <td> {{ @$row['price'] }} </td>
                    <td> {{ @$row['count_pieces'] }} </td>
                    <td class="sum_product"> {{ $total_products = $row['price'] * $row['count_pieces'] }} </td>
                </tr>

                @endforeach
                @endif

                @else
                <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                </tr>
                @endif

                <tr>
                    <td colspan="2" class="delivery_price"> {{ $invoice->delivery_price != '' ? $invoice->delivery_price : $setting->amount_invoice}} </td>
                    <td colspan="3"> رسو التوصيل </td>
                </tr>

                <tr>
                    <td colspan="2"> {{ $invoice->delivery_date != null ? $invoice->delivery_date : 'لم يحدد' }} </td>
                    <td colspan="3">تاريخ التوصيل</td>
                </tr>


                <tr>
                    <td colspan="2" class="sum_total"> {{ $invoice->delivery_price != ''? $total_products + $invoice->delivery_price: $total_products + $setting->amount_invoice }} </td>
                    <td colspan="3"> الأجمالي </td>
                </tr>

            </thead>
        </table>
    </div>
    @endforeach

</body>
</html>
