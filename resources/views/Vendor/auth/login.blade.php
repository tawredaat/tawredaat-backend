<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->

<head>
    <meta charset="utf-8" />
    <title>{{ config('global.used_app_name', 'Tawredaat') }} | Login as vendor</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
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

    <!--end::Global Theme Styles -->
    <link rel="shortcut icon"
        href="{{ asset('frontend_plugins/assets/app/media/img/cropped-FavIcon-Tawredaat.jpeg') }} " />
</head>

<!-- end::Head -->

<!-- begin::Body -->

<body
    class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled 
    m-aside-left--skin-dark 
    m-aside-left--fixed m-aside-left--offcanvas m-footer--push
     m-aside--offcanvas-default ">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page  ">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3 
        "
            id="m_login"
            style="background-image: url({{ url('/') }}/frontend_plugins/assets/app/media/img//bg/bg-7.jpg);">
            <div class="m-grid__item m-grid__item--fluid  m-login__wrapper ">
                <div class="m-login__container">
                    <div class="m-login__logo">
                        <a style="color: #fff">
                            <h1>{{ config('global.used_app_name', 'Tawredaat') }}</h1>
                            <img style="display: none"
                                src="{{ url('/') }}/frontend_plugins/assets/app/media/img/logos/logo-1.png">
                        </a>
                    </div>
                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">Sign In As A Vendor</h3>
                        </div>
                        <form action="{{ route('vendor.login') }}" method="post" id="login-form-admin"
                            class="m-login__form m-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group m-form__group">
                                        <input required="" class="form-control m-input" type="email"
                                            placeholder="Email" name="email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group m-form__group">
                                        <input required="" class="form-control m-input m-login__form-input--last"
                                            type="password" placeholder="Password" name="password">
                                    </div>
                                    <div class="row m-login__form-sub">
                                        <div class="col m--align-left m-login__form-left">

                                            <a href="{{ route('vendor.register') }}"> Register Now!
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-login__form-action">
                                <button id="m_login_signin_submit"
                                    class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn"
                                    type="submit">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Page -->

    <!--begin::Global Theme Bundle -->
    <script src="{{ url('/') }}/frontend_plugins/assets/vendors/base/vendors.bundle.js" type="text/javascript">
    </script>
    <script src="{{ url('/') }}/frontend_plugins/assets/demo/default/base/scripts.bundle.js" type="text/javascript">
    </script>

    <!--end::Global Theme Bundle -->

    <!--begin::Page Scripts -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @include('Vendor.layout.messages')
    <!--end::Page Scripts -->
</body>

<!-- end::Body -->

</html>
