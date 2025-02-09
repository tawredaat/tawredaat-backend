<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->

<head>
    <meta charset="utf-8" />
    <title>{{ config('global.used_app_name', 'Tawredaat') }} | Login as admin</title>
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

<body>

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="my-auto m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3 d-flex justify-content-center align-items-center"
            id="m_login"
            style="background-color: #ededed">

            <div class="container w-50 shadow-lg">
                <div class="row">
                    <div class="col-4 bg-white">
                        <div style="height: 100%; display: flex; align-items: center; justify-content: center">
                            <img width="100%" src="{{ asset('storage/siteSettings/tawredaat-logo1956508523.png') }}">
                        </div>
                    </div>
                    <div class="col-8 bg-white">
                        <div class="my-5">
                            <h2 class="my-3">Admin Login</h2>
    
                            <form action="{{ route('admin.login') }}" method="post" id="login-form-admin"
                                class="m-login__form m-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 my-3">
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
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="rememberme"> Remember me
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-login__form-action my-3">
                                    <button id="m_login_signin_submit"
                                    style="background-color: #f15956; color: white;"
                                        class="w-100 btn m-btn m-btn--custom m-btn--air m-login__btn"
                                        type="submit">Sign In</button>
                                </div>
                            </form>
                        </div>
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
    @include('Admin.layout.messages')
    <!--end::Page Scripts -->   
</body>

<!-- end::Body -->

</html>
