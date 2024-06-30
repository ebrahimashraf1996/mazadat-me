@extends('layouts.app')
@section('content')
    <!--begin::Content-->

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">

            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Card-->
                <div class="card gutter-b">
                    <div class="card-header flex-wrap border-0 pt-2 pb-0">
                        <h3 class="card-label alert alert-success text-center scroll-top"> مخزون المزاد </h3>
                        <div class="card-title">
                        {{-- <a href="{{route('auction-products.create', ['auction_id' => $auction_id])}}" class="btn btn-primary">أضافة منتج للمزاد</a> --}}
                        <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">

                                <div class="card-header">
                                    <h3 class="card-title" style="font-weight:bolder"> المخزون</h3>
                                    <h3 style="float: left;font-weight:bolder" class="card-title"><span
                                            class="total_count_piece" style="color: red"> </span> : عدد القطع </h3>
                                </div>

                                <form class="form" action="#" method="GET">

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="form-group col-lg-6">
                                                <div class="row">
                                                    <div class="{{request()->has('name_product') && request()->name_product != '' ? 'col-lg-11' : 'col-lg-12'}}">
                                                        <label>أسم المنتج</label>
                                                        <select class=" form-control" name="name_product" id="name_products_select">
                                                            <option value="">كل المنتجات</option>
    {{--                                                        @foreach ($products as $key => $product)--}}
    {{--                                                            <option--}}
    {{--                                                                value="{{ $key  }}" {{ request()->name_product ==  $key ? 'selected' : '' }}>{{ $product }}</option>--}}
    {{--                                                        @endforeach--}}
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-1" style="display: {{request()->has('name_product') && request()->name_product != '' ? 'inline-block' : 'none'}}; padding: 26px 0px 0 17px;">
                                                        <button class="btn btn-sm btn-danger" type="button" onclick="removeSelectedProduct()" style="width: 100%; padding-top: 6px!important;padding-bottom: 9px!important;">
                                                            <i class="fas fa-times p-0"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mt-3 row">
                                                    <div class="{{request()->has('name_client') && request()->name_client != '' ? 'col-lg-11' : 'col-lg-12'}}">

                                                        {{--                                                    @dd($clients)--}}
                                                        <label>أسم العميل</label>
                                                        <select class="name_client_select form-control" name="name_client"
                                                                id="name_client_select">
                                                            <option value="">كل العملاء</option>

                                                            {{--                                                        @foreach ($clients as $key => $client)--}}
                                                            {{--                                                            <option--}}
                                                            {{--                                                                value="{{ $key  }}" {{ request()->name_client ==  $key ? 'selected' : '' }}>{{ $client }}</option>--}}
                                                            {{--                                                        @endforeach--}}
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-1" style="display: {{request()->has('name_client') && request()->name_client != '' ? 'inline-block' : 'none'}}; padding: 26px 0px 0 17px;">
                                                        <button class="btn btn-sm btn-danger" type="button" onclick="removeSelectedClient()" style="width: 100%; padding-top: 6px!important;padding-bottom: 9px!important;">
                                                            <i class="fas fa-times p-0"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <div>
                                                    <label>من</label>
                                                    <input type="date" class="form-control" name="date_from"
                                                           max="{{ date('Y-m-d') }}" value="{{ request()->date_from }}">
                                                </div>
                                                <div>
                                                    <label> الى </label>
                                                    <input type="date" class="form-control" name="date_to"
                                                           max="{{ date('Y-m-d') }}" value="{{ request()->date_to }}">
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <div>
                                                    <label>أسم الدورة</label>
                                                    <select class="product-name form-control" name="name_stage">
                                                        <option value="">كل الدورات</option>
                                                        @foreach ($stages as $key => $stage)
                                                            <option
                                                                value="{{ $key  }}" {{ request()->name_stage ==  $key ? 'selected' : '' }}>{{ $stage }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <div>
                                                    <label for="phone1">رقم العميل</label>
                                                    {{--                                                 99840868--}}
                                                    <input type="text" name="phone1" id="phone1" class="form-control"
                                                           value="{{ request()->phone1 !=  '' ? request()->phone1 : '' }}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2 btn-block">بحث</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger text-center error-message">
                            <h4 class="error-product-auction"></h4>
                        </div>
                        @if($productSearch != [])
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <p style="font-size: 25px">عدد القطع المباعة :
                                        <span id="count_num">{{ $productSearch['count'] }}</span>
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p style="font-size: 25px"> اجمالى البيع :
                                        <span id="sale_sum">{{ $productSearch['saleSum'] }}</span>
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Start -->
                            <div class="col-lg-12">

                                <div class="mb-12">

                                    <div class="table-responsive">
                                        <table id="pixels" class="table table-striped table-bordered text-center"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>حساب القطع</th>
                                                <th>الرقم التسلسلي</th>
                                                <th> رقم الفاتورة</th>
                                                <th>اسم العميل</th>
                                                <th>نوع الصنف</th>
                                                {{--                                                    <th colspan="2">نوع الشراء</th>--}}
                                                <th colspan="2">تاريخ الدورة</th>
                                                <th>عدد القطع</th>
                                                <th>السعر</th>
                                                <th>ملاحظات</th>
                                                {{-- <th>الأعدادات</th> --}}
                                            </tr>

                                            </thead>
                                            <tbody class="ajax-proudct-auction">
                                            @foreach($all_auction_products as $product)
                                                <tr class="ceil" data-id="{{$product->count_pieces}}">
                                                    <td><input type="checkbox" class="select_count_pieces" value="{{$product->count_pieces}}"></td>
                                                    {{--   <td>{{$loop->iteration + $skipped}}</td>--}}
                                                    <td>{{$product->invoice != null ?  $product->invoice->serial_number : "-"}}</td>
                                                    <td>{{$product->invoice != null ?  $product->invoice->invoice_number : "-"}}</td>
                                                    <td>{{@$product->client_name}}</td>
                                                    <td>{{@$product->product_name}}</td>
                                                    {{--                                                    <td colspan="2">{{$product->purchase_type}}</td>--}}
                                                    <td colspan="2">{{$product->invoice && $product->invoice->stage ? $product->invoice->stage->getStartTime() : '---'}}</td>
                                                    <td class="count_pieces">{{$product->count_pieces}}</td>
                                                    <td>{{$product->price}}</td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary"
                                                                data-toggle="modal"
                                                                data-target="#notes{{$product->id}}">
                                                            عرض الملاحظات
                                                        </button>
                                                        <form action="{{route('return.product', $product->id)}}"
                                                              method="POST" class="d-inline-block">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">إضافة مرتجع
                                                            </button>
                                                        </form>
                                                        @if($product->invoice && $product->invoice->stage)
                                                            <a class="btn btn-success d-inline-block"
                                                               style="width: 100px !important;"
                                                               href="{{route('auction-products.edit', ['auctionStage' => $product->invoice->stage->id, $product->id])}}"><i
                                                                    class="fa fa-edit"></i> تعديل</a>
                                                        @endif
                                                    <!-- Modal -->
                                                        <div class="modal fade" id="notes{{$product->id}}" tabindex="-1"
                                                             role="dialog" aria-labelledby="exampleModalLabel"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            ملاحظات علي المنتج</h5>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {!! $product->notes !!}
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">أغلاق
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    {{-- <td>
                                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">الاعدادات <i class="fas fa-caret-down"></i></button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                            @if(customCheckClient($product->client_name , $product->client_phone) == "مكتمل")
                                                            <a class="btn btn-success" href="{{route('clients.edit', $product->client_id)}}"><i class="fa fa-user"></i> معتمد</a>
                                                            @else
                                                            <a class="btn btn-danger" href="{{route('clients.edit', $product->client_id)}}"><i class="fa fa-user"></i> غير معتمد</a>
                                                            @endif

                                                            <a class="btn btn-success" href="{{route('auction-products.edit', ['auctionStage' => $auctionStage->id, $product->id])}}"><i class="fa fa-edit"></i> تعديل</a>
                                                            <a class="btn btn-danger" data-toggle="modal" href="#myModal-{{$product->id}}"><i class="fa fa-trash"></i> حذف</a>
                                                        </div>
                                                        <div class="modal fade" id="myModal-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form role="form" class="form_delete" action="{{route('auction-products.destroy', ['auctionStage' => $auctionStage->id, 'auction_product' => $product->id])}}" method="POST">
                                                                            <input name="_method" type="hidden" value="DELETE">
                                                                            {{ csrf_field() }}
                                                                            <p>هل انت متأكد ؟</p>
                                                                            <button type="submit" class="btn btn-danger" name='delete_modal'><i class="fa fa-trash" aria-hidden="true"></i> حذف</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                            @if($productSearch != [])
                                                <tr class="ceil">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td colspan="2"></td>
                                                    <td>الاجمالى : {{ $productSearch['count'] }}</td>
                                                    <td> الاجمالى : {{ $productSearch['saleSum'] }}</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div
                                    class="d-flex justify-content-center">{{ $all_auction_products->appends(request()->query())->links() }}</div>
                            </div>
                            <!-- End -->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Entry-->
    </div>

@endsection

@push('css')
    <link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet"/>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush


@section('js')

    <script src="{{ asset('assets/js/cookies.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.product-name').select2();
        });

        $(document).ready(function () {

            let name_client_select = $('#name_client_select');
            function initializeSelect2() {
                name_client_select.select2({
                    ajax: {
                        url: '{{route('getClientsData')}}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term // search term
                            };
                        },
                        processResults: function (data) {
                            console.log(data)
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.username, // assuming your data has a 'name' attribute
                                        id: item.id // assuming your data has an 'id' attribute
                                    };
                                })
                            };
                        },
                        cache: true
                    },
                    placeholder: 'كل العملاء',
                    minimumInputLength: 1, // Minimum characters to start searching
                });
            }

            @if(request()->has('name_client') && request()->name_client != '')
            name_client_select.append(
                "<option value='{{request()->name_client}}'>{{\App\Models\Client::find(request()->name_client)->username}}</option>"
            );
            name_client_select.val('{{request()->name_client}}');
            name_client_select.select2({
                ajax: {
                    url: '{{route('getClientsData')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term // search term
                        };
                    },
                    processResults: function (data) {
                        console.log(data);
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.username, // assuming your data has a 'name' attribute
                                    id: item.id // assuming your data has an 'id' attribute
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: 'كل العملاء',
                minimumInputLength: 1, // Minimum characters to start searching

            });
            name_client_select.trigger('change');

            @else
            initializeSelect2();
                @endif

            let name_products_select = $('#name_products_select');
            function initializeProductsSelect2() {
                name_products_select.select2({
                    ajax: {
                        url: '{{route('getProductsData')}}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                query: params.term // search term
                            };
                        },
                        processResults: function (data) {
                            console.log(data)
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.name, // assuming your data has a 'name' attribute
                                        id: item.id // assuming your data has an 'id' attribute
                                    };
                                })
                            };
                        },
                        cache: true
                    },
                    placeholder: 'كل المنتجات',
                    minimumInputLength: 1, // Minimum characters to start searching
                });

            }

            // initializeSelect2();

            @if(request()->has('name_product') && request()->name_product != '')
            name_products_select.append(
                "<option value='{{request()->name_product}}'>{{\App\Models\Product::find(request()->name_product)->name}}</option>"
            );
            name_products_select.val('{{request()->name_product}}');
            name_products_select.select2({
                ajax: {
                    url: '{{route('getClientsData')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            query: params.term // search term
                        };
                    },
                    processResults: function (data) {
                        console.log(data)
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name, // assuming your data has a 'name' attribute
                                    id: item.id // assuming your data has an 'id' attribute
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: 'كل المنتجات',
                minimumInputLength: 1, // Minimum characters to start searching
                // templateSelection: function(data, container) {
                //     return data.text; // Displayed text in selected option
                // }
            });
            name_products_select.trigger('change');

            @else
            initializeProductsSelect2();
            @endif

        });
        let name_products_select = $("#name_products_select");
        function removeSelectedProduct() {
            name_products_select.val('');
            name_products_select.trigger('change');
        }
        let name_client_select = $("#name_client_select");
        function removeSelectedClient() {
            name_client_select.val('');
            name_client_select.trigger('change');
        }


    </script>

    <script>
        function markSelection(selection) {
            // make copies before sorting
            const coords = {
                x: selection["x"].slice().sort(sortNumbers)
                , y: selection["y"].slice().sort(sortNumbers)
            }
            // Only get relevant rows within range
            const rows = $("#pixels>tbody>tr").slice(coords["y"][0], coords["y"][1] + 1);
            // $("#pixels>tbody tr td").removeClass("selected");
            let cells = $();

            var conter = [];

            var number = 0;
            // In each relevant row, get the relevant cells
            rows.each(function (i, el) {
                let oneElement = $(el);
                // console.log(oneElement);
                number = parseInt(number) + parseInt(oneElement.attr('data-id'));
            });

            $('.total_count_piece').text(number);
        }

        function sortNumbers(a, b) {
            return a - b;
        }

        let isDragging = false;
        let selection = {};

        $("#pixels").on("mousedown", "td", function () {
            // Start dragging
            isDragging = true;

            const $this = $(this);
            selection["x"] = [$this.index(), $this.index()];
            selection["y"] = [$this.parent("tr").index(), $this.parent("tr").index()];

        }).on("mouseover", "td", function () {
            if (isDragging) {
                const $this = $(this);
                selection["x"][1] = $this.index();
                selection["y"][1] = $this.parent("tr").index();
                markSelection(selection);
            }
        }).on("mouseup", "td", function () {
            // End dragging
            isDragging = false;

            const $this = $(this);
            selection["x"][1] = $this.index();
            selection["y"][1] = $this.parent("tr").index();
            markSelection(selection);
        }).on("mouseleave", function () {
            // End dragging
            isDragging = false;
        });

    </script>

    <script>
        $(function () {
            //===============================================
            var count_pieces = 0;
            $('.count_pieces').each(function () {
                count_pieces += parseFloat($(this).text());
            });

            $('.total_count_piece').text(count_pieces);

            /** Select Cehckbox Count piece**/
            $('.select_count_pieces').click(function () {
                var arr = [];
                var totalPrice = 0;
                var i;

                $('.select_count_pieces:checked').each(function () {
                    arr.push($(this).val());
                    var price = $(this).val();
                    totalPrice += Number(price);
                });

                if (totalPrice == 0) {
                    var count_pieces = 0;
                    $('.count_pieces').each(function () {
                        count_pieces += parseFloat($(this).text());
                    });
                    $('.total_count_piece').text(count_pieces);
                } else {
                    $('.total_count_piece').text(totalPrice);
                }
            });
        });

    </script>

@endsection
