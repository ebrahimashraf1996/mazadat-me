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
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h2> الأعدادات </h2>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Search Form-->
                    <!--begin::Search Form-->
                    <div class="mb-12">
                        <div class="table-responsive">
                          <table class="table table-bordered text-center" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>اسم السيستم</th>
                              <th>اللوجو</th>
                              <th>الوصف</th>
                              <th> رسوم التوصيل</th>
                              <th>الأعدادات</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td style="line-height:4;font-size:20px;font-weight:bolder">{{$setting->name}}</td>
                              <td>
                                @if($setting->logo != null)
                                <img src="{{asset('/'.$setting->logo)}}">
                                @else
                                <span style="color:red;line-height:4;font-size:20px;font-weight:bolder">لا يوجد صورة</span>
                                @endif
                              </td>
                              <td style="line-height:4;font-size:20px;font-weight:bolder">{{$setting->desc?:'لم يحدد'}}</td>
                              <td style="line-height:4;font-size:20px;font-weight:bolder">{{$setting->amount_invoice}}</td>
                              <td>
                                <button style="line-height:4;font-size:20px;font-weight:bolder" class="btn btn-brand dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                    									aria-haspopup="true" aria-expanded="true">الاعدادات</button>
                    									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    										  <a class="dropdown-item" href="{{route('settings.edit', $setting->id)}}"><i class="fa fa-edit"></i> تعديل</a>
                    									</div>
                              </td>
                            </tr>
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
