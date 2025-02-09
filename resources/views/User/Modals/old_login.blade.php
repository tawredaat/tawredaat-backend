<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog"
     aria-labelledby="RequestQuotationModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="InfoModalLongTitle">@lang('home.SignIn')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="root">
                    <div class="signup-wrapper" style="min-height: 0">
                        <div class="form-wrapper form-trans-wrapper">
                            <!-- <div class="signup-form login-trans-holder trans-active"> -->
                            <div class="mb-3">
                                <form action="{{route('website.login')}}" method="post" class="needs-validation" novalidate>
                                    @csrf
                                    <input type="hidden" name="back" value="1">
                                    <input type="hidden" id="c_i_d" name="company_id" value="">
                                    <input type="hidden" id="c_n_m" name="company_name" value="">
                                    <input type="hidden" id="product_name" name="product_name" value="">
                                    <input type="hidden" id="product_id" name="product_id" value="">
                                    <input type="hidden" id="brand_name" name="brand_name" value="">
                                    <div class="form-group">
                                        <div class="input-holder">
                                            <label for="validationTooltip01">@lang('home.mailOrPhone')</label>
                                            <input required="" class="form-control m-input" id="validationTooltip01"  type="email" placeholder="@lang('home.mailOrPhone')" name="email" value="{{old('email')}}">
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
                                    </div>
                                    <div class="form-group" style="margin-top: 5px">
                                        <input  type="checkbox" name="rememberme"> @lang('home.rememberMe')
                                    </div>
                                    <button style="margin-top: 10px" class="primary-fill submit-btn" type="submit">@lang('home.SignIn')</button>
                                    <p class="have-account">
                                        @lang('home.dontHaveAccount') <a class="swap-screen-login" href="{{route('website.signup')}}">@lang('home.signup')
                                        <!-- <span>&#10151;</span> -->
                                        </a>
                                    </p>
                                </form>
                            </div>

                <!-- <div class="signup-form signup-trans-holder trans-hide"> -->
                <div class="">
                    <form action="{{route('website.register')}}" class="needs-validation" novalidate method="post">
                        @csrf
                        <input  type="hidden" name="T">
                        <input  type="hidden" name="CN">
                        <input id="cid" type="hidden" name="company_id">
                        <input id="c_name" type="hidden" name="company_name">
                        <input type="hidden" id="pro_name" name="product_name" value="">
                        <input type="hidden" id="pro_id" name="product_id" value="">
                        <input type="hidden" id="bra_name" name="brand_name" value="">

                        <h1>@lang('home.createAccount')</h1>
                        <div class="">
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
                            </div>
                            <div class="form-element">
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
                        </div>

                        <button class="primary-fill submit-btn" type="submit">@lang('home.cua')</button>
                        <div class="signup-hinte">@lang('home.AgreeTermsCondition')
                            <a href="">@lang('home.ConditionOfUse')</a> , <a href="">@lang('home.PrivacyNotice')</a>
                        </div>
                        <p class="have-account">
                            @lang('home.haveAccount') <a class="swap-screen-signup"  href="{{route('login')}}">@lang('home.SignIn')
                                <!-- <span>&#10151;</span> -->
                            </a>
                        </p>
                    </form>
                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('home.close')
                </button>
            </div>
        </div>
    </div>
</div>
