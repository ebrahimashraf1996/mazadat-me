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
                    <a href="{{route('categories.create')}}" class="btn btn-success">أضافة قسم</a>
                    <a class="btn btn-primary" href="{{route('categories.index')}}"> عرض الأقسام</a>
                    <h3 class="card-label" style="float:left">  المحذوفين مؤقتا </h3>
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
                              <th>الرمز</th>
                              <th>الأعدادات</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($categories as $category)
                            <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$category->name}}</td>
                              <td> <img src="{{asset($category->icon)}}" width="50px" height="50px"></td>
                              <td>
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                      aria-haspopup="true" aria-expanded="true">الاعدادات <i class="fas fa-caret-down"></i></button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="btn btn-success" href="{{route('categories.untrash', $category->id)}}"><i class="fa fa-edit" style="left:0;position:relative"></i> الغاء الحذف</a>
                                        <a class="btn btn-danger" data-toggle="modal" href="#myModal-{{$category->id}}"><i class="fa fa-trash"></i> حذف نهائي</a>
                                      </div>
                                      <div class="modal fade" id="myModal-{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">حذف نهائي</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                        <form role="form" action="{{route('categories.force.delete', $category->id)}}" method="POST">
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
