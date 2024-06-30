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
                                        {{--
                                        @if(Auth::user()->hasDirectPermission('اضافة عملاء'))
                                        --}}
                                        <div class="col-lg-6">
                                            <a href="{{route('clients.create')}}" class="btn btn-success"> أضافة
                                                عميل</a>
                                        </div>
                                        {{-- @endif --}}
                                        {{-- <div class="col-lg-6">
                                              <input type="text" class="form-control ajax-name-client" placeholder="البحث بألاسم أو رقم الهاتف" data-url="{{route('ajax.name.clients')}}">
                                    </div> --}}
                                    </div>
                                    <hr>
                                    <div class="card-title">
                                        <form action="#" method="GET" class="row">
                                            <div class="col-5">
                                                <div class="row">
                                                    <label for="name_client">البحث بالإسم او رقم الهاتف</label>

                                                    <input type="text" class="form-control"
                                                       placeholder="البحث بألاسم أو رقم الهاتف" name="name_client" id="name_client"
                                                       value="{{ request()->name_client }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <div>
                                                    <label for="name_stage">أسم الدورة</label>
                                                    <select class="product-name form-control" name="name_stage" id="name_stage" style="width: 100%">
                                                        <option value="">كل الدورات</option>
                                                        @foreach ($stages as $key => $stage)
                                                            <option value="{{ $key  }}" {{ request()->name_stage ==  $key ? 'selected' : '' }}>{{ $stage }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 px-1">
                                                <button type="submit" class="btn btn-primary btn-sm mt-9" style="width: 100%">بحث</button>
                                            </div>
                                            <div class="col-lg-1 px-1">
                                                <a href="{{route('burn_clients_session')}}" class="btn btn-danger btn-sm mt-9" style="width: 100%">إزالة الفلاتر</a>
                                            </div>

                                            <div class="col-2">
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
                                <hr>
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
                                            <td>{{$client->phone1}}</td>
                                            <td>{{$client->phone2}}</td>
                                            <td>{{$client->address}}</td>
                                            <td>{{@$client->area['name']}}</td>
                                            <td>
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true">الاعدادات <i
                                                        class="fas fa-caret-down"></i></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    {{--                                            <a class="btn btn-success" href="{{route('clients.edit', $client->id)}}?original_url={{\Request::getRequestUri()}}"><i class="fa fa-edit" style="left:0;position:relative"></i> تعديل</a>--}}

                                                    <button class="btn btn-success w-100" type="button"
                                                            data-toggle="modal"
                                                            data-target="#edit{{$client->id}}"><i
                                                            class="fa fa-edit" style="left:0;position:relative"></i>
                                                        تعديل
                                                    </button>
                                                    <a class="btn btn-danger" data-toggle="modal"
                                                       href="#myModal-{{$client->id}}"><i
                                                            class="fa fa-trash"></i>حذف</a>
                                                </div>
                                                <div class="modal fade" id="edit{{$client->id}}"
                                                     tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog" role="document"
                                                         style="max-width: 1000px;">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">اعتماد
                                                                    العميل</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @php($cities = App\Models\City::get())
                                                            @php($areas = App\Models\Area::get())

                                                            <div class="modal-body">
                                                                <form class="form text-left"
                                                                      action="{{route('clients.update', $client->id)}}"
                                                                      method="POST">
                                                                    @csrf
                                                                    {{method_field('PUT')}}
                                                                    <input type="hidden" name="original_url"
                                                                           value="{{url()->current()}}">
                                                                    <input type="hidden" name="client_id"
                                                                           value="{{$client->id}}">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="form-group col-lg-6">
                                                                                <label>الأسم</label>
                                                                                <input type="text"
                                                                                       class="form-control form-control-solid"
                                                                                       name="name"
                                                                                       value="{{$client->name}}">
                                                                                @error('name')
                                                                                <span
                                                                                    class="text-danger">{{$message}} </span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group col-lg-6">
                                                                                <label>اسم المستخدم</label>
                                                                                <input type="text"
                                                                                       class="form-control form-control-solid"
                                                                                       name="username"
                                                                                       value="{{$client->username}}">
                                                                                @error('username')
                                                                                <span
                                                                                    class="text-danger">{{$message}} </span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group col-lg-6">
                                                                                <label>موبايل 1</label>
                                                                                <input type="number"
                                                                                       class="form-control form-control-solid"
                                                                                       name="phone1"
                                                                                       value="{{$client->phone1}}">
                                                                                @error('phone1')
                                                                                <span
                                                                                    class="text-danger">{{$message}} </span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group col-lg-6">
                                                                                <label>موبايل 2</label>
                                                                                <input type="number"
                                                                                       class="form-control form-control-solid"
                                                                                       name="phone2"
                                                                                       value="{{$client->phone2}}">
                                                                                @error('phone2')
                                                                                <span
                                                                                    class="text-danger">{{$message}} </span>
                                                                                @enderror
                                                                            </div>


                                                                            <div class="form-group col-lg-6">
                                                                                <label>المدينة</label>
                                                                                <select
                                                                                    class="form-control form-control-solid new_show_area"
                                                                                    id=""
                                                                                    name="new_show_area"
                                                                                    data-url="{{route('show.area.clients')}}">
                                                                                    <option value="">أختيار المدينة
                                                                                    </option>
                                                                                    @foreach($cities as $city)
                                                                                        <option value="{{$city->id}}"
                                                                                                @if($city->id == @$client->area->city_id) selected @endif>{{$city->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group col-lg-6">
                                                                                <label>المناطق</label>
                                                                                <select
                                                                                    class="form-control form-control-solid new_clients_areas"
                                                                                    name="area_id" id="">
                                                                                    @foreach($areas as $area)
                                                                                        <option value="{{$area->id}}"
                                                                                                @if($area->id == $client->area_id) selected @endif
                                                                                        >{{$area->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('area_id')
                                                                                <span
                                                                                    class="text-danger">{{$message}} </span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group col-lg-6">
                                                                                <label>العنوان</label>
                                                                                <input type="text"
                                                                                       class="form-control form-control-solid"
                                                                                       name="address"
                                                                                       value="{{$client->address}}">
                                                                                @error('address')
                                                                                <span
                                                                                    class="text-danger">{{$message}} </span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group col-lg-6">
                                                                                <label>القطعة</label>
                                                                                <input type="text"
                                                                                       class="form-control form-control-solid"
                                                                                       name="piece"
                                                                                       value="{{$client->piece}}">
                                                                                @error('piece')
                                                                                <span
                                                                                    class="text-danger">{{$message}} </span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group col-lg-6">
                                                                                <label>الشارع</label>
                                                                                <input type="text"
                                                                                       class="form-control form-control-solid"
                                                                                       name="street"
                                                                                       value="{{$client->street}}">
                                                                                @error('street')
                                                                                <span
                                                                                    class="text-danger">{{$message}} </span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group col-lg-6">
                                                                                <label>جادة</label>
                                                                                <input type="text"
                                                                                       class="form-control form-control-solid"
                                                                                       name="avenue"
                                                                                       value="{{$client->avenue}}">
                                                                                @error('avenue')
                                                                                <span
                                                                                    class="text-danger">{{$message}} </span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group col-lg-6">
                                                                                <label>رقم المنزل</label>
                                                                                <input type="text" min="0"
                                                                                       class="form-control form-control-solid"
                                                                                       name="house_number"
                                                                                       value="{{$client->house_number}}">
                                                                                @error('house_number')
                                                                                <span
                                                                                    class="text-danger">{{$message}} </span>
                                                                                @enderror
                                                                            </div>

                                                                        </div>

                                                                    </div>


                                                                    <div class="card-footer">
                                                                        <button type="submit"
                                                                                class="btn btn-primary mr-2">حفظ
                                                                        </button>
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">أغلاق
                                                                        </button>

                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="myModal-{{$client->id}}" tabindex="-1"
                                                     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">حذف
                                                                    العميل</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form role="form"
                                                                      action="{{route('clients.destroy', $client->id)}}"
                                                                      method="POST">
                                                                    <input name="_method" type="hidden" value="DELETE">
                                                                    {{ csrf_field() }}
                                                                    <p>هل انت متأكد ؟</p>
                                                                    <button type="submit" class="btn btn-danger"
                                                                            name='delete_modal'><i class="fa fa-trash"
                                                                                                   aria-hidden="true"></i>حذف
                                                                    </button>
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
                        <div
                            class="d-flex justify-content-center">{{ $clients->appends(request()->query())->links() }}</div>
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
@push('css')
    <link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush
@section('js')


    <script>
        $(document).ready(function () {
            let name_stage = $("#name_stage");
            name_stage.select2();
        });
    </script>


    @if(count($errors) > 0)
        <script>
            $(document).ready(function () {
                let modal_edit = $("#edit" + "{{old('client_id')}}");
                modal_edit.modal("show");

                let name = $('input[name="name"]');
                let username = $('input[name="username"]');
                let phone1 = $('input[name="phone1"]');
                let phone2 = $('input[name="phone2"]');
                let new_show_area = $('.new_show_area');
                let area_id = $('select[name="area_id"]');
                let address = $('input[name="address"]');
                let piece = $('input[name="piece"]');
                let street = $('input[name="street"]');
                let avenue = $('input[name="avenue"]');
                let house_number = $('input[name="house_number"]');

                name.val("{{old('name')}}");
                username.val("{{old('username')}}");
                phone1.val("{{old('phone1')}}");
                phone2.val("{{old('phone2')}}");
                new_show_area.val("{{old('new_show_area')}}");
                new_show_area.trigger('change');
                area_id.val("{{old('area_id')}}");
                area_id.trigger('change');
                address.val("{{old('address')}}");
                piece.val("{{old('piece')}}");
                street.val("{{old('street')}}");
                avenue.val("{{old('avenue')}}");
                house_number.val("{{old('house_number')}}");

            });
        </script>
    @endif
    {{--        @if($errors)--}}
    {{--            @dd($errors)--}}
    {{--        @endif--}}

@endsection
