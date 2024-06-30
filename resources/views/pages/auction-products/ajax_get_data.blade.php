@foreach($auction_products as $product)
<tr>
    <td><input type="checkbox" class="select_count_pieces" value="{{$product->count_pieces}}"></td>
    <td>{{$product->invoice?$product->invoice->invoice_number: ''}}</td>
{{--    <td>{{$product->code}}</td>--}}
    <td>{{@$product->client->username}}</td>
    <td>{{@$product->product->name}}</td>
    <td colspan="2">{{$product->purchase_type}} </td>
    <td class="count_pieces">{{$product->count_pieces}}</td>
    <td>{{$product->price}}</td>
    <td>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#notes{{$product->id}}">
            عرض الملاحظات
        </button>

        <!-- Modal -->
        <div class="modal fade" id="notes{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ملاحظات علي المنتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! $product->notes !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">أغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    </td>
    <td>
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">الاعدادات <i class="fas fa-caret-down"></i></button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @if(checkClient($product->client) == "مكتمل")
            <a class="btn btn-success" href="{{route('clients.edit', $product->client_id)}}"><i class="fa fa-user"></i> معتمد</a>
            @else
            <a class="btn btn-danger" href="{{route('clients.edit', $product->client_id)}}"><i class="fa fa-user"></i> غير معتمد</a>
            @endif
            <a class="btn btn-success" href="{{route('auction-products.edit', ['auctionStage' => $auctionStage->id, $product->id])}}"><i class="fa fa-edit"></i> تعديل</a>
            <a class="btn btn-danger" data-toggle="modal" href="#myModal-{{$product->id}}"><i class="fa fa-trash"></i> مسح</a>
        </div>
        <div class="modal fade" id="myModal-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">حذف مؤقت</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" action="{{route('auctions.destroy', $product->id)}}" method="POST">
                            <input name="_method" type="hidden" value="DELETE">
                            {{ csrf_field() }}
                            <p>هل انت متأكد ؟</p>
                            <button type="submit" class="btn btn-danger" name='delete_modal'><i class="fa fa-trash" aria-hidden="true"></i> حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
@endforeach


<script>
    $(function() {


        var count_pieces = 0;
        $('.count_pieces').each(function() {
            count_pieces += parseFloat($(this).text());
        });

        $('.total_count_piece').text(count_pieces);



        /** Select Cehckbox Count piece**/
        $('.select_count_pieces').click(function() {
            var arr = [];
            var totalPrice = 0;
            var i;

            $('.select_count_pieces:checked').each(function() {
                arr.push($(this).val());
                var price = $(this).val();
                totalPrice += Number(price);
            });

            if (totalPrice == 0) {
                var count_pieces = 0;
                $('.count_pieces').each(function() {
                    count_pieces += parseFloat($(this).text());
                });
                $('.total_count_piece').text(count_pieces);
            } else {
                $('.total_count_piece').text(totalPrice);
            }
        });
    });
</script>
