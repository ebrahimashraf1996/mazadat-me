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
                    <h3 class="card-label alert alert-success text-center"> المناطق</h3>
                    <div class="card-title">
                       @if(Auth::user()->hasDirectPermission('اضافة ادمن'))
                        <a href="{{route('areas.create')}}"class="btn btn-primary">أضافة منطقة </a>
                        @endif
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
                              <th>اسم البلد</th>
                              <th>اسم المدينة</th>
                              <th>اسم المنطقة</th>
                              <th>الأعدادات</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($areas as $area)
                            <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{@$area->city->country->name}}</td>
                              <td>{{@$area->city->name}}</td>
                              <td>{{$area->name}}</td>
                              <td>
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                    									aria-haspopup="true" aria-expanded="true"> الاعدادات <i class="fas fa-caret-down"></i></button>
                    									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @if(Auth::user()->hasDirectPermission('تعديل ادمن'))
                    										<a class="btn btn-success" href="{{route('areas.edit', $area->id)}}"><i class="fa fa-edit"></i> تعديل</a>
                                        @endif
                                        @if(Auth::user()->hasDirectPermission('حذف ادمن'))
                    										<a class="btn btn-danger" data-toggle="modal" href="#myModal-{{$area->id}}"><i class="fa fa-trash"></i> مسح</a>
                                        @endif
                                      </div>
                    									<div class="modal fade" id="myModal-{{$area->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    										<div class="modal-dialog">
                    										<div class="modal-content">
                    										<div class="modal-header">
                    											<h5 class="modal-title" id="exampleModalLabel">حذف مؤقت</h5>
                    											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    											</button>
                    										</div>
                    										<div class="modal-body">
                    										<form role="form" class="form_delete" action="{{route('areas.destroy', $area->id)}}" method="POST">
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
