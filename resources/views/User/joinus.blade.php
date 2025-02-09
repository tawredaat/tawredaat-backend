@extends('User.partials.index')
@section('page-title', __('home.Getlisted'))
@section('page-description', $setting->Meta_Description)
@section('page-image', asset('storage/'.$setting->site_logo))
@section('canonical-link', url()->current())

@if(App::isLocale('en'))
    @section('alternate-en-link', url()->current())
@section('alternate-ar-link', url()->current().'/ar')
@else
    @section('alternate-ar-link', url()->current())
<?php
$en_link = str_replace("/ar", "",url()->current());
?>
@section('alternate-en-link',$en_link)
@endif
@section('content')
        <div class="signup-wrapper">
            <a href="{{route('user.home')}}" class="logo-holder mb-20">
                <img src="{{ asset('storage/'.$setting->site_logo) }}" alt="{{$setting->siteLogoAlt}}"/>
            </a>
            <div class="form-wrapper">
                <div class="signup-form signup-company-wrapper">
                    <form action="{{route('store-joinus')}}" method="post" class="needs-validation" novalidate>
                        @csrf
                        <h5>@lang('home.signupHeader')</h5>
                        <div class="form-group">
                            <div class="input-holder">
                                <input type="text" class="form-control" value="{{old('name')}}" name="name" placeholder="@lang('home.name') *" id="validationTooltip01"
                                       required>
                                <div class="invalid-feedback">
                                    Name is required
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-holder">
                                <input type="text" name="company_name" value="{{old('company_name')}}" class="form-control" placeholder="@lang('home.companyName') *"
                                       id="validationTooltip011" required>
                                <div class="invalid-feedback">
                                    Company Name is required
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-holder">
                                <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="@lang('home.email') *" id="validationTooltip02"
                                       required>
                                <div class="invalid-feedback">
                                    Email required
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-holder">
                                <input type="tel" name="mobile" value="{{old('mobile')}}"
                                       maxlength="11" placeholder="@lang('home.mobile'). *" required/>
                                <div class="invalid-feedback">
                                    mobile number at least 11 digits
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-holder">
                                <input type="text" name="phone" value="{{old('phone')}}" class="form-control" placeholder="@lang('home.companyNumber')."
                                       id="validationTooltip07">
                                <div class="invalid-feedback">
                                    Address is required
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-holder">
                                <input type="text" value="{{old('company_type')}}" class="form-control" name="company_type" placeholder="@lang('home.companyType')"
                                       id="validationTooltip08">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-holder">
                                <input type="url" name="website" value="{{old('website')}}" id="url" placeholder="@lang('home.website')">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-holder">
                                <input type="url" name="facebook" value="{{old('facebook')}}" placeholder="@lang('home.facebook')">
                            </div>
                        </div>
                        <button class="primary-fill submit-btn" type="submit">@lang('home.submit')</button>
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
