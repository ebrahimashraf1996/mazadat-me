@extends('layouts.app')
@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Card-->
            <div class="card">
                <div class="card-body">
                    <div class="card gutter-b">
                        <h3 class="card-label alert alert-success text-center">العملاء </h3>
                        <div class="card-header flex-wrap border-0 pt-2 pb-0">
                            <div class="card-title">
                                <div class="row">

                                    <div class="col-lg-6">
                                        @if(auth()->guard('auction')->user() != null)
                                        <a href="{{route('clients.create')}}" class="btn btn-success"> أضافة عميل</a>
                                        @endif
                                    </div>

                                    <div class="col-lg-6">
                                        <input type="text" class="form-control ajax-name-client" placeholder="البحث بألاسم أو رقم الهاتف" data-url="{{route('ajax.name.clients')}}">
                                    </div>

                                </div>
                            </div>

                            <hr>
                            <div class="row text-center" style="padding:20px 0">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <lable> التاريخ من<lable>
                                                    <hr>
                                                    <input type="date" class="form-control date_from">
                                        </div>

                                        <div class="col-lg-5">
                                            <lable> التاريخ الي<lable>
                                                    <hr>
                                                    <input type="date" class="form-control date_to">
                                        </div>

                                        <div class="col-lg-2">
                                            <button type="button" class="btn btn-success ajax-date-clients" style="width:100%;transform:translateY(55px)" data-url="{{route('ajax.date.clients')}}"> بحث </button>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-body ajax-clients">
                    <!--begin::Search Form-->
                    <div class="mb-12">
                        <div class="table-responsive">
                            <table class="table-striped table table-bordered text-center" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الأسم</th>
                                        <th>اسم المستخدم</th>
                                        <th> اسم المزاد</th>
                                        <th>موبايل 1</th>
                                        <th>موبايل 2</th>
                                        <th>العنوان</th>
                                        <th>المنطقة</th>
                                        <th>الأعدادات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $client)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$client->name}}</td>
                                        <td>{{$client->username}}</td>
                                        <td>{{$client->auction->name}}</td>
                                        <td>{{$client->phone1}}</td>
                                        <td>{{$client->phone2}}</td>
                                        <td>{{$client->address}}</td>
                                        <td>{{@$client->area['name']}}</td>
                                        <td>
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">الاعدادات <i class="fas fa-caret-down"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                @if(auth()->guard('auction')->user() != null)
                                                <a class="btn btn-success" href="{{route('clients.edit', $client->id)}}"><i class="fa fa-edit" style="left:0;position:relative"></i> تعديل</a>
                                                @endif

                                                {{-- @if(Auth::user()->hasDirectPermission('حذف عملاء')) --}}
                                                <a class="btn btn-danger" data-toggle="modal" href="#myModal-{{$client->id}}"><i class="fa fa-trash"></i>حذف</a>
                                                {{-- @endif --}}
                                            </div>
                                            <div class="modal fade" id="myModal-{{$client->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">حذف العميل</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" action="{{route('clients.destroy', $client->id)}}" method="POST">
                                                                <input name="_method" type="hidden" value="DELETE">
                                                                {{ csrf_field() }}
                                                                <p>هل انت متأكد ؟</p>
                                                                <button type="submit" class="btn btn-danger" name='delete_modal'><i class="fa fa-trash" aria-hidden="true"></i>حذف</button>
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
                    <div class="d-flex justify-content-center">{{ $clients->appends(request()->query())->links() }}</div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
</div>
<!--end::Content-->
@endsection
