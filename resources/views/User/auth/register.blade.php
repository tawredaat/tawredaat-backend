@extends('User.partials.index')
@section('page-title', 'register')
@section('content')
        <div class="signup-wrapper">
            <a href="{{route('user.home')}}" class="logo-holder mb-20">
                <img src="{{ asset('storage/'.$setting->site_logo) }}" alt="{{$setting->siteLogoAlt}}"/>
            </a>
            <div class="form-wrapper">
                <div class="signup-form">
                    <form action="{{route('website.register')}}" class="needs-validation" novalidate method="post" enctype="multipart/form-data">
                        @csrf
                        <h1>@lang('home.createAccount')</h1>
                        <input type="hidden" name="interest_id[]" value="">
                        <div class="form-elements-holder">
                        <div class="form-element">
                        <div class="form-group">
                            <div class="input-holder">
                                <label for="validationTooltip01">@lang('home.yourName')</label>
                                <input required="" id="validationTooltip01" class="form-control m-input" type="text" placeholder="@lang('home.name')" name="name" value="{{old('name')}}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-holder">
                                <label for="validationTooltip02">@lang('home.yourEmail')</label>
                                <input required="" id="validationTooltip02" class="form-control m-input" type="email" placeholder="@lang('home.email')" name="email" value="{{old('email')}}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group password-input">
                            <div class="input-holder">
                                <label for="validationTooltip02">@lang('home.password')</label>
                                <input id="validationTooltip02" required="" minlength="6" class="form-control m-input" type="password" placeholder="@lang('home.Rpassword')" name="password" value="{{old('password')}}">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <p class="password-hinte">
                                @lang('home.passwordHint')
                            </p>
                        </div>
                        {{--<div class="form-group">
                            <div class="input-holder">
                                <label for="validationTooltip02">@lang('home.reenterpassword')</label>
                                <input required="" id="validationTooltip02" minlength="6" class="form-control m-input" type="password" placeholder="@lang('home.confirmPassword')" name="password_confirmation" value="{{old('password_confirmation')}}">
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>--}}
                        </div>
                        <div class="form-element">
                        <div class="form-group">
                            <div class="input-holder">
                                <label for="validationTooltip01">@lang('home.title')</label>
                                <input required="" class="form-control m-input" type="text" placeholder="@lang('home.title')" name="T" value="{{old('T')}}">
                                @error('T')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-holder">
                                <label for="validationTooltip01">@lang('home.companyName')</label>
                                <input required="" class="form-control m-input" type="text" placeholder="@lang('home.companyName')" name="CN" value="{{old('CN')}}">
                                @error('CN')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-holder">
                                <label for="validationTooltip01">@lang('home.yourPhone')</label>
                                <input required="" class="form-control m-input" type="text" placeholder="@lang('home.Rphone')" name="phone" value="{{old('phone')}}">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group photo-holder">
                            <div class="input-holder">
                                <label for="validationTooltip01">@lang('home.yourPhoto')</label>
                                <input  data-input="false" data-buttonName="btn-primary" data-buttonText="Hello there, pick your files" class="filestyle form-control m-input" type="file"  name="photo">
                            </div>
                        </div>
                        </div>
                        </div>

                        <button class="primary-fill submit-btn" type="submit">@lang('home.cua')</button>
                        <a class="primary-dark-fill facebook-link mb-3" href="{{route('redirect.facebook','facebook')}}">
                            <img class="mr-2" src="{{asset('frontend_plugins/web/images/facebook.png')}}" alt=""/> @lang('home.facebookLogin')
                        </a>
                        <a class="primary-dark-fill facebook-link" href="{{route('redirect.facebook','google')}}">
                            <img src="{{asset('frontend_plugins/web/images/gmail.png')}}" alt=""/> @lang('home.gmailLogin')
                        </a>
                        <div class="signup-hinte">@lang('home.AgreeTermsCondition')
                            <a href="{{route('user.terms.conditions')}}" target="_blank">@lang('home.termsConditions')</a> , <a target="_blank" href="{{route('user.sell.policies')}}">@lang('home.sellPolicies')</a>
                        </div>
                        <p class="have-account">
                            @lang('home.haveAccount') <a href="{{route('login')}}">@lang('home.SignIn')
                                <!-- <span>&#10151;</span> -->
                            </a>
                        </p>
                    </form>
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
