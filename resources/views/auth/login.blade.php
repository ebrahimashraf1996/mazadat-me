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
    <style>
        body {
            font-family: cairo, Cambria, Cochin, Georgia, Times, 'Times New Roman', serif
        }

        .login-aside .overlay {
            background: rgba(255, 255, 255, .5);
            width: 100%;
            height: 100%
        }

    </style>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    @include('sweet::alert')
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root" style="background-image: url({{asset('assets/media/bg/mazad_pg.jpg')}});background-repeat: no-repeat;
    background-size: cover;">
        <!--begin::Login-->
        <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid " id="kt_login">
            <!--begin::Content-->
            <div class="login-content  d-flex flex-column justify-content-center position-relative overflow-hidden p-7 m-auto">
                <!--begin::Content body-->
                <div class="d-flex flex-column-fluid flex-center">
                    <!--begin::Signin-->
                    <div class="login-form login-signin">
                        <!--begin::Form-->
                        <form class="form custom_style_form" novalidate="novalidate" action="{{route('login.auth')}}" method="POST">
                            @csrf
                            <!--begin::Form group-->
                            <div class="form-group">
                                <label class="font-size-h4 font-weight-bolder text-light">البريد الألكتروني</label>
                                <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="text" name="email" autocomplete="off" require="required">
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                {{-- <div class="d-flex justify-content-between mt-n5"> --}}
                                <label class="font-size-h4 font-weight-bolder text-light pt-5"> كلمة السر</label>
                                <!--<a href="javascript:;" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">نسيت كلمة السر</a>-->
                                {{-- </div> --}}
                                <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="password" name="password" autocomplete="off" require="required">
                            </div>
                            <input type="hidden" name="type" value="{{ $type }}">
                            <!--end::Form group-->
                            <!--begin::Action-->
                            <div class="pb-lg-0 pb-5">
                                <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6">تسجيل دخول</button>
                                <!--end::Action-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Signin-->

                    <!--begin::Forgot-->
                    <div class="login-form login-forgot">
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate" id="kt_login_forgot_form">
                            <!--begin::Title-->
                            <div class="pb-13 pt-lg-0 pt-5">
                                <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Forgotten Password ?</h3>
                                <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
                            </div>
                            <!--end::Title-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off" />
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group d-flex flex-wrap pb-lg-0">
                                <button type="button" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Submit</button>
                                <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</button>
                            </div>
                            <!--end::Form group-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Forgot-->

                </div>
                <!--end::Content body-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->


    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
    <script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('assets/js/pages/custom/login/login-general.js')}}"></script>
    <!--end::Page Scripts-->

</body>
<!--end::Body-->
</html>
