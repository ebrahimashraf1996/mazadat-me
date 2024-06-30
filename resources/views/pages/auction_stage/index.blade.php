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
                    <h3 class="card-label alert alert-success text-center"> دورات المزاد </h3>
                    <div class="card-title">
                        <a href="{{route('auctionStages.create')}}" class="btn btn-primary">أضافة دورة</a>
                    </div>
                    <div class="card-title">
                        <form action="#" method="GET" class="row">
                            <div class="col-6">
                            <label> Search : </label>
                            <input type="text" class="control-form" name="name" value="{{ request()->name }}">

                            </div>
                            <div class="col-6">
                                {{-- <label> Search : </label> --}}
                                <div class="row justify-content-end">
                                    <select name="limit" class="select-pagination" style="margin-left: 25px;" onchange="this.form.submit()">
                                        <option value="10" {{request()->limit ==  10 ? 'selected' : ''}}>10</option>
                                        <option value="25" {{request()->limit ==  25 ? 'selected' : ''}}>25</option>
                                        <option value="50" {{request()->limit ==  50 ? 'selected' : ''}}>50</option>
                                        <option value="100" {{request()->limit ==  100 ? 'selected' : ''}}>100</option>
                                        <option value="150" {{request()->limit ==  150 ? 'selected' : ''}}>150</option>
                                    </select>
                                </div>
                            </div>
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
                                        <th>اسم الدورة</th>
                                        <th>تاريخ البداية باليوم</th>
                                        <th>تاريخ البداية بالوقت</th>
                                        <th> تم الانتهاء </th>
                                        <th>العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($auctionStages as $auctionStage)
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td> {{ $auctionStage->name }} </td>
                                        <td> {{ $auctionStage->getStartTime() }} </td>
                                        <td> {{ $auctionStage->getStartTimeAsTime() }} </td>
                                        <td> {{ $auctionStage->isExpired() == false ? 'لا' : $auctionStage->getEndTime() }} </td>
                                        <td>
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">الاعدادات <i class="fas fa-caret-down"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if(!$auctionStage->isExpired())
                                                <a data-toggle="modal" href="#myModal-end-auction-{{$auctionStage->id}}" class="btn btn-danger"> انهاء المزاد </a>
                                                @endif
                                                {{-- @if(!$auctionStage->isExpired())
                                                        <a href="{{route('auctionStage.expired.stage', $auctionStage->id)}}" class="btn btn-danger"> انهاء المزاد </a>
                                                @endif --}}
                                                <a class="btn btn-primary" href="{{ route('auction-products.index', $auctionStage->id) }}"><i class="fa fa-edit"></i> المنتجات</a>
                                                <a class="btn btn-success" href="{{route('auctionStages.edit', $auctionStage->id)}}"><i class="fa fa-edit"></i> تعديل</a>
                                                <a class="btn btn-danger" data-toggle="modal" href="#myModal-{{$auctionStage->id}}"><i class="fa fa-trash"></i> حذف</a>
                                            </div>
                                            <div class="modal fade" id="myModal-{{$auctionStage->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">حذف مؤقت</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" action="{{route('auctionStages.destroy', $auctionStage->id)}}" method="POST">
                                                                <input name="_method" type="hidden" value="DELETE">
                                                                {{ csrf_field() }}
                                                                <p>هل انت متأكد ؟</p>
                                                                <button type="submit" class="btn btn-danger" name='delete_modal'><i class="fa fa-trash" aria-hidden="true"></i> حذف</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="myModal-end-auction-{{$auctionStage->id}}" tabindex="-1" role="dialog" aria-labelledby="myModal-end-auction-label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"> انهاء المزاد</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <form role="form" action="{{route('auctionStage.expired.stage', $auctionStage->id)}}" method="GET">
                                                                <p>هل انت متأكد ؟</p>
                                                                <button type="submit" class="btn btn-danger" name='delete_modal'> انهاء </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

{{--                                            <button class="btn btn-success" id="edit_notes_btn" type="button"  data-toggle="modal" data-target="#edit_notes" data-post="{{route('updateNotes.stage', $auctionStage->id)}}" data-url="{{route('getNotes.stage', $auctionStage->id)}}"><i class="fa fa-edit"></i> تعديل الملاحظات</button>--}}

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end::Card-->
                <div class="d-flex justify-content-center">{{ $auctionStages->appends(request()->query())->links() }}</div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <div class="modal fade" id="edit_notes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل الملاحظات</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form class="form text-left" action="#" method="POST" id="post_notes_form">
                        @csrf
                          <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label for="post_notes">الملاحظات</label>
                                    <textarea class="form-control form-control-solid full-editor" id="post_notes" name="notes"></textarea>
                                    @error('notes')
                                    <span class="text-danger">{{$message}} </span>
                                    @enderror
                                </div>

                            </div>

                        </div>


                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">حفظ</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">أغلاق</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end::Content-->
    @endsection
@section('js')
        <script>
            $(document).ready(function () {
                let post_notes_form = $('#post_notes_form');
                let post_notes = $('#post_notes');
                let edit_notes_btn = $('#edit_notes_btn');

                edit_notes_btn.on('click', function () {





                    let get_notes_url = $(this).attr('data-url');
                    let post_notes_data = $(this).attr('data-post');

                    $.ajax({
                        url: get_notes_url,
                        data: {
                            _token: "{{csrf_token()}}",
                        },
                        type: "GET",
                        success: function (response) {
                            if (typeof (response) != 'object') {
                                response = $.parseJSON(response)
                            }
                            console.log(response.status);

                            if (response.status === 1) {
                                console.log(response.data);
                                post_notes_form.attr('action', post_notes_data);
                                console.log(response.data);
                                CKEDITOR.instances['post_notes'].setData(response.data);

                                // post_notes.val('');
                            }
                        }

                    });


                });
            });
        </script>
@endsection
