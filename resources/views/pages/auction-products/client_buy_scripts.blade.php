<script>

    let clientRows = [];

    // function append html to dom
    function getClientRows(id=1 , name = null ,qty = 1 ) {
        $('.container-sales-client').append(`
            <div class="row parent_client_row desgin-form-input text-center" id=${id}>
            
                <div class="form-group col-lg-1">
                    <label> كود</label>
                    <input type="number" class="form-control form-control-solid" name="code[]">
                </div>

                <div class="form-group col-lg-2">
                    <label> اسم العميل</label>
                    <input type="text" min="0" class="form-control form-control-solid" value="${name}" readonly>
                </div>

                <div class="form-group col-lg-2">
                    <label> نوع الصنف</label>
                    <input type="text" min="0" class="form-control form-control-solid" name="products[]" required>
                </div>

                <div class="form-group col-lg-2">
                    <label> تفاصيل المنتج</label>
                    <input type="text" min="0" class="form-control form-control-solid" name="notes[]">
                </div>

                <div class="form-group col-lg-2">
                    <label> عدد القطع</label>
                    <input type="number" min="0" class="form-control form-control-solid" 
                    value="${qty}" 
                    onkeyup  ="clientChangeVale(${id}  , this)" 
                    onchange ="clientChangeVale(${id}, this)"
                    name="count_pieces[]"
                    required>
                </div>

                <div class="form-group col-lg-2">
                    <label> السعر </label>
                    <input type="text" min="0" class="form-control form-control-solid client_form_price" name="price[]" required>
                </div>

                <div class="form-group col-lg-1">
                    <label for="">.</label>
                    <button type="button" class="btn btn-danger d-block remove_client_row" > x </button>
                </div> 
            </div>`         
        )
        addClientDataInformation(id,name,qty);
        calcClientQuantity(clientRows);
    }

    // add row html
    $('#add_client_row').click(function() {
        getClientRows(genrateIdForClientObject() ,Cookies.get('client'));
    });

    // delete row color and quantity 
    $(document).on('click', '.remove_client_row', function() {
        delete clientRows[$(this).closest(".parent_client_row").attr('id')];
        $(this).closest(".parent_client_row").remove();
        calcClientQuantity(clientRows);
    });

    // change value if update
    function clientChangeVale(input_id, input_qty) {
        console.log(input_id , input_qty);
        input_qty.value == 0 ? input_qty.value = '' : input_qty;
        clientRows.map(function(obj) {
            if (obj.id == input_id) {
                obj.qty = input_qty.value == 0 ? 0 : input_qty.value;
            }
        });
        calcClientQuantity(clientRows);
    }

    //calc total qty
    function calcClientQuantity(arrayOfData = clientRows) {
        total_qty = 0;
        arrayOfData.forEach(function(obj) {
            total_qty += parseInt(obj.qty);
        })
        $('#client_quantity').text(total_qty + parseInt($('#client_qty_first').val()));
    }

    // add all data in array 
    function addClientDataInformation(code ,itemText, quantity) {
        clientRows.push({
            id  : code ,
            name : itemText ,
            qty: quantity  ,
        });
    };

    // genetrate id for every object
    function genrateIdForClientObject(){
        let lengthRows = clientRows.length;
        return lengthRows;
    }

</script>
