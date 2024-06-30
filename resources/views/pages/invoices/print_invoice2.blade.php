<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">

        @font-face {
            font-family: 'Cairo';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url({{ storage_path('fonts\Cairo\Cairo-Bold.ttf')}}) format("truetype");
        }

        * {
            padding: 0;
            margin: 0;
        }

        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            font-size: 22px;
        }

        .inviceid {
            text-align: center;
        }

        .inviceid b {
            background-color: black;
            color: #fff;
            display: inline-block;
            padding: 0px 10px;
            border-radius: 4px;
            margin-right: 2px;
        }

        .sitename {
            text-align: center;
            margin: 10px 0;
        }

        .sitename img {
            max-width: 75%;
        }

        .userorders th:not(:last-child),
        .userorders td:not(:last-child) {
            border-left: 0;
        }

        .container {
            padding: 0 10px;
        }

        p {
            margin: 2px;
        }

        .userorders table {
            border-spacing: 0;
            text-align: center;
        }
       
        .userorders table thead tr th {
            padding: 5px;
        }
        .userorders table thead {
            border-top: 1px solid black !important;
            border-bottom: 1px solid black !important;
        }

        .userorders tbody tr td,
        .userorders tbody tr th {
            border-left: 0;
            border-top-style: solid !important;
            border-bottom: 0 !important;
            word-wrap: break-word;
            max-width: 120px;
        }

        /* .userorders tbody tr:first-child td,
        .userorders tbody tr:first-child th {
            border-top: 0 !important;
            border-bottom: 0 !important;
        } */

        .userorders tbody tr:last-child td,
        .userorders tbody tr:last-child th {
            border-bottom: 1px solid black !important;
        }

        .userorders tfoot td {
            border-top: 0;
        }

        .user_or {
            padding: 2px 0;
        }

        .f_left {
            float: left;
            width: 50%;
        }

        .f_right {
            float: right;
            width: 50%;
            word-wrap: break-word;
        }

        .clear {
            clear: both;
        }

        .user_or:last-child {
            border-bottom: 0;
        }

        .text-center {
            text-align: center;
        }

        tr.last_price {
            background: #d3d3d3;
        }

        .page-break {
            page-break-after: always;
        }

        td hr {
            margin: 0;
        }

    </style>

</head>
<body>


    @foreach($invoices as $invoice)
        @php
            $total_products = 0;
        @endphp
    <div class="container @if(!$loop->last) page-break @endif">
        <div class="sitename text-left"><img src="{{ public_path('assets/login.jpg') }}" height="60"></div>

        <p class="inviceid"><b>{{ @$invoice->auction->code }} </b> : كود المزاد</p>
        <p class="inviceid"><b>{{ @$invoice->invoice_number }} </b> : رقم الفاتورة</p>

        <div class="f_left">
            <span>{{ @$invoice->client['phone1']}}</span> :
            <span class="title">رقم العميل</span>
        </div>
        <div class="f_right">
            <span>{{ @$invoice->client['username']}}</span> :
            <span class="title">اسم العميل</span>
        </div>
        <div class="clear"></div>

        <div class="f_right">
            <span>{{ @$invoice->payment == null ? 0 : @$invoice->payment}}</span> :
            <span class="title">طريقة الدفع</span>
        </div>

        <div class="f_left">
            <span>{{ $invoice->getFirstAreaOfInvoice(@$invoice->client->area_id, $invoice->id) }}</span> :
            <span class="title">اسم المندوب</span>
        </div>
        <div class="clear"></div>

        <div class="f_right">
            <span>{{ @$invoice->auction_date }}</span> :
            <span class="title">تاريخ المزاد</span>
        </div>

        <div class="f_left">
            <span>{{ @$invoice->auction['name'] }}</span> :
            <span class="title">اسم المزاد</span>
        </div>
        <div class="clear"></div>

        <hr>

        <div class="f_left">
            <span>{{ @$invoice->client->piece }}</span> :
            <span class="title"> قطعه</span>
        </div>
        <div class="f_right">
            <span>{{ @$invoice->client->area->name }}</span> :
            <span class="title">مدينة </span>
        </div>
        <div class="clear"></div>

        <div class="f_left">
          <span>{{ @$invoice->client->avenue }} </span> :
            <span class="title"> جاده</span>
        </div>
        <div class="f_right">
            <span>{{ @$invoice->client->street }} </span> :
            <span class="title">شارع </span>
        </div>
        <div class="clear"></div>

        <div class="f_right">
            <span>{{ @$invoice->client->house_number }} </span> :
            <span class="title"> رقم المنزل </span>
        </div>
        <div class="clear"></div>

        <div class="userorders">
            <table style="width:100%">
                <thead>
                    <tr>
                        <td>الاجمالي</td>
                        <td>السعر</td>
                        <td>الكميه</td>
                        <td>الصنف</td>
                        <td>تسلسل</td>
                    </tr>
                </thead>
                <tbody>
                    @if($products->where('client_id', $invoice->client_id)->where('auction_id', $invoice->auction_id)->count() > 0)
                        @foreach($products->where('client_id', $invoice->client_id)->where('auction_id', $invoice->auction_id)->where('auction_date', $invoice->auction_date) as $row)
                        <tr>
                            <td>{{ @$row['price'] * $row['count_pieces'] }}</td>
                            <td> {{ @$row['price'] }}</td>
                            <th scope="row">{{ @$row['count_pieces'] }}</th>
                            <td>{{ @$row->product['name'] }}</td>
                            <td> {{ $loop->iteration }}</td>
                        </tr>
                        @php
                            $total_products += $row['price'] * $row['count_pieces'];
                        @endphp
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="user_or">
                                <span class="price">{{ $invoice->delivery_price != '' ? $invoice->delivery_price : $setting->amount_invoice}}</span> : <span class="title">رسوم التوصيل </span>
                            </div>
                            <hr>
                            <div class="user_or">
                                <span class="price">{{ $invoice->delivery_date != null ? $invoice->delivery_date : 'لم يحدد' }}</span> : <span class="title">تاريخ التوصيل </span>
                            </div>
                        </td>
                    </tr>
                    <tr class="last_price">
                        <td colspan="6">
                            <div class="text-center">
                                <div  style="font-size:32px">اجمالي الفاتورة</div>
                                <div  style="font-size:32px"><b>{{ $invoice->delivery_price != ''? $total_products + $invoice->delivery_price: $total_products + $setting->amount_invoice }}</b></div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endforeach
</body>
</html>
