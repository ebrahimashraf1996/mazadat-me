<!--begin::Footer-->
<div class="footer bg-white py-4 d-flex flex-lg-column none-print" id="kt_footer">
    <!--begin::Container-->
    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-2">2023©</span>
            <a href="#" target="_blank" class="text-dark-75 text-hover-primary">Mazadat</a>
        </div>
        <!--end::Copyright-->
    </div>
    <!--end::Container-->
</div>
<!--end::Footer-->
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::Main-->

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop">
    <span class="svg-icon">
        <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24" />
                <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
            </g>
        </svg>
        <!--end::Svg Icon-->
    </span>
</div>
<!--end::Scrolltop-->


<!--end::Demo Panel-->
<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576
            , "md": 768
            , "lg": 992
            , "xl": 1200
            , "xxl": 1400
        }
        , "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff"
                    , "primary": "#3699FF"
                    , "secondary": "#E5EAEE"
                    , "success": "#1BC5BD"
                    , "info": "#8950FC"
                    , "warning": "#FFA800"
                    , "danger": "#F64E60"
                    , "light": "#E4E6EF"
                    , "dark": "#181C32"
                }
                , "light": {
                    "white": "#ffffff"
                    , "primary": "#E1F0FF"
                    , "secondary": "#EBEDF3"
                    , "success": "#C9F7F5"
                    , "info": "#EEE5FF"
                    , "warning": "#FFF4DE"
                    , "danger": "#FFE2E5"
                    , "light": "#F3F6F9"
                    , "dark": "#D6D6E0"
                }
                , "inverse": {
                    "white": "#ffffff"
                    , "primary": "#ffffff"
                    , "secondary": "#3F4254"
                    , "success": "#ffffff"
                    , "info": "#ffffff"
                    , "warning": "#ffffff"
                    , "danger": "#ffffff"
                    , "light": "#464E5F"
                    , "dark": "#ffffff"
                }
            }
            , "gray": {
                "gray-100": "#F3F6F9"
                , "gray-200": "#EBEDF3"
                , "gray-300": "#E4E6EF"
                , "gray-400": "#D1D3E0"
                , "gray-500": "#B5B5C3"
                , "gray-600": "#7E8299"
                , "gray-700": "#5E6278"
                , "gray-800": "#3F4254"
                , "gray-900": "#181C32"
            }
        }
        , "font-family": "Poppins"
    };

</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/crud/ktdatatable/advanced/record-selection.js')}}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{asset('assets/js/pages/widgets.js')}}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"> </script> --}}
<!-- <scritp src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"> </script>
		<scritp src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"> </script>
		<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script> -->
<!-- <scritp src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"> </script>
		<scritp src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"> </script>
		<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script> -->
<script src="{{asset('assets/js/pages/crud/forms/widgets/bootstrap-timepicker.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/js/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/js/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/js/buttons.print.min.js')}}"></script>
<script>
    $(document).ready(function() {

        $('#example').DataTable({
            ordering: true
            , dom: 'Bfrtip'
            , buttons: [{
                    extend: 'csv'
                    , charset: 'UTF-8'
                    , fieldSeparator: ';'
                    , bom: true
                    , filename: 'Mazadatي'
                    , title: '<img src="{{asset($setting->logo)}}">'
                }
                , {
                    extend: 'pdfHtml5'
                    , charset: 'UTF-8'
                    , fieldSeparator: ';'
                    , bom: true
                    , filename: 'Mazadatي'
                    , title: 'Mazadatي'
                    , exportOptions: {
                        columns: ':visible'
                    }
                }
                , {
                    extend: 'print'
                    , charset: 'UTF-8'
                    , fieldSeparator: ';'
                    , bom: true
                    , filename: 'Mazadatي'
                    , title: '<img src="{{asset($setting->logo)}}">'
                    , exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'excel'
                    , charset: 'UTF-8'
                    , fieldSeparator: ';'
                    , bom: true
                    , filename: 'Mazadat'
                    , title: '<img src="{{asset($setting->logo)}}">'
                    , exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'copy'
                    , charset: 'UTF-8'
                    , fieldSeparator: ';'
                    , bom: true
                    , filename: 'Mazadatي'
                    , title: '<img src="{{asset($setting->logo)}}">'
                }
                , 'colvis'

            ]
        });




    });

</script>

<!--end::Page Scripts-->
<script src="{{asset('assets/js/choices.min.js')}}"></script>

{{-- <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script> --}}

<script src="{{asset('assets/js/bootstrap4select.js')}}"></script>

<!-- Latest compiled and minified JavaScript -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> --}}

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
<script src="//cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>
<script>
    $(function() {
        $('.mini-editor').each(function(e) {
            CKEDITOR.replace(this.id, {
                // Define the toolbar groups as it is a more accessible solution.
                toolbarGroups: [
                    {
                        "name": "basicstyles"
                        , "groups": ['basicstyles']
                    }
                    ,{
                        "name": "styles"
                        , "groups": ["styles"]
                    }
                    , {
                        "name": 'colors'
                        , "groups": ['TextColor', 'BGColor']
                    }
                    , {
                        "name": 'paragraph'
                        , "groups": ['list', 'blocks']
                    },
                ]
                , contentsCss: '{{ asset("front_assets/css/font.css") }}'
                , font_names: 'advertisingBold;' +
                    'advertisingExtraBold;' +
                    'advertisingLight;' +
                    'advertisingMedium;' +
                    'Mohand;' +
                    'MohandBold;' +
                    CKEDITOR.config.font_names,
                // Remove the redundant buttons from toolbar groups defined above.
                removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
            });
        });

        $('.full-editor').each(function(e) {
            CKEDITOR.replace(this.id, {
                // Define the toolbar groups as it is a more accessible solution.
                toolbarGroups: [
                    { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                    { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
                    { name: 'forms' },
                    '/',
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                    { name: 'links' },
                    { name: 'insert' },
                    '/',
                    { name: 'styles' },
                    { name: 'colors' },
                    { name: 'tools' },
                    { name: 'others' },
                    { name: 'about' }
                ]
                , contentsCss: '{{ asset("front_assets/css/font.css") }}'
                , font_names: 'advertisingBold;' +
                    'advertisingExtraBold;' +
                    'advertisingLight;' +
                    'advertisingMedium;' +
                    'Mohand;' +
                    'MohandBold;' +
                    CKEDITOR.config.font_names,
                // Remove the redundant buttons from toolbar groups defined above.
                removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
            });
        });

        $('textarea[name="note"]').each(function(e) {
            CKEDITOR.replace(this.id, {
                // Define the toolbar groups as it is a more accessible solution.
                toolbarGroups: [
                    { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                    { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
                    { name: 'forms' },
                    '/',
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                    { name: 'links' },
                    { name: 'insert' },
                    '/',
                    { name: 'styles' },
                    { name: 'colors' },
                    { name: 'tools' },
                    { name: 'others' },
                    { name: 'about' }
                ]
                , contentsCss: '{{ asset("front_assets/css/font.css") }}'
                , font_names: 'advertisingBold;' +
                    'advertisingExtraBold;' +
                    'advertisingLight;' +
                    'advertisingMedium;' +
                    'Mohand;' +
                    'MohandBold;' +
                    CKEDITOR.config.font_names,
                // Remove the redundant buttons from toolbar groups defined above.
                removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
            });
        });
    });
    $.fn.modal.Constructor.prototype._enforceFocus = function() {
        modal_this = this
        $(document).on('focusin', function (e) {
            if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
                && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select')
                && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
                modal_this.$element.focus()
            }
        })
    };
</script>
<script src="{{asset('assets/js/site_script.js')}}"></script>
@yield('js')

</body>
<!--end::Body-->
</html>
