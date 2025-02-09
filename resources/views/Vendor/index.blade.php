<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->

<head>
    <meta charset="utf-8" />
    <title>Vendor|@yield('page-title')</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1d94c4">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Global Theme Styles -->
    <link href="{{ url('/') }}/frontend_plugins/assets/vendors/base/vendors.bundle.css" rel="stylesheet"
        type="text/css" />
    <!--RTL version:<link href="{{ url('/') }}/frontend_plugins/assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link href="{{ url('/') }}/frontend_plugins/assets/demo/default/base/style.bundle.css" rel="stylesheet"
        type="text/css" />
    <!--RTL version:<link href="{{ url('/') }}/frontend_plugins/assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--end::Global Theme Styles -->
    <link href="{{ url('/') }}/frontend_plugins/assets/vendors/custom/datatables/datatables.bundle.css"
        rel="stylesheet" type="text/css" />
    <!--begin::Page Vendors Styles -->
    <link href="{{ url('/') }}/frontend_plugins/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/frontend_plugins/assets/select2.min.css" rel="stylesheet" type="text/css" />
    <!--RTL version:<link href="{{ url('/') }}/frontend_plugins/assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <!--end::Page Vendors Styles -->
    <link rel="shortcut icon"
        href="{{ asset('frontend_plugins/assets/app/media/img/cropped-FavIcon-Tawredaat.jpeg') }} " />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend_plugins/css/bootstrap-tagsinput.css') }}">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" rel="stylesheet">

    @stack('style')
</head>
<!-- end::Head -->
<!-- begin::Body -->

<body
    class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        @include('Vendor.layout.header')
        @include('Vendor.layout.sidebar')
        @yield('content')
        @include('Vendor.layout.footer')
    </div>
    <!-- end::Scroll Top -->
    <!--begin::Global Theme Bundle -->
    <script src="{{ url('/') }}/frontend_plugins/assets/vendors/base/vendors.bundle.js" type="text/javascript">
    </script>
    <script src="{{ url('/') }}/frontend_plugins/assets/demo/default/base/scripts.bundle.js" type="text/javascript">
    </script>
    <!--end::Global Theme Bundle -->
    <!--begin::Page Vendors -->
    <script src="{{ url('/') }}/frontend_plugins/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js"
        type="text/javascript"></script>
    <!--end::Page Vendors -->
    <!--begin::Page Scripts -->
    <script src="{{ url('/') }}/frontend_plugins/assets/app/js/dashboard.js" type="text/javascript"></script>
    <!--begin::Page Vendors -->
    <script src="{{ url('/') }}/frontend_plugins/assets/vendors/custom/datatables/datatables.bundle.js"
        type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!--end::Page Vendors -->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <!--begin::Page Scripts -->
    <script src="{{ url('/') }}/frontend_plugins/assets/demo/default/custom/crud/datatables/advanced/row-callback.js"
        type="text/javascript"></script>
    <script src="{{ url('/') }}/frontend_plugins/assets/select2.min.js" type="text/javascript"></script>
    <script src="{{ url('/') }}/frontend_plugins/assets/sweetalert.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
    <script type="text/javascript" src="{{ asset('frontend_plugins/js/bootstrap-tagsinput.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
    <link rel="stylesheet" href="{{ asset('css/more_styling.css') }}">
    @stack('script')
    @include('Vendor.layout.messages')
</body>
<!-- end::Body -->

</html>
