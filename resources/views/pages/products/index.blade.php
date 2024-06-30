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
                    <h3 class="card-label alert alert-success text-center"> المنتجات </h3>
                    <div class="card-title">
                        @if(Auth::user()->hasDirectPermission('اضافة منتجات'))
                        <a href="{{route('products.create')}}" class="btn btn-primary">أضافة منتج</a>
                        @endif
                    </div>
                    <div class="card-title">
                        <form action="#" method="GET">
                            <label> Search : </label>
                            <input type="text" class="control-form" name="name_product" value="{{ request()->name_product }}">
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
                                        <th>اسم المنتج</th>
                                        <th>الكمية</th>
                                        <th>اجمالي المسحوب</th>
                                        <th>السعر</th>
                                        <th>الصورة</th>
                                        <th>ملاحظات</th>
                                        <th>الأعدادات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$product->name?:'لم يحدد'}}</td>
                                        <td>{{$product->qty?:'لم يحدد'}}</td>
                                        <td>
                                            {{ $product->auction_products_sum_count_pieces ?? '0'}}
                                        </td>
                                        <td>{{$product->price?:'لم يحدد'}}</td>
                                        <td>
                                            @if($product->image != null)
                                              <img src="{{asset($product->image)}}" width="50px" height="50px">
                                            @else
                                              لم يحدد
                                            @endif
                                        </td>
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
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">الاعدادات <i class="fas fa-caret-down"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if(Auth::user()->hasDirectPermission('تعديل منتجات'))
                                                <a class="btn btn-success" href="{{route('products.edit', $product->id)}}"><i class="fa fa-edit"></i> تعديل</a>
                                                @endif

                                                @if(Auth::user()->hasDirectPermission('حذف منتجات'))
                                                <a class="btn btn-danger" data-toggle="modal" href="#myModal-{{$product->id}}"><i class="fa fa-trash"></i> حذف</a>
                                                @endif
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
                                                            <form role="form" class="form_delete" action="{{route('products.destroy', $product->id)}}" method="POST">
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
                    <div class="d-flex justify-content-center">{{ $products->appends(request()->query())->links() }}</div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
    @endsection
