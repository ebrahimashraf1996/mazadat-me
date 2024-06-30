<div class="modal fade" id="products" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title h2" id="exampleModalLabel"> منتج متعدد البيع </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <h2 class="pb-3 text-center"> اضافة منتج</h2>
                <form action="{{ route('check-product') }}" method="POST" id="add_product_form">
                    @csrf
                    <div class="row desgin-form-input text-center">

                        <div class="form-group col-lg-5">
                            <label>أسم المنتج</label>
                            <input type="text"
                                   class="form-control form-control-solid product_form_name search-product-auction"
                                   data-url="{{ route('search.products.auctions') }}" name="name" required>
                            <div class="show-product-auction"></div>
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

            <div class="modal-body product_input_container">
                <h2 class="pb-3 text-center">منتج متعدد البيع</h2>
                <form class="form" action="{{ route('buy-product' ,   $auctionStage->id) }}" method="POST"
                      id="buy_product">
                    @csrf
                    <div class="row main_parent_row desgin-form-input text-center">

                        <div class="form-group col-lg-1">
                            <label>كود</label>
                            <input type="number" class="form-control form-control-solid" name="code[]">
                        </div>

                        <div class="form-group col-lg-2">
                            <label>اسم العميل</label>
                            <input type="text" min="0" class="form-control form-control-solid client_origin d-inline-block"
                                   name="client[]" required>
                            <a href="javascript:void(0);" class="search_icon_a" onclick="searchClients($(this).parent().find('.client_origin')[0])"><i class="fa fa-search"></i></a>
                            <div class="show-client-auction" style="width:150px"></div>
                        </div>

                        <div class="form-group col-lg-2">
                            <label>نوع الصنف</label>
                            <select class="form-control form-control-solid access_price" id="select_product"
                                    name="product[]">
                            </select>
                        </div>

                        <div class="form-group col-lg-2">
                            <label>تفاصيل المنتج</label>
                            <input type="text" min="0" class="form-control form-control-solid" name="notes[]">
                        </div>

                        <div class="form-group col-lg-2">
                            <label>عدد القطع</label>
                            <input type="number" class="form-control form-control-solid" id="qty_first"
                                   onkeyup="calcQuantity()" name="count_pieces[]" required>
                        </div>

                        <div class="form-group col-lg-2">
                            <label>السعر </label>
                            <input type="text" min="0" class="form-control form-control-solid product_form_price"
                                   id="main_price" name="price[]" required>
                        </div>

                        <div class="form-group col-lg-1">
                            <label for="">.</label>
                            <button type="button" class="btn btn-primary d-block" id="add_row">+</button>
                        </div>

                    </div>

                    <div class="container-sales"></div>

                    <div class="row">
                        <div class="col-lg-3"></div>

                        <div class="form-group col-lg-3">
                            <button class="btn btn-info d-block ml-auto h3 mt-3" id="btn_buy_products"> بيع</button>
                        </div>

                        <div class="form-group col-lg-3">
                            <span id="quantity" class="d-block text-center h3 mt-3">1</span>
                        </div>

                        <div class="col-lg-3"></div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">أغلاق</button>
            </div>

        </div>
    </div>
</div>
<script>
    // access price from select box
    $(document).on('change', '#select_product', function () {
        let newPrice = $(this).find(":selected").data('price');
        let Price = $(this).closest(".main_parent_row ").find(".product_form_price").val(newPrice);
    });
    // access price from select box
    $(document).on('change', 'select[name="search_client"]', function () {
        let selected_val = $(this).val();
        let main = $(this).parent().parent().find('.search-client-auction');
        main.val(selected_val);
        main.trigger('change')
    });
</script>
