<script>
    var products = [];
    $('#add_product_form').submit(function (e) {
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
                //
            }
            , success: function (res) {

                // 👇 Push object to array
                if (!products.some(el => el.id === res.product.id)) {

                    products.push({'id': res.product.id, 'name': res.product.name, 'price': res.product.price});

                    // var myNewOption = new Option(res.product.name, res.product.id);
                    $('#select_product').append(`
                    <option value="${res.product.id}" data-price="${res.product.price}">
                     ${res.product.name} </option>`);

                    $('select.select_product').each(function () {
                        var currentSelect = $(this);
                        currentSelect.append(`
                        <option value="${res.product.id}" data-price="${res.product.price}">
                        ${res.product.name} </option>`);
                    });

                }

                Cookies.set('price', products[0].price);
                if (products.length == 1) {
                    $('.product_form_price').val(products[0].price);
                }

                Allproducts = JSON.stringify(products);
                Cookies.set('products', Allproducts);

                let qty_first = $('#qty_first').val();

                if (qty_first === '') {
                    $('#qty_first').val(1);
                }
                $('.product_input_container').css('display', 'block');

            }
            , complete: function (data) {
                //
            }
            , error: function (reject) {
                console.log(reject);
            }
        });

    });
    var new_products = [];
    $('#new_add_product_form').submit(function (e) {
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
                //
            }
            , success: function (res) {

                // 👇 Push object to array
                if (!new_products.some(el => el.id === res.product.id)) {

                    new_products.push({'id': res.product.id, 'name': res.product.name, 'price': res.product.price});

                    // var myNewOption = new Option(res.product.name, res.product.id);
                    $('#new_select_product').append(`
                    <option value="${res.product.id}" data-price="${res.product.price}">
                     ${res.product.name} </option>`);

                    $('select.select_product').each(function () {
                        var currentSelect = $(this);
                        currentSelect.append(`
                        <option value="${res.product.id}" data-price="${res.product.price}">
                        ${res.product.name} </option>`);
                    });

                }

                Cookies.set('new_price', new_products[0].price);
                if (new_products.length == 1) {
                    $('.product_form_price').val(new_products[0].price);
                }

                AllNewproducts = JSON.stringify(new_products);
                Cookies.set('new_products', AllNewproducts);

                let qty_first = $('#qty_first').val();

                if (qty_first === '') {
                    $('#qty_first').val(1);
                }
                $('.new_product_input_container').css('display', 'block');

            }
            , complete: function (data) {
                //
            }
            , error: function (reject) {
                console.log(reject);
            }
        });

    });



    $('#buy_product').submit(function (e) {
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
                $('#btn_buy_products').attr('disabled', 'disabled');
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

    $('#add_client_form').submit(function (e) {
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
                //
            }
            , success: function (res) {

                Cookies.set('client', res.client.username);
                $('.client_form_id').val(res.client.id);
                $('.client_form_name').val(res.client.username);
                $('.delivery_form_id').val(res.delivery);
                $('#client_qty_first').val(1);
                $('.client_input_container').css('display', 'block');
                $('#btn-add-client').attr("style", "display: none !important");
            }
            , complete: function (data) {
                //
            }
            , error: function (reject) {
                console.log(reject);
            }
        });

    });

    $('#buy_client').submit(function (e) {
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
                $('#btn_buy_clients').attr('disabled', 'disabled');
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
