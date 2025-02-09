@extends('User.partials.index')
@section('page-title', 'login')
@section('content')

        <div class="auth-wrapper">
            <div class="logo-wrapper">
                <img src="{{ asset('storage/'.$setting->site_logo) }}" alt="{{$setting->siteLogoAlt}}"/>
            </div>
            <div class="form-wrapper">
                <div class="login-form">
                    <div class="login-content">
                        <div class="title-holder">
                            <h1>@lang('home.SignIn')</h1>
                            <h3>@lang('home.uLogin')</h3>
                        </div>
                    </div>
                    <form action="{{route('website.login')}}" method="post" class="form-content needs-validation" novalidate>
                        @csrf
                        <div class="form-group">
                            <div class="input-holder">
                                <input required="" class="form-control m-input" id="validationTooltip02" type="email"
                                       placeholder="@lang('home.mailOrPhone')" name="email" value="{{old('email')}}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-holder">
                                <input id="validationTooltip02" required="" minlength="6" class="form-control m-input"
                                       type="password" placeholder="@lang('home.Rpassword')" name="password"
                                       value="{{old('password')}}">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="primary-dark-fill rounded submit-btn">@lang('home.SignIn')</button>
{{--                        <a class="forget-pass" href="">@lang('home.forgetP')</a>--}}
                        <div class="signup-link">
                            @lang('home.dontHaveAccount') <a href="{{route('website.signup')}}">@lang('home.signup')
                            <!-- <span>&#10151;</span> -->
                            </a>
                        </div>
                        <a class="primary-dark-fill facebook-link" href="{{route('redirect.facebook','facebook')}}">
                            <img src="{{asset('frontend_plugins/web/images/facebook.png')}}" alt=""/> @lang('home.facebookLogin')
                        </a>
                        <br>
                        <a class="primary-dark-fill facebook-link" href="{{route('redirect.facebook','google')}}">
                            <img src="{{asset('frontend_plugins/web/images/gmail.png')}}" alt=""/> @lang('home.gmailLogin')
                        </a>
                    </form>
                </div>
                <div class="login-form">
                    <div class="login-content">
                        <h1>@lang('home.SignIn')</h1>
                        <h3>@lang('home.cLogin')</h3>
                    </div>
                    <form action="{{route('company.login')}}" method="post" class="form-content needs-validation" novalidate>
                        @csrf
                        <div class="form-group">
                            <div class="input-holder">
                                <input required="" class="form-control m-input" id="validationTooltip02" type="email"
                                       placeholder="@lang('home.email')" name="email" value="{{old('email')}}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-holder">
                                <input id="validationTooltip02" required="" minlength="6" class="form-control m-input"
                                       type="password" placeholder="@lang('home.Rpassword')" name="password"
                                       value="{{old('password')}}">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="primary-dark-fill rounded submit-btn">@lang('home.SignIn')</button>
{{--                        <a class="forget-pass" href="">@lang('home.forgetP')</a>--}}
                        <div class="signup-link">
                            @lang('home.dontHaveAccount') <a href="{{route('joinus')}}">@lang('home.joinus')
                            <!-- <span>&#10151;</span> -->
                            </a>
                        </div>
<!--                         <a class="primary-dark-fill facebook-link" href="signupuser.html">
                            <img src="{{asset('frontend_plugins/web/images/facebook.png')}}" alt=""/> @lang('home.facebookLogin')</a> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            $(function () {
                // Example starter JavaScript for disabling form submissions if there are invalid fields
                (function () {
                    'use strict';
                    window.addEventListener('load', function () {
                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                        var forms = document.getElementsByClassName('needs-validation');
                        // Loop over them and prevent submission
                        var validation = Array.prototype.filter.call(forms, function (form) {
                            form.addEventListener('submit', function (event) {
                                if (form.checkValidity() === false) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                }
                                form.classList.add('was-validated');
                            }, false);
                        });
                    }, false);
                })();
            });
        </script>
    @endpush
@endsection
