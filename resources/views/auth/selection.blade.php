<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 11 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->
<head>
    <base href="../../../">
    <meta charset="utf-8" />
    <title> Mazadat </title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{asset('assets/css/pages/login/login-1.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{asset('assets/css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/themes/layout/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/themes/layout/brand/dark.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
    <!-- Include this in your blade layout -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root" style="background-image: url({{asset('assets/media/bg/mazad_pg.jpg')}});background-repeat: no-repeat;
        background-size: cover;">
        <!--begin::Login-->
        <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid " id="kt_login">
            <!--begin::Content-->
            <div class="login-content  d-flex flex-column justify-content-center position-relative overflow-hidden p-7 m-auto"
            style="max-width: 600px;">

                <!--begin::Content body-->
                    <div class="d-flex flex-column-fluid flex-center selection_buttons">

                        <a class="col-md-4 col select_circle" href="{{ route('login','admin') }}"> ادمن </a>

                        <a class="col-md-4 col select_circle" href="{{ route('login','auction') }}">  مزاد </a>

                        <a class="col-md-4 col select_circle" href="{{ route('login','delivery') }}">  مندوب </a>

                    </div>
                <!--end::Signin-->

                <!--end::Content body-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->
</body>
<!--end::Body-->
</html>
