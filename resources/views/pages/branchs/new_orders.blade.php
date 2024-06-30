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
                  <a href="{{route('branchs.index')}}" class="btn btn-success">الفروع</a>
                  <h3 class="card-label" style="float:left"> الطلبيات الجديدة </h3>
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
                              <th> اسم الطلبية</th>
                              <th>اسم الفرع</th>
                              <th>الأعدادات</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($new_orders as $order)
                            <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{@$order->name}}</td>
                              <td>{{@$order->branch->name}}</td>
                              <td> 	<a class="btn btn-primary" href="{{route('orders.show', $order->id)}}"><i class="fa fa-edit"></i>منتجات الطلبية</a></td>
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
