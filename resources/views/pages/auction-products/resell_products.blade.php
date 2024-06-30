<div class="modal fade" id="resell_products" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title h2" id="exampleModalLabel"> تكرار البيع </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <h2 class="pb-3 text-center"> اضافة منتج</h2>
                <form action="{{ route('check-product') }}" method="POST" id="new_add_product_form">
                    @csrf
                    <div class="row desgin-form-input text-center">

                        <div class="form-group col-lg-5">
                            <label>أسم المنتج</label>
                            <input type="text"
                                   class="form-control form-control-solid product_form_name new-search-product-auction"
                                   data-url="{{ route('search.products.auctions') }}" name="name" required>
                            <div class="new-show-product-auction"></div>
                        </div>

                        <div class="form-group col-lg-5">
                            <label>سعر القطعة</label>
                            <input type="text" class="form-control form-control-solid" name="price" required>
                        </div>

                        <div class="form-group col-lg-2">
                            <label>.</label>
                            <button type="submit" class="btn btn-primary d-block h4" id="btn-add-product"> اضف منتج
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <br>
            <hr>

            <div class="modal-body new_product_input_container">
                <h2 class="pb-3 text-center">منتج متعدد البيع</h2>
                <form class="form" action="{{ route('newBuyProduct' ,   $auctionStage->id) }}" method="POST"
                      id="new_buy_product">
                    @csrf
                    <div class="row main_parent_row desgin-form-input text-center">

                        <div class="form-group col-lg-1">
                            <label>كود</label>
                            <input type="number" class="form-control form-control-solid" name="new_code[]">
                        </div>

                        <div class="form-group col-lg-2">
                            <label>اسم العميل</label>
                            <input type="text" min="0" class="form-control form-control-solid client_origin"
                                   oninput="searchClients(this)"
                                   name="new_client[]" required>
                            <div class="show-client-auction" style="width:150px"></div>
                        </div>

                        <div class="form-group col-lg-2">
                            <label>نوع الصنف</label>
                            <select class="form-control form-control-solid access_price" id="new_select_product"
                                    name="new_product[]"  >
                            </select>
                        </div>

                        <div class="form-group col-lg-2">
                            <label>تفاصيل المنتج</label>
                            <input type="text" min="0" class="form-control form-control-solid" name="new_notes[]">
                        </div>

                        <div class="form-group col-lg-2">
                            <label>عدد القطع</label>
                            <input type="number" class="form-control form-control-solid" id="new_qty_first"
                                   onkeyup="newCalcQuantity()" name="new_count_pieces[]" required>
                        </div>

                        <div class="form-group col-lg-2">
                            <label>السعر </label>
                            <input type="text" min="0" class="form-control form-control-solid product_form_price"
                                   id="main_price" name="new_price[]" required>
                        </div>

                        <div class="form-group col-lg-1">
                            <label for="">.</label>
                            <button type="button" class="btn btn-primary d-block" id="new_add_row">+</button>
                        </div>

                    </div>

                    <div class="new-container-sales">

                    </div>

                    <div class="row">
                        <div class="col-lg-3"></div>

                        <div class="form-group col-lg-3">
                            <button class="btn btn-info d-block ml-auto h3 mt-3" id="new_btn_buy_products"> بيع</button>
                        </div>

                        <div class="form-group col-lg-3">
                            <span id="new_quantity" class="d-block text-center h3 mt-3">1</span>
                        </div>

                        <div class="col-lg-3"></div>
                    </div>

                </form>
            </div>

            <div class="modal-body">
                <form action="{{route('renewSell')}}" method="post">
                    <input type="hidden" name="auctionStage" value="{{$auctionStage->id}}">
                    @csrf
                @if(isset($new_products) && count($new_products) > 0)
                    @foreach($new_products as $key => $product)
{{--                        @dd($product->where('auction_stage_id', $stage_id)->max('auction_product_price'))--}}
                        <div class="parent_row">

                        <div class="row new_main_parent_row desgin-form-input text-center ">

                            <div class="form-group col-lg-4">
                                <label>نوع الصنف</label>
                                <p class="form-control form-control-solid product"
                                   data-value="{{$product->first()->product_id}}" data-name="{{$key}}">{{$key}}</p>
                            </div>

                            <div class="form-group col-lg-4">
                                <label>عدد القطع المباعة</label>
                                <p class="form-control form-control-solid pieces_count"
                                   data-value="{{$product->where('auction_stage_id', $stage_id)->sum('count_pieces')}}">{{$product->where('auction_stage_id', $stage_id)->sum('count_pieces')}}</p>


                            </div>

                            <div class="form-group col-lg-3">
                                <label>أعلي سعر </label>
                                <p class="form-control form-control-solid high_price"
                                   data-value="{{$product->where('auction_stage_id', $stage_id)->max('auction_product_price')}}">{{$product->where('auction_stage_id', $stage_id)->max('auction_product_price')}}</p>
                            </div>

                            <div class="form-group col-lg-1">
                                <label for="">.</label>
                                <button type="button" class="btn btn-primary d-block new_add_row"
                                        onclick="newAddRow(this)">+
                                </button>
                            </div>

                        </div>
                        </div>
                        <br>
                    @endforeach

                        <div class="w-100 text-right" style="display:none;" id="save_resell">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">أغلاق</button>
                        </div>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
            </div>

        </div>
    </div>
</div>
<script>
    // access price from select box
    $(document).on('change', '#new_select_product', function () {
        let newPrice = $(this).find(":selected").data('price');
        let Price = $(this).closest(".new_main_parent_row ").find(".new_product_form_price").val(newPrice);
    });
    // access price from select box
    $(document).on('change', 'select[name="new_search_client[]"]', function () {
        let selected_val = $(this).val();
        let main = $(this).parent().parent().find('.new-search-client-auction');
        main.val(selected_val);
        main.trigger('change')
    });

    function newAddRow(row_btn) {
        let closest_parent = $(row_btn).closest('.parent_row');



        let product_id =  closest_parent.find('.product').attr('data-value');
        let product_name =  closest_parent.find('.product').attr('data-name');
        let pieces_count =  closest_parent.find('.pieces_count').attr('data-value');
        let high_price =  closest_parent.find('.high_price').attr('data-value');


        closest_parent.append(
            `<div class="row new_parent_row desgin-form-input text-center">
                <div class="form-group col-lg-1">
                    <label> كود</label>
                    <input type="number" class="form-control form-control-solid" name="new_code[]">
                </div>
                <div class="form-group col-lg-2">
                    <label> اسم العميل</label>
                    <input type="text" min="0" class="form-control form-control-solid client_origin" name="new_client[]" oninput="searchClients(this)" required>
                    <div class="show-client-auction" style="width:150px"></div>
                </div>
                <div class="form-group col-lg-2">
                    <label> نوع الصنف</label>
                    <input type="hidden" name="new_product[]" value="${product_id}">
                    <p class="form-control form-control-solid product">${product_name}</p>
                </div>
                <div class="form-group col-lg-2">
                    <label> تفاصيل المنتج</label>
                    <input type="text" min="0" class="form-control form-control-solid" name="new_notes[]">
                </div>
                <div class="form-group col-lg-2">
                    <label> عدد القطع</label>
                    <input type="number" min="0" class="form-control form-control-solid"
                    value="1"
                    name="count_pieces[]"
                    required>
                </div>
                <div class="form-group col-lg-2">
                    <label> السعر </label>
                    <input type="text" min="0" class="form-control form-control-solid new_product_form_price"  value="${high_price}" name="new_price[]" required>
                </div>
                <div class="form-group col-lg-1">
                    <label for="">.</label>
                    <button type="button" class="btn btn-danger d-block remove_row_btn" > x </button>
                </div>
            </div>`
        );
        $('#save_resell').show();
    }

    function newCalcQuantity(arrayOfData = rows) {
        total_qty = 0;
        arrayOfData.forEach(function(obj) {
            total_qty += parseInt(obj.qty);
        })
        $('#new_quantity').text(total_qty + parseInt($('#new_qty_first').val()));
    }
    $('#new_buy_product').submit(function (e) {
        e.preventDefault();
        const action = $(this).attr("action");
        let formData = new FormData($(this)[0]);

        $.ajax({
            url: action
            , data: formData
            , type: 'POST'
            , processData: false
            , contentType: false
            , cache: false
            , beforeSend: function () {
                $('#new_btn_buy_products').attr('disabled', 'disabled');
            }
            , success: function (res) {
                Swal.fire(
                    'Good job!'
                    , 'تم الاضافة بنجاح'
                    , 'success'
                )
                location.reload();
            }
            , complete: function (data) {
                //
            }
            , error: function (reject) {
                console.log(reject);
            }
        });

    });
</script>
