  <div class="modal fade" id="clients" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title h2" id="exampleModalLabel"> عميل متعدد الشراء</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

              <div class="modal-body">
                <h2 class="pb-3 text-center"> اضافة عميل</h2>
                  <form  action="{{ route('check-client') }}" method="POST" id="add_client_form">
                    @csrf
                      <div class="row desgin-form-input text-center">

                          <div class="form-group col-lg-10">
                              <label>أسم العميل</label>
                              <input type="text" class="form-control form-control-solid search-client-auction product_form_name" name="name" 
                                data-url="{{ route('search.clients.auctions') }}" required>

                              <div class="show-client-auction"></div>
                          </div>    

                          {{-- <div class="form-group col-lg-5"> --}}
                              <input type="hidden" class="form-control form-control-solid" name="auction_id" value="{{ auth('auction')->check() ?  auth('auction')->user()->id : null }}">
                          {{-- </div> --}}

                          <div class="form-group col-lg-2">
                              <label>.</label>
                              <button type="submit" class="btn btn-primary d-block h4" id="btn-add-client"> اضف عميل</button>
                          </div>

                      </div>
                  </form>
              </div>

              <br><hr>

              <div class="modal-body client_input_container">
                  <h2 class="pb-3 text-center">عميل متعدد الشراء</h2>

                  <form class="form" action="{{ route('client-many-products' ,  $auctionStage->id) }}" method="POST" id="buy_client">
                      @csrf

                      <div class="row desgin-form-input text-center">

                          <div class="form-group col-lg-1">
                              <label>كود</label>
                              <input type="number" class="form-control form-control-solid" name="code[]">
                          </div>

                          <div class="form-group col-lg-2">
                              <label>اسم العميل</label>
                              <input type="text"  class="form-control form-control-solid client_form_name"  readonly>
                          </div>

                          <input type="hidden" class="form-control form-control-solid client_form_id" name="client_id">
                          <input type="hidden" class="form-control form-control-solid delivery_form_id" name="delivery_id">

                          <div class="form-group col-lg-2">
                              <label>نوع الصنف</label>
                              <input type="text" min="0" class="form-control form-control-solid" name="products[]" required>
                          </div>

                          <div class="form-group col-lg-2">
                              <label>تفاصيل المنتج</label>
                              <input type="text" min="0" class="form-control form-control-solid" name="notes[]">
                          </div>

                          <div class="form-group col-lg-2">
                              <label>عدد القطع</label>
                              <input type="number" class="form-control form-control-solid" id="client_qty_first" onkeyup="calcClientQuantity()" name="count_pieces[]" required>
                          </div>

                          <div class="form-group col-lg-2">
                              <label>السعر </label>
                              <input type="text" min="0" class="form-control form-control-solid" name="price[]" required>
                          </div>

                          <div class="form-group col-lg-1">
                              <label for="">.</label>
                              <button type="button" class="btn btn-primary d-block" id="add_client_row">+</button>
                          </div>

                      </div>

                      <div class="container-sales-client"></div>

                        <div class="row">
                          <div class="col-lg-3"></div>

                          <div class="form-group col-lg-3">
                              <button  class="btn btn-info d-block ml-auto h3 mt-3" id="btn_buy_clients">بيع</button>
                          </div>

                          <div class="form-group col-lg-3">
                              <span id="client_quantity" class="d-block text-center h3 mt-3">1</span>
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
