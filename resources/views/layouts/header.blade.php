<!DOCTYPE html>

<html direction="rtl" dir="rtl" style="direction: rtl" lang="ar">
<!--begin::Head-->
<head>
    <base href="">
    <meta charset="UTF-8">
    <title>Mazadat | @stack('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300&display=swap" rel="stylesheet">
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
{{--    <link href="{{asset('assets/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{asset('assets/plugins/custom/prismjs/prismjs.bundlertl.css')}}" rel="stylesheet" type="text/css" />--}}
    <link href="{{asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{asset('assets/css/themes/layout/header/base/light.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/themes/layout/header/menu/light.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/themes/layout/brand/dark.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/themes/layout/aside/dark.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/site_style.css')}}" rel="stylesheet" type="text/css" />

    <!--end::Layout Themes-->
    <link href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" integrity="sha512-BnbUDfEUfV0Slx6TunuB042k9tuKe3xrD6q4mg5Ed72LTgzDIcLPxg6yI2gcMFRyomt+yJJxE+zJwNmxki6/RA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/fontawesome.min.css" integrity="sha512-U/gkPvaqpUI9k7UC1ivfLUO+hb1dPzQyWskzeYoDjZENrWvLVZ40mg510RvWsVP3YcuKW4lAkfxgU9khbNhTrg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @if(Request::route()->getName() == 'auction-products.index')
        <style>
            #kt_footer {
                display: none !important
            }
        </style>
    @endif
    <!-- Bootstrap core CSS -->
    <script src="{{asset('assets/js/sweetalert.js')}}"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css"> --}}
    <link rel="stylesheet" href="{{asset('assets/css/choices.css')}}">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap4.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css" integrity="sha512-P9vJUXK+LyvAzj8otTOKzdfF1F3UYVl13+F8Fof8/2QNb8Twd6Vb+VD52I7+87tex9UXxnzPgWA3rH96RExA7A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Include this in your blade layout -->

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap4select.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">

    <!-- Latest compiled and minified CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> --}}

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap4.css')}}">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    @stack('css')
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
{{--    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>--}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading" direction="rtl" dir="rtl" style="direction: rtl;overflow-x:hidden">
    @include('sweet::alert')
    <!--begin::Main-->
    <!--begin::Header Mobile-->
    <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
        <!--begin::Logo-->
        <a href="{{route('admin.dashboard')}}">
            <img alt="Logo" src="{{asset('/'.$setting->logo)}}">
        </a>
        <!--end::Logo-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Aside Mobile Toggle-->
            <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                <span></span>
            </button>
            <!--end::Aside Mobile Toggle-->
            <!--begin::Header Menu Mobile Toggle-->
            <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
                <span></span>
            </button>
            <!--end::Header Menu Mobile Toggle-->
            <!--begin::Topbar Mobile Toggle-->
            <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                <span class="svg-icon svg-icon-xl">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </button>
            <!--end::Topbar Mobile Toggle-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->

    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
