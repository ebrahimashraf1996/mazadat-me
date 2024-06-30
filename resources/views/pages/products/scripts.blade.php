<script>



    let rows = [];

    // function append html to dom
    function getRows(id = 1, price = null, qty = 1) {
        $('.container-sales').append(`
            <div class="row parent_row desgin-form-input text-center" id=${id}>

                <div class="form-group col-lg-1">
                    <label> كود</label>
                    <input type="number" class="form-control form-control-solid" name="code[]">
                </div>

                <div class="form-group col-lg-2">
                    <label> اسم العميل</label>
                    <input type="text" min="0" class="form-control form-control-solid client_origin d-inline-block" name="client[]" required>
                    <a href="javascript:void(0);" class="search_icon_a" onclick="searchClients($(this).parent().find('.client_origin')[0])"><i class="fa fa-search"></i></a>
                <div class="show-client-auction" style="width:150px"></div>

                </div>

                <div class="form-group col-lg-2">
                    <label> نوع الصنف</label>
                    <select class="form-control form-control-solid access_price select_product" name="product[]" id="select_product_${id}">
                    </select>
                </div>

                <div class="form-group col-lg-2">
                    <label> تفاصيل المنتج</label>
                    <input type="text" min="0" class="form-control form-control-solid" name="notes[]">
                </div>

                <div class="form-group col-lg-2">
                    <label> عدد القطع</label>
                    <input type="number" min="0" class="form-control form-control-solid"
                        value="${qty}"
                        onkeyup  ="changeVale(${id}  , this)"
                        onchange ="changeVale(${id}, this)"
                        name="count_pieces[]"
                        required>
                </div>

                <div class="form-group col-lg-2">
                    <label> السعر </label>
                    <input type="text" min="0" class="form-control form-control-solid product_form_price"  value="${price}" name="price[]" required>
                </div>

                <div class="form-group col-lg-1">
                    <label for="">.</label>
                    <button type="button" class="btn btn-danger d-block remove_row" > x </button>
                </div>
            </div>
            `)

        addDataInformation(id,qty);
        calcQuantity(rows);
    }

    function searchClients(this_element) {
        // console.log(val);
        $.ajax({
            url: "{{route('new.search.clients.auctions')}}",
            data: {
                username: this_element.value,
            },
            type: "GET",
            success: function (response) {
                if (typeof (response) != 'object') {
                    response = $.parseJSON(response)
                }

                if (response.status === 'success') {
                    $(this_element).parent().find('.show-client-auction').html(response.client);
                    $(this_element).parent().find('.new_show-client-auction').html(response.client);

                    console.log(response.client);
                }
            }

        });
    }

    function update_original(this_element) {
        let this_element_value = this_element.value;
        let original_input = $(this_element).parent().parent().find('.client_origin');
        let new_original_input = $(this_element).parent().parent().find('.new_client_origin');
        original_input.val(this_element_value);
        new_original_input.val(this_element_value);
    }
    // add row html
    $('#add_row').click(function() {
        // alert('test');
        getRows(genrateIdForObject(), Cookies.get('price'));
        let options = JSON.parse(Cookies.get('products'));
        options.forEach(function(obj) {
            $(`#select_product_${genrateIdForObject() - 1}`)
            .append(`<option value="${obj.id}" data-price="${obj.price}"> ${obj.name} </option>`);
        });
    });

    // add row html
    $('#new_add_row').click(function() {
        // alert('test');
        newGetRows(newGenrateIdForObject(), Cookies.get('new_price'));
        let new_options = JSON.parse(Cookies.get('new_products'));
        new_options.forEach(function(obj) {
            $(`#new_select_product_${newGenrateIdForObject() - 1}`)
            .append(`<option value="${obj.id}" data-price="${obj.price}"> ${obj.name} </option>`);
        });
    });
    function newGetRows(id = 1, price = null, qty = 1) {
        // alert('test');
        $('.new-container-sales').append(`
            <div class="row new_parent_row  desgin-form-input text-center" id=${id}>

                <div class="form-group col-lg-1">
                    <label> كود</label>
                    <input type="number" class="form-control form-control-solid" name="new_code[]">
                </div>

                <div class="form-group col-lg-2">
                    <label> اسم العميل</label>
                    <input type="text" min="0" class="form-control form-control-solid new_client_origin" name="new_client[]" oninput="searchClients(this)" required>
                <div class="new_show-client-auction" style="width:150px"></div>

                </div>

                <div class="form-group col-lg-2">
                    <label> نوع الصنف</label>
                    <select class="form-control form-control-solid access_price new_select_product" name="new_product[]" id="new_select_product_${id}">
                    </select>
                </div>

                <div class="form-group col-lg-2">
                    <label> تفاصيل المنتج</label>
                    <input type="text" min="0" class="form-control form-control-solid" name="new_notes[]">
                </div>

                <div class="form-group col-lg-2">
                    <label> عدد القطع</label>
                    <input type="number" min="0" class="form-control form-control-solid"
                        value="${qty}"
                        onkeyup  ="newChangeVale(${id}  , this)"
                        onchange ="newChangeVale(${id}, this)"
                        name="new_count_pieces[]"
                        required>
                </div>

                <div class="form-group col-lg-2">
                    <label> السعر </label>
                    <input type="text" min="0" class="form-control form-control-solid new_product_form_price"  value="${price}" name="new_price[]" required>
                </div>

                <div class="form-group col-lg-1">
                    <label for="">.</label>
                    <button type="button" class="btn btn-danger d-block remove_row_btn" > x </button>
                </div>
            </div>
            `);

        newAddDataInformation(id,qty);
        newCalcQuantity(rows);
    }

    function newAddDataInformation(code, quantity) {
        rows.push({
            id: code
            , qty: quantity
            , });
    }
    function newCalcQuantity(arrayOfData = rows) {
        total_qty = 0;
        arrayOfData.forEach(function(obj) {
            total_qty += parseInt(obj.qty);
        })
        $('#new_quantity').text(total_qty + parseInt($('#new_qty_first').val()));
    }

    // genetrate id for every object
    function newGenrateIdForObject() {
        let lengthRows = rows.length + 1;
        return lengthRows;
    }




    // accsess price from select box
    $(document).on('change', '.access_price', function() {
        let newPrice = $(this).find(":selected").data('price');
        let Price   = $(this).closest(".parent_row").find(".product_form_price").val(newPrice);
    });

    // delete row quantity
    $(document).on('click', '.remove_row', function() {
        delete rows[$(this).closest(".parent_row").attr('id') - 1];
        $(this).closest(".parent_row").remove();
        calcQuantity(rows);
    });
    // delete row quantity
    $(document).on('click', '.remove_row_btn', function() {
        delete rows[$(this).closest(".new_parent_row").attr('id') - 1];
        $(this).closest(".new_parent_row").remove();
        newCalcQuantity(rows);
        // alert($(".new_parent_row").length);
        let rows_count = $(".new_parent_row").length;
        if(rows_count < 1) {
            $('#save_resell').hide();
        }
    });

    // function removeRowBtn(this_row) {
    //     alert('test');
    //
    // }

    // change value if update
    function changeVale(input_id, input_qty) {
        console.log(input_id, input_qty);
        input_qty.value == 0 ? input_qty.value = '' : input_qty;
        rows.map(function(obj) {
            if (obj.id == input_id) {
                obj.qty = input_qty.value == 0 ? 0 : input_qty.value;
            }
        });
        calcQuantity(rows);
    }
    // change value if update
    function newChangeVale(input_id, input_qty) {
        console.log(input_id, input_qty);
        input_qty.value == 0 ? input_qty.value = '' : input_qty;
        rows.map(function(obj) {
            if (obj.id == input_id) {
                obj.qty = input_qty.value == 0 ? 0 : input_qty.value;
            }
        });
        newCalcQuantity(rows);
    }

    //calc total qty
    function calcQuantity(arrayOfData = rows) {
        total_qty = 0;
        arrayOfData.forEach(function(obj) {
            total_qty += parseInt(obj.qty);
        })
        $('#quantity').text(total_qty + parseInt($('#qty_first').val()));
    }

    // add all data in array
    function addDataInformation(code, quantity) {
        rows.push({
            id: code
            , qty: quantity
        , });
    };

    // genetrate id for every object
    function genrateIdForObject() {
        let lengthRows = rows.length + 1;
        return lengthRows;
    }

</script>
