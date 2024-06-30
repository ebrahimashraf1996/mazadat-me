<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">

        @font-face {
            font-family: 'Almarai';
            font-weight: 700;
            font-style: normal;
            font-variant: normal;
            src: url({{ storage_path('fonts\Almarai\Almarai-Bold.ttf')}}) format("truetype");
        }
        /*@import url('https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap');*/


        * {
            padding: 0;
            margin: 0;
        }

        body {
            /*font-family: 'Cairo', sans-serif;*/
            font-family: "Almarai","Ubuntu", sans-serif;
            direction: rtl;
            font-weight: bold;
            text-align: right;
            font-size: 25px;
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
            /* margin:  0; */
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
            /*padding: 5px;*/
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
            font-size: 28px;
            padding: 7px 0 !important;
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

        <div class="f_left sitename" style="font-size:40px">
            <span>{{ mb_substr($invoice->getFirstAreaOfInvoice(@$invoice->client->area_id, $invoice->id), 0, 1) }}</span>
        </div>

        <div class="f_right sitename" style="font-size:40px">
            <span>{{ @$invoice->invoice_number }}</span>
        </div>
        <div class="clear"></div>

        <p class="inviceid"><b>{{ @$invoice->auction->code }} </b> : كود المزاد</p>
        <p class="inviceid"><b>{{ @$invoice->invoice_number }} </b> : رقم الفاتورة</p>

        <div class="f_left">
            <span class="title" style="font-size:29px">{{ @$invoice->client['phone1']}}</span> :
            <span class="title" style="font-size:29px">رقم العميل</span>
        </div>

        <div class="f_right">
            <span class="title" style="font-size:29px">{{ @$invoice->client['username']}}</span> :
            <span class="title" style="font-size:29px">اسم العميل</span>
        </div>
        <div class="clear"></div>

        <div class="f_right">
            <span class="title" style="font-size:29px">{{ @$invoice->payment == null ? 0 : @$invoice->payment}}</span> :
            <span class="title" style="font-size:29px">طريقة الدفع</span>
        </div>

        <div class="f_left">
            <span class="title" style="font-size:29px">{{ $invoice->getFirstAreaOfInvoice(@$invoice->client->area_id, $invoice->id) }}</span> :
            <span class="title" style="font-size:29px">اسم المندوب</span>
        </div>
        <div class="clear"></div>

        <div class="f_right">
            <span class="title" style="font-size:29px">{{$invoice->stage? $invoice->stage->getStartTime() :''}}</span> :
            <span class="title" style="font-size:29px">تاريخ المزاد</span>
        </div>

        <div class="f_left">
            <span class="title" style="font-size:29px">{{ @$invoice->stage->name }}</span> :
            <span class="title" style="font-size:29px">اسم المزاد</span>
        </div>
        <div class="clear"></div>

        <hr>

        <div class="f_left">
            <span style="font-size:30px">{{ @$invoice->client->piece }}</span> :
            <span class="title" style="font-size:29px"> قطعه</span>
        </div>

        <div class="f_right">
            <span class="title" style="font-size:29px">{{ @$invoice->client->area->name }}</span> :
            <span class="title" style="font-size:29px">مدينة </span>
        </div>
        <div class="clear"></div>

        <div class="f_left">
          <span class="title" style="font-size:29px">{{ @$invoice->client->avenue }} </span> :
            <span class="title" style="font-size:29px"> جاده</span>
        </div>

        <div class="f_right">
            <span class="title" style="font-size:29px">{{ @$invoice->client->street }} </span> :
            <span class="title" style="font-size:29px">شارع </span>
        </div>
        <div class="clear"></div>

        <div class="f_right">
            <span style="font-size:29px">{{ @$invoice->client->house_number }} </span> :
            <span class="title" style="font-size:29px"> رقم المنزل </span>
        </div>
        <div class="clear"></div>
        @if(@$invoice->client->address != '')
        <div class=" w-100" style="margin-bottom: 20px">
            <span style="font-size:29px">{{ @$invoice->client->address }} </span> :
            <span class="title" style="font-size:29px"> العنوان </span>
        </div>
        @endif

        <div class="userorders">
            <table style="width:100%">
                <thead>
                    <tr>
                        <td style="padding: 7px 0">الملاحظات</td>
                        <td style="padding: 7px 0">الاجمالي</td>
                        <td style="padding: 7px 0">السعر</td>
                        <td style="padding: 7px 0">الكميه</td>
                        <td style="padding: 7px 0">الصنف</td>
                        <td style="padding: 7px 0">تسلسل</td>
                    </tr>
                </thead>
                <tbody>
                    @if(count($invoice->auctionProducts) > 0)
                        @foreach($invoice->auctionProducts as $row)
                            <tr>
                                <td>{{ @$row['notes'] }}</td>
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
                        <td colspan="8">
                            <div class="user_or">
                                @php($setting_ = App\Models\Setting::where('auction_id' , auth('auction')->user()->id)->first())
{{--                                <span class="price">{{ $invoice->delivery_price !== null ?  $invoice->delivery_price : $setting->amount_invoice}} </span> : <span class="title">رسوم التوصيل </span>--}}
{{--                                <span class="price">{{ $invoice->delivery_price !== null ?  $invoice->delivery_price : 'لم يحدد'}} </span> : <span class="title">رسوم التوصيل </span>--}}
                                <span class="price"  style="font-size: 29px">{{ $invoice->delivery_price == null && !is_int($invoice->delivery_price)  ?  $setting_->amount_invoice : $invoice->delivery_price  }} </span> : <span class="title" style="font-size: 29px">رسوم التوصيل </span>
                            </div>
                            <hr>
                            <div class="user_or">
                                <span class="price" style="font-size: 29px">{{ $invoice->delivery_date != null ? $invoice->delivery_date : 'لم يحدد' }}</span> : <span class="title" style="font-size: 29px">تاريخ التوصيل </span>
                            </div>
                        </td>
                    </tr>
                    <tr class="last_price">
                        <td colspan="6">
                            <div class="text-center">
                                <div  style="font-size:32px">اجمالي الفاتورة</div>
{{--                                <div  style="font-size:32px"><b>{{ $invoice->delivery_price !== null ? $total_products + $invoice->delivery_price : $total_products + $setting->amount_invoice }}</b></div>--}}
                                <div  style="font-size:32px"><b>{{ $invoice->delivery_price == null && !is_int($invoice->delivery_price) ? $total_products + $setting_->amount_invoice : $total_products + $invoice->delivery_price }}</b></div>
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
