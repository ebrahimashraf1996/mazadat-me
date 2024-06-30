<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>طباعة الفواتبر</title>

</head>
<body>
    <div class="container mt-1"  id="print_invoice"  style="display: none">
        <table class="table">
          <h2 class="m-2 text-center"> {{ date('Y-m-d')  }}  </h2>
            <thead>
                <tr>
                    <th scope="col"> تسلسل</th>
                    <th scope="col">رقم الفاتورة</th>
                    <th scope="col">اسم العميل</th>
                    <th scope="col">المنطقة</th>
                    <th scope="col">القطعة</th>
                    <th scope="col">شارع</th>
                    <th scope="col">منزل</th>
                    <th scope="col">رقم الزبون</th>
                    <th scope="col">ملاحظات</th>
                    <th scope="col">السعر</th>
                    <th scope="col">الصافى</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($printInvoices as $invoice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $invoice->invoice_number ?: ' '}}</td>
                        <td>{{ $invoice->client_name}}</td>
                        <td>{{ $invoice->client != null  ? $invoice->client->area->name : ' '}}</td>
                        <td>{{ $invoice->client != null  ? $invoice->client->piece : ' '}}</td>
                        <td>{{ $invoice->client != null  ? $invoice->client->street : ' '}}</td>
                        <td>{{ $invoice->client != null  ? $invoice->client->house_number : ' '}}</td>
                        <td>{{ $invoice->client_phone ?: ' ' }}</td>
                        <td>   </td>
                        <td>
                            {{(float)totalPriceProduct($invoice->auctionProducts) + (float)($invoice->delivery_price !== null ?  $invoice->delivery_price :  $setting->amount_invoice)}}
                        </td>
                        <td>  </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
