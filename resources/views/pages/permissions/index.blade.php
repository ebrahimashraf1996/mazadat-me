@extends('layouts.app')
@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
            <h3 class="card-label alert alert-success text-center">الصلاحيات </h3>
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <a href="{{route('permissions.create')}}"class="btn btn-primary title-page">  أضافة صلاحية</a>
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
                              <th>الصلاحية</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
                            <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$permission->name}}</td>
                             
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
