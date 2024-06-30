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
                        <h3 class="card-label alert alert-success text-center"> @if(Auth::guard('auction')->check())بيانات المزاد @else المزادات @endif </h3>
                        <div class="card-title">
                            @if(Auth::guard('admin')->check())
                                @if(Auth::user()->hasDirectPermission('اضافة مزادات'))
                                    <a href="{{route('auctions.create')}}" class="btn btn-primary">أضافة مزاد</a>
                                @endif
                            @endif
                        </div>
                        <div class="card-title">
                            <form action="#" method="GET">
                                <label> Search : </label>
                                <input type="text" class="control-form" name="name_auction" value="{{ request()->name_auction }}">
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Search Form-->
                        <!--begin::Search Form-->
                        <div class="mb-12">
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الأسم</th>
                                            <th>الكود</th>
                                            <th>تاريخ المزاد</th>
                                            <th>المدينة</th>
                                            <th>تفاصيل اخري</th>
                                            <th>الأعدادات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($auctions as $auction)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$auction->name?:'لم يحدد'}}</td>
                                            <td>{{$auction->code?:'لم يحدد'}}</td>
                                            <td>{{$auction->date?:'لم يحدد'}}</td>
                                            <td>{{@$auction->city_name}}</td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalemploy{{$auction->id}}">
                                                    عرض التفاصيل
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModalemploy{{$auction->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">بيانات أخري</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                @if($auction->details != null)
                                                                <p>{!! $auction->details !!}</p>
                                                                <hr>
                                                                @else
                                                                <h4 class="alert alert-danger text-center">لا يوجد تفاصيل</h4>
                                                                @endif

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
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 200px">

                                                    @if(Auth::guard('auction')->check())
                                                        <a class="btn btn-info" href="{{route('auctionStages.index')}}"><i class="fa fa-edit"></i> الدورات</a>
                                                        <a class="btn btn-info" href="{{route('auction.invoices', $auction->id)}}"><i class="fas fa-file-invoice"></i> الفواتير</a>
                                                        <a class="btn btn-info" href="{{route('auction.clients', $auction->id)}}"><i class="fas fa-users"></i> العملاء</a>
                                                        <a class="btn btn-success" href="{{route('auctions.edit', $auction->id)}}"><i class="fa fa-edit"></i> تعديل</a>
                                                    @else
                                                        @if(Auth::user()->hasDirectPermission('تعديل مزادات'))
                                                            <a class="btn btn-info" href="{{route('auctionStages.index')}}"><i class="fa fa-edit"></i> الدورات</a>
                                                            <a class="btn btn-info" href="{{route('auction.invoices', $auction->id)}}"><i class="fas fa-file-invoice"></i> الفواتير</a>
                                                            <a class="btn btn-info" href="{{route('auction.clients', $auction->id)}}"><i class="fas fa-users"></i> العملاء</a>
                                                            <a class="btn btn-success" href="{{route('auctions.edit', $auction->id)}}"><i class="fa fa-edit"></i> تعديل</a>
                                                        @endif
                                                    @endif


                                                    @if(Auth::guard('admin')->check())
                                                    @if(Auth::user()->hasDirectPermission('حذف مزادات'))
                                                    <a class="btn btn-danger" data-toggle="modal" href="#myModal-{{$auction->id}}"><i class="fa fa-trash"></i> حذف</a>
                                                    @endif
                                                </div>
                                                <div class="modal fade" id="myModal-{{$auction->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form role="form" class="form_delete" action="{{route('employees.destroy', $auction->id)}}" method="POST">
                                                                    <input name="_method" type="hidden" value="DELETE">
                                                                    {{ csrf_field() }}
                                                                    <p>هل انت متأكد ؟</p>
                                                                    <button type="submit" class="btn btn-danger" name='delete_modal'><i class="fa fa-trash" aria-hidden="true"></i> حذف</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">{{ $auctions->appends(request()->query())->links() }}</div>
                    </div>
                    <!--end::Card-->
                </div>
            <!--end::Container-->

        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
    @endsection
