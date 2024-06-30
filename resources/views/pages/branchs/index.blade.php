@extends('layouts.app')
@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card gutter-b">
              <div class="card-header flex-wrap border-0 pt-2 pb-0">
                  <div class="card-title">
                      @if(!$branch_manger)
                          <a href="{{route('branchs.create')}}"class="btn btn-success"> أضافة فرع </a>
                      @endif
                      <a class="btn btn-danger" href="{{route('branchs.soft.delete')}}">المحذوف مؤقتا</a>
                      <h3 class="card-label" style="float:left"> الفروع
                  </div>
              </div>
                <div class="card-body">
                    <!--begin: Search Form-->
                    <!--begin::Search Form-->
                    <div class="mb-12">
                        <div class="table-responsive">
                          <table id="example" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>الأسم</th>
                              <th>العنوان</th>
                              <th>ساعات العمل من</th>
                              <th>ساعات العمل الي</th>
                              <th>الأعدادات</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($branchs as $branch)
                            <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$branch->name}}</td>
                              <td>{{$branch->address}}</td>
                              <td>{{$branch->work_hours_from}} ساعات</td>
                              <td>{{$branch->work_hours_to}} ساعات</td>
                              <td>
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                    									aria-haspopup="true" aria-expanded="true">الاعدادات <i class="fas fa-caret-down"></i></button>
                    									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:25%">
                                        <a class="btn btn-success" href="{{route('time_orders.show', $branch->id)}}"> <i class="fa fa-edit"></i> مواعيد الطلبيات</a>
                                        <a class="btn btn-success" href="{{route('branchs.new.orders', $branch->id)}}"> <i class="fa fa-edit"></i> طلبيات جديدة</a>
                                        <a class="btn btn-success" href="{{route('branchs.old.orders', $branch->id)}}"> <i class="fa fa-edit"></i>  طلبيات مستلمة</a>
                    										<a class="btn btn-success" href="{{route('branchs.edit', $branch->id)}}"> <i class="fa fa-edit"></i>  تعديل</a>
                    										<a class="btn btn-danger" data-toggle="modal" href="#myModal-{{$branch->id}}"> <i class="fa fa-trash"></i> مسح</a>
                    									</div>
                    									<div class="modal fade" id="myModal-{{$branch->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    										<div class="modal-dialog">
                    										<div class="modal-content">
                    										<div class="modal-header">
                    											<h5 class="modal-title" id="exampleModalLabel">حذف مؤقت</h5>
                    											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    											</button>
                    										</div>
                    										<div class="modal-body">
                    										<form role="form" class="form_delete" action="{{route('branchs.destroy', $branch->id)}}" method="POST">
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
                          </tbody>
                        </table>
                        </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->
@endsection
