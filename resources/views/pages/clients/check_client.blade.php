
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
	<head><base href="../../../">
		<meta charset="utf-8" />
		<title> Mazadat </title>
		<meta name="description" content="Login page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="https://keenthemes.com/metronic" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->

		<!--end::Page Custom Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="{{asset('/')}}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{asset('/')}}/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{asset('/')}}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="{{asset('/')}}/assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="{{asset('/')}}/assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="{{asset('/')}}/assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="{{asset('/')}}/assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="{{asset('/')}}/assets/media/logos/favicon.ico" />
    <!-- Include this in your blade layout -->
	 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	 <style>
         form{background: #222;width:70%;margin:0 auto;padding: 20px}
         form label{font-size: 18px !important;color:#fff !important}
	 </style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    @include('sweet::alert')
    <!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
				<!--begin::Content-->
				<div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
					<!--begin::Content body-->
					<div class="d-flex flex-column-fluid flex-center">
						<!--begin::Signin-->
						<div class="login-form login-signin" style="width: 100%">
							<!--begin::Form-->
							<form class="form text-right" action="{{route('store.check.client')}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row"> 

                                        <div class="col-12">
                                            <h2 class="text-center alert alert-success"> بيانات الأعتماد</h2>
                                            <hr>
                                        </div>
                                        {{--  
                                        <div class="form-group col-lg-6">
                                            <label>اسم المستخدم / Nickname</label>
                                            <input type="text" class="form-control form-control-solid" name="name" required >
                                            @error('name')
                                                <span class="text-danger">{{$message}} </span>
                                            @enderror
                                        </div>
                                        --}}
                                        
                                        <div class="form-group col-lg-6">
                                            <label>موبايل 1</label>
                                            <input type="number" class="form-control form-control-solid" name="phone1" min="0" required>
                                            @error('phone1')
                                                <span class="text-danger">{{$message}} </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>اسم المستخدم / Nickname</label>
                                            <input type="text" class="form-control form-control-solid" name="username" required>
                                            @error('username')
                                                <span class="text-danger">{{$message}} </span>
                                            @enderror
                                        </div>
                
                                        <div class="form-group col-lg-6">
                                            <label>المدينة \ المحافظة</label>
                                            <select class="form-control form-control-solid" id="show_area" data-url="{{route('show.area.clients')}}" required >
                                                <option value="">المدينة \ المحافظة</option>
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>المنطقة</label>
                                            <select class="form-control form-control-solid" name="area_id" id="clients_areas"></select>
                                            @error('area_id')
                                                <span class="text-danger">{{$message}} </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>القطعة</label>
                                            <input type="text" class="form-control form-control-solid" name="piece">
                                            @error('piece')
                                                <span class="text-danger">{{$message}} </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>الشارع</label>
                                            <input type="text" class="form-control form-control-solid" name="street">
                                            @error('street')
                                                <span class="text-danger">{{$message}} </span>
                                            @enderror
                                        </div>

                                        
                                        <div class="form-group col-lg-6">
                                            <label>جادة</label>
                                            <input type="text" class="form-control form-control-solid" name="avenue">
                                            @error('avenue')
                                                <span class="text-danger">{{$message}} </span>
                                            @enderror
                                        </div>
                                       
                                        <div class="form-group col-lg-6">
                                            <label>رقم المنزل</label> 
                                            <input type="number" min="0" class="form-control form-control-solid" name="house_number">
                                            @error('house_number')
                                                <span class="text-danger">{{$message}} </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-6"></div>
                                        
                                        <div class="form-group col-lg-6">
                                            <label>كود المزاد</label>
                                            <input type="text" class="form-control form-control-solid" name="code" required>
                                            @error('code')
                                                <span class="text-danger">{{$message}} </span>
                                            @enderror
                                        </div>

                                        {{--  

                                        <div class="form-group col-lg-6">
                                            <label>العنوان</label>
                                            <input type="text" class="form-control form-control-solid" name="address">
                                            @error('address')
                                                <span class="text-danger">{{$message}} </span>
                                            @enderror
                                        </div>

                                       
                                        <div class="form-group col-lg-6">
                                            <label>ملاحظة</label>
                                            <input type="text" class="form-control form-control-solid" name="note">
                                            @error('note')
                                                <span class="text-danger">{{$message}} </span>
                                            @enderror
                                        </div>
                                        --}}
                                       
                                    </div>
                
                                </div>
                
                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" style="font-size:20px">تسجيل</button>
                                </div>
                            </form>
						</div>
						<!--end::Signin-->
					</div>
					<!--end::Content body-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
        <script
	  src="https://code.jquery.com/jquery-3.6.0.min.js"
	  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
	  crossorigin="anonymous"></script>
		<script src="{{asset('/')}}/assets/plugins/global/plugins.bundle.js"></script>
		<script src="{{asset('/')}}/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="{{asset('/')}}/assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="{{asset('/')}}/assets/js/pages/custom/login/login-general.js"></script>
        <script>
            $(function(){
                $('#show_area').change(function () {
                    $url = $(this).attr('data-url');
                    $city_id = $(this).find("option:selected").val();

                    $.ajax({
                    url:$url,
                    type:"GET",
                    dataType:"JSON",
                    data:{city_id:$city_id},
                    success:function(data){
                        $('#clients_areas').html(data.areas);
                    }
                    });
                });
            });
        </script>
		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>