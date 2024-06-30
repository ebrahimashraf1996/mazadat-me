@include('layouts.header')
@include('layouts.nav')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    @yield('content')
</div>
<!--end::Content-->
@include('layouts.footer')