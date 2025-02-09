<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->

<head>
    <meta charset="utf-8" />
    <title>{{ config('global.used_app_name', 'Tawredaat') }} | Register as vendor</title>
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
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3 "
            id="m_login"
            style="background-image: url({{ url('/') }}/frontend_plugins/assets/app/media/img//bg/bg-7.jpg);">
            <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
                <div class="m-login__container " style="width:630px; 
                padding: 1rem 1rem">
                    <div class="m-login__logo">
                        <a style="color: #fff">
                            <h1>{{ config('global.used_app_name', 'Tawredaat') }}</h1>
                            <img style="display: none"
                                src="{{ url('/') }}/frontend_plugins/assets/app/media/img/logos/logo-1.png">
                        </a>
                    </div>
                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">Sign Up As A Vendor</h3>
                        </div>
                        <form action="{{ route('vendor.register') }}" method="post" id="login-form-admin"
                            class="m-login__form m-form" enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <div class="col-md-12">
                                    {{-- <label>Company Name</label> --}}
                                    <div class="form-group m-form__group ">
                                        <input required="" class="form-control m-input" type="text"
                                            placeholder="Company Name" name="company_name"
                                            value="{{ old('company_name') }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    {{-- <label>Responsible Person Name</label> --}}
                                    <div class="form-group m-form__group">
                                        {{-- <label>Responsible Person Name</label> --}}
                                        <input required="" class="form-control m-input" type="text"
                                            placeholder="Responsible Person Name" name="responsible_person_name"
                                            value="{{ old('responsible_person_name') }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    {{-- <label>Responsible Person Mobile Number</label> --}}
                                    <div class="form-group m-form__group">
                                        <input required="" class="form-control m-input" type="text" maxlength="15"
                                            placeholder="Responsible Mobile Number"
                                            name="responsible_person_mobile_number"
                                            value="{{ old('responsible_person_mobile_number') }}">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group m-form__group">
                                        <input required="" class="form-control m-input" type="email"
                                            placeholder="Responsible Person Email" name="responsible_person_email"
                                            value="{{ old('responsible_person_email') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group m-form__group">
                                        <input required="" class="form-control m-input m-login__form-input--last"
                                            type="password" placeholder="Password" name="password">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group m-form__group">
                                        <select name="company_type" required class="form-control m-input"
                                            style="width: 100%;padding:1.0rem 1.5rem 1.0rem 1.0rem;                                             ">

                                            <option @if (old('privilege') == 'contractor') selected @endif
                                                value="contractor">
                                                Contractor</option>
                                            <option @if (old('privilege') == 'seller') selected @endif value="seller">
                                                Seller

                                            </option>

                                            <option @if (old('privilege') == 'electrician') selected @endif
                                                value="electrician">
                                                Electrician
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12  upload-document">
                                    <label>Logo</label>
                                    <div class="form-group m-form__group">
                                        {{-- <input type="file" name="pdf" class="form-control m-input"> --}}
                                        <input required type="file" required name="logo" accept=".png,.jpg">
                                    </div>
                                    <label class="muted">PNG, or JPG</label>
                                </div>


                                <div class="col-md-12 upload-document">
                                    <label>Commercial License</label>
                                    <div class="form-group m-form__group">
                                        {{-- <input type="file" name="pdf" class="form-control m-input"> --}}
                                        <input required type="file" name="commercial_license"
                                            accept=".png,.jpg,.pdf">
                                    </div>
                                    <label class="muted">PDF, PNG, or JPG</label>
                                </div>

                                <div class="col-md-12 upload-document">
                                    <label>Tax Number Certificate</label>
                                    <div class="form-group m-form__group">
                                        <input required="" type="file" accept=".png,.jpg,.pdf"
                                            name="tax_number_certificate">
                                    </div>
                                    <label class="muted">PDF, PNG, or JPG</label>
                                </div>

                                <div class="col-md-12 upload-document">
                                    <label>Added Value Certificate</label>
                                    <div class="form-group m-form__group">
                                        <input type="file" accept=".png,.jpg,.pdf" name="added_value_certificate">
                                    </div>
                                    <label class="muted">PDF, PNG, or JPG</label>
                                </div>

                                <div class="col-md-12 upload-document">
                                    <label>Contractors Association Certificate</label>
                                    <div class="form-group m-form__group">
                                        <input type="file"
                                            accept=".png,.jpg,.pdf"name="contractors_association_certificate">
                                    </div>
                                    <label class="muted">PDF, PNG, or JPG</label>
                                </div>

                            </div>

                            <div class="m-login__form-action">
                                <button id="m_login_signin_submit"
                                    class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn"
                                    type="submit">Sign Up</button>
                            </div>

                            <div class="row m-login__form-sub">
                                <div class="col m--align-left m-login__form-left">

                                    <a href="{{ route('vendor.login') }}"> Have an account, Login!
                                    </a>

                                </div>
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
