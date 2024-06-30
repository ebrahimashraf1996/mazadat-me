
$(document).ready(function() {

    $('.selectpicker').selectpicker();
    var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        removeItemButton: true,
        maxItemCount: false,
        searchResultLimit: false,
        renderChoiceLimit: false
    });


    $('.check_all').change('checked', function() {
        if (this.checked) {
            $('.check-permission').not(this).prop("checked", true);
        } else {
            $('.check-permission').not(this).prop('checked', this.checked);
        }
    });

    //===============> Add New employees
    $('.is_admin').change(function() {
        $select = $(this).find("option:selected").val();
        if ($select == "yes") {
            $('.hide-user').show();
        } else {
            $('.hide-user').hide();
        }
    });


    $('.update_shift').change(function() {
        $url = $(this).attr('data-url');
        $value = $(this).find("option:selected").val();
        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: { value: $value },
            success: function(data) {

            }
        });
    });

    //===============[Start Product Auction Page]
    $('#search_client').keyup(function() {
        $url = $(this).attr('data-url');
        $mobile = $(this).val();
        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: { mobile: $mobile },
            success: function(data) {
                $('.show-client').html(data.client);
            }
        });
    });

    $('#search_product').keyup(function() {
        $url = $(this).attr('data-url');
        $product = $(this).val();
        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: { product: $product },
            success: function(data) {
                $('.show-product').html(data.product);
            }
        });
    });




    $('.search-client-auction').keyup(function() {
        $url = $(this).attr('data-url');
        $username = $(this).val();

        if ($username != '') {
            $.ajax({
                url: $url,
                type: "GET",
                dataType: "JSON",
                data: { username: $username },
                success: function(data) {
                    $('.show-client-auction').show();
                    $('.show-client-auction').html(data.client);
                }
            });
        } else {
            $('.show-client-auction').hide();
        }

    });

    $('.search-product-auction').keyup(function() {
        $url = $(this).attr('data-url');
        $name = $(this).val();
        $show_product_auction = $(this).parent().find('.show-product-auction');

        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: { name: $name },
            success: function(data) {
                // alert('test');
                $show_product_auction.show();
                $show_product_auction.html(data.client);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('.show-product-auction').hide();
            }
        });

    });
    $('.new-search-product-auction').keyup(function() {
        $url = $(this).attr('data-url');
        $name = $(this).val();
        $show_product_auction = $(this).parent().find('.new-show-product-auction');

        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: { name: $name },
            success: function(data) {
                $show_product_auction.show();
                $show_product_auction.html(data.client);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('.new-show-product-auction').hide();
            }
        });

    });

    $(document).on('change', '.show-product-auction select[name="search_product"]', function () {
        let input_name = $(this).parent().parent().find('.search-product-auction');
        let current_val_text = $(this).find('option:selected').text();
        // alert(current_val_text);
        input_name.val(current_val_text)
    });
    $(document).on('change', '.new-show-product-auction select[name="search_product"]', function () {
        let input_name = $(this).parent().parent().find('.new-search-product-auction');
        let current_val_text = $(this).find('option:selected').text();
        // alert(current_val_text);
        input_name.val(current_val_text)
    });
    //===============[End Product Auction Page]



    $('.phone-client').keyup(function() {
        $url = $(this).attr('data-url');
        $mobile = $(this).val();
        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: { mobile: $mobile },
            success: function(data) {
                $('.data-reservation').html(data.reservations);
            }
        });
    });



    $('#status-reservation').change(function() {
        $select = $(this).find("option:selected").val();
        if ($select == "live") {
            $('.date input').val('').prop('disabled', true);
            $('.time input').val('').prop('disabled', true);
        } else {
            $('.date input').prop('disabled', false);
            $('.time input').prop('disabled', false);
        }
    });


    //==== Get Total Price Data In Page Add Services

    //========================= ORders =====================================

    $('.items').change(function() {
        $url = $(this).attr('data-url');
        $items = $(this).val();
        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: {
                items: $items,
            },
            success: function(data) {
                $('#count_items').html(data.items);
            }
        });
    });
    //====================== Income Reservations ===========================
    $('.income_reservations').click(function() {
        $url = $(this).attr('data-url');
        $date_from = $('.date_from').val();
        $date_to = $('.date_to').val();
        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: {
                date_from: $date_from,
                date_to: $date_to,
            },
            success: function(data) {
                $('#income_reservation').html(data.income_reservation);
            }
        });
    });
    // CKEDITOR.replace('note');

    //========== REPORTS ================

    /** Start Report Adjustment **/
    $('.ajax-report-adjustment').click(function() {
        $url = $(this).attr('data-url');
        $date_from = $('.date_from').val();
        $date_to = $('.date_to').val();
        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: {
                date_from: $date_from,
                date_to: $date_to,
            },
            success: function(data) {
                $('.ajax-adjustment').html(data.adjustment);
            }
        });
    });
    /** End Report Adjustment **/

    /** Start Report Expenses **/
    $('.ajax-report-expenses').click(function() {
        $url = $(this).attr('data-url');
        $date_from = $('.date_from').val();
        $date_to = $('.date_to').val();
        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: {
                date_from: $date_from,
                date_to: $date_to,
            },
            success: function(data) {
                $('.ajax_expenses').html(data.expenses);
            }
        });
    });
    /** End Report Expenses **/

    /** Start Report Clients **/
    $('.ajax-name-client').keyup(function() {
        $url = $(this).attr('data-url');
        $value = $(this).val();
        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: { value: $value },
            success: function(data) {
                $('.ajax-clients').html(data.clients);
            }
        });
    });

    $('.ajax-date-clients').click(function() {
        $url = $(this).attr('data-url');
        $date_from = $('.date_from').val();
        $date_to = $('.date_to').val();
        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: {
                date_from: $date_from,
                date_to: $date_to,
            },
            success: function(data) {
                $('.ajax-clients').html(data.clients);
            }
        });
    });
    /** End Report Clients **/

    /** Start Report Invoices **/
    $('.ajax-name-invoices').keyup(function() {

        $url = $(this).attr('data-url');
        $value = $(this).val();
        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: { value: $value },
            success: function(data) {
                $('.ajax-invoices').html(data.invoices);
            }
        });
    });

    $('.ajax-date-invoices').click(function() {
        $url = $(this).attr('data-url');
        $date_from = $('.date_from').val();
        $date_to = $('.date_to').val();
        $.ajax({
            url: $url,
            type: "GET",
            dataType: "JSON",
            data: {
                date_from: $date_from,
                date_to: $date_to,
            },
            success: function(data) {
                $('.ajax-invoices').html(data.invoices);
            }
        });
    });

    /** Start Add New Invoice **/
    $('.discount_number').keyup(function() {
        if ($(this).val() != '') {
            $('.discount_parcent').prop('disabled', true);
        } else {
            $('.discount_parcent').prop('disabled', false);
        }
    });

    $('.discount_parcent').keyup(function() {
        if ($(this).val() != '') {
            $('.discount_number').prop('disabled', true);
        } else {
            $('.discount_number').prop('disabled', false);
        }
    });
    /** End Add New Invoice **/

    /** End Report Invoices **/


    //=================================================
    $('#show_area').change(function() {
        $url = $(this).attr('data-url');
        $city_id = $(this).find("option:selected").val();

        $.ajax({
            url: $url,
            type: "GET",
            // dataType: "JSON",
            data: { city_id: $city_id },
            success: function (data) {
                $('#clients_areas').html(data.areas);
            }
        });
    });
    //=================================================
    $('.new_show_area').change(function() {
        $url = $(this).attr('data-url');
        $city_id = $(this).find("option:selected").val();
        $new_clients_areas = $(this).parent().parent().find('.new_clients_areas');
        $.ajax({
            url: $url,
            type: "GET",
            // dataType: "JSON",
            data: { city_id: $city_id },
            success: function (data) {
                $new_clients_areas.html(data.areas);
            }
        });
    });
    //===================================================
    /** Add Count Product Auction */

    $(".btn-submit-product").click(function(e) {

        e.preventDefault();

        var url = $('.data-form-product').attr('action');
        var data = $('.data-form-product').serialize();
        $auction_url = $(this).attr('data-url');
        console.log(url);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            beforeSend: function() {
                $(".btn-submit-product").hide();
            },
            success: function(data) {
                console.log(data.status);
                if (data.status == true) {
                    $('.error-message').hide();
                    //$(".data-form-product").trigger("reset");
                    //$('.show-client-auction').empty();
                    $.ajax({
                        url: $auction_url,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data) {
                            $('.ajax-proudct-auction').html(data.auction_products);
                        }
                    });

                } else {
                    console.log(data.errors)
                    $('.error-message').show();
                    $('html,body').animate({
                        scrollTop: $('.scroll-top').offset().top
                    }, 1000);
                    $('.error-product-auction').text(data.errors);
                }
            },
            complete: function() {
                $(".btn-submit-product").show();
            },
            error: function(reject) {
                $('.error-message').show();
                $('html,body').animate({
                    scrollTop: $('.scroll-top').offset().top
                }, 1000);

                let res = $.parseJSON(reject.responseText);
                console.log(res.errors);
                $.each(res.errors, function(key, value) {
                    $('.error-product-auction').text(value[0]);
                });
            }
        });
    });

    //********************************************* */

    /** Report Invoice */
    $(".filter-invoice").click(function(e) {

        e.preventDefault();

        $url = $(this).attr('data-url');
        $date_from = $('.date_from').val();
        $date_to = $('.date_to').val();
        $code_auction = $('.code_auction').val();
        $invoice_number = $('.invoice_number').val();
        $auction_id = $('.auction_id').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: $url,
            method: 'POST',
            data: { date_from: $date_from, date_to: $date_to, code_auction: $code_auction, invoice_number: $invoice_number, auction_id: $auction_id },
            success: function(data) {
                $('.ajax-report-invoices').html(data.result);
            },
        });
    });

    /**=============================================== */

    $('.check_all_auctions').change('checked', function() {
        if (this.checked) {
            $('.select_count_pieces').not(this).prop("checked", true);
        } else {
            $('.select_count_pieces').not(this).prop('checked', this.checked);
        }

        var count_pieces = 0;
        $('.count_pieces').each(function() {
            count_pieces += parseFloat($(this).text());
        });

        $('.total_count_piece').text(count_pieces);

    });


});
function newCalcQuantity(arrayOfData = rows) {
    total_qty = 0;
    arrayOfData.forEach(function(obj) {
        total_qty += parseInt(obj.qty);
    })
    $('#new_quantity').text(total_qty + parseInt($('#new_qty_first').val()));
}
