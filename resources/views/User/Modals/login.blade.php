<div class="modal fade auth-modal" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="signupModalTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="user-auth-tabs">
        <div class="auth-tabs-header">
            <div class="tabs-header-button active" data-target="create">@lang('home.createAccount')</div>
            <div class="tabs-header-button" data-target="login">@lang('home.login')</div>
        </div>
        <div class="auth-tabs-body active" data-tab="create">
        <form action="{{route('website.register')}}" class="form-content needs-validation" novalidate method="post">
            @csrf
            <input type="hidden" name="back" value="1">
            <input  type="hidden" name="T">
            <input  type="hidden" name="CN">
            <input  type="hidden" name="photo">
            <input type="hidden" name="interest_id[]" value="">
            <input id="cid" type="hidden" name="company_id">
            <input id="c_name" type="hidden" name="company_name">
            <input type="hidden" id="pro_name" name="product_name" value="">
            <input type="hidden" id="pro_id" name="product_id" value="">
            <input type="hidden" id="bra_name" name="brand_name" value="">

            <div class="form-group">
                <div class="input-holder">
                <label for="validationTooltip01">@lang('home.fullname')</label>
                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="validationTooltip01" required>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
                </div>
                <div class="form-group">
                <div class="input-holder">
                    <label for="validationTooltip02">@lang('home.mail')</label>
                    <input type="email" name="email" value="{{old('email')}}" class="form-control" id="validationTooltip02" required>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
                </div>
                <div class="form-group">
                <div class="input-holder">
                    <label for="phone">@lang('home.phone')</label>
                    <input type="number" name="phone" value="{{old('phone')}}" class="form-control" id="phone" required>
                @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
                </div>
                <div class="form-group password-input">
                    <div class="input-holder">
                    <label for="validationTooltip02">@lang('home.password')</label>
                    <input type="password" name="password" minlength="6" class="form-control" id="validationTooltip02" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                </div>
                <div class="action-btn-holder text-center">
                    <button class="yellow-fill submit-btn" type="submit">@lang('home.submit')</button>
                </div>
            </form>
        </div>
        <div class="auth-tabs-body" data-tab="login">
            <form action="{{route('website.login')}}" method="post" class="form-content needs-validation" novalidate>
            @csrf
            <input type="hidden" name="back" value="1">
            <input type="hidden" id="c_i_d" name="company_id" value="">
            <input type="hidden" id="c_n_m" name="company_name" value="">
            <input type="hidden" id="product_name" name="product_name" value="">
            <input type="hidden" id="product_id" name="product_id" value="">
            <input type="hidden" id="brand_name" name="brand_name" value="">
            <div class="form-group">
                <div class="input-holder">
                <label for="loginName">@lang('home.mailOrPhone')</label>
                <input type="text" name="email" value="{{old('email')}}" class="form-control" id="loginName" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
                </div>
                <div class="form-group password-input">
                    <div class="input-holder">
                    <label for="loginPass">@lang('home.password')</label>
                    <input type="password"  name="password" minlength="6" class="form-control" id="loginPass" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>
                <div class="action-btn-holder text-center">
                    <button class="yellow-fill submit-btn" type="submit">@lang('home.login')</button>
                </div>
                <div class="social-auth-wrapper">
                    <a href="{{route('redirect.facebook','facebook')}}" class="primary-fill"> <img src="{{asset('frontend_plugins/web/images/facebook-logo.png')}}" alt="@lang('home.ElectricalEquipment')|Login with facebook">@lang('home.facebookLogin')</a>
                    <a href="{{route('redirect.facebook','google')}}" class="primary-fill"> <img src="{{asset('frontend_plugins/web/images/Gmail-logo.png')}}" alt="@lang('home.ElectricalEquipment')|Login with gmail"> @lang('home.gmailLogin')</a>
                </div>
            </form>
        </div>
        </div>
    </div>
    </div>
</div>
</div>
