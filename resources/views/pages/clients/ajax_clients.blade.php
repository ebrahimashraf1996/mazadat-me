<div class="mb-12">
    <div class="table-responsive">
      @if($clients->count() > 0)
      <table id="example" class="table-striped table table-bordered text-center" width="100%">
      <thead>
        <tr>
          <th>#</th>
          <th>الأسم</th>
          <th>موبايل 1</th>
          <th>موبايل 2</th>
          <th>العنوان</th>
          <th>الأعدادات</th>
        </tr>
      </thead>
      <tbody>
        @foreach($clients as $client)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$client->name}}</td>
          <td>{{$client->phone1}}</td>
          <td>{{$client->phone2}}</td>
          <td>{{$client->address}}</td>
          <td>
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="true">الاعدادات <i class="fas fa-caret-down"></i></button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="btn btn-success" href="{{route('clients.edit', $client->id)}}"><i class="fa fa-edit" style="left:0;position:relative"></i> تعديل</a>
                    <a class="btn btn-danger" data-toggle="modal" href="#myModal-{{$client->id}}"><i class="fa fa-trash"></i>حذف مؤقت</a>
                  </div>
                  <div class="modal fade" id="myModal-{{$client->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">مسح عميل</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      </button>
                    </div>
                    <div class="modal-body">
                    <form role="form" action="{{route('clients.destroy', $client->id)}}" method="POST">
                    <input name="_method" type="hidden" value="DELETE">
                    {{ csrf_field() }}
                    <p>هل انت متأكد ؟</p>
                    <button type="submit" class="btn btn-danger" name='delete_modal'><i class="fa fa-trash" aria-hidden="true"></i>حذف مؤقت</button>
                    </form>
                    </div>
                    </div>
                    </div>
                  </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <h4 class="text-center alert alert-danger">لا يوجد نتائج بحث</h4>
    @endif
    </div>
  </div>
