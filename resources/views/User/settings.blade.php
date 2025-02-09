@extends('User.partials.index')
@section('page-title', __('home.settings'))
@section('page-description', $setting->Meta_Description)
@section('page-image', asset('storage/'.$setting->site_logo))
@section('content')
<div class="signup-wrapper">
  <a href="{{route('user.home')}}" class="logo-holder mb-20">
    <img src="{{ asset('storage/'.$setting->site_logo) }}" alt="{{$setting->siteLogoAlt}}"/>
  </a>
  <div class="form-wrapper">
    <div class="signup-form">
      <form action="{{route('user.setting',$user->id)}}" class="needs-validation" novalidate method="post" enctype="multipart/form-data">
        @csrf
        <h1>@lang('home.settings')
        </h1>
        <div class="form-elements-holder">
          <div class="form-element">
            <div class="form-group">
              <div class="input-holder">
                <label for="validationTooltip01">@lang('home.yourName')
                </label>
                <input required="" id="validationTooltip01" class="form-control m-input" type="text" placeholder="@lang('home.name')" name="name" value="{{old('name')?old('name'):$user->name}}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}
                  </strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <div class="input-holder">
                <label for="validationTooltip02">@lang('home.yourEmail')
                </label>
                <input required="" id="validationTooltip02" class="form-control m-input" type="email" placeholder="@lang('home.email')" name="email" value="{{old('email')?old('email'):$user->email}}">
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}
                  </strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <div class="input-holder">
                    <img src="{{ $user->photo }}" width="300" height="170">
              </div>
            </div>
          </div>
          <div class="form-element">
            <div class="form-group">
              <div class="input-holder">
                <label for="validationTooltip01">@lang('home.title')
                </label>
                <input required="" class="form-control m-input" type="text" placeholder="@lang('home.title')" name="T" value="{{old('T')?old('T'):$user->title}}">
                @error('T')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}
                  </strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <div class="input-holder">
                <label for="validationTooltip01">@lang('home.companyName')
                </label>
                <input required="" class="form-control m-input" type="text" placeholder="@lang('home.companyName')" name="CN" value="{{old('CN')?old('CN'):$user->company_name}}">
                @error('CN')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}
                  </strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <div class="input-holder">
                <label for="validationTooltip01">@lang('home.yourPhone')
                </label>
                <input required="" class="form-control m-input" type="text" placeholder="@lang('home.Rphone')" name="phone" value="{{old('phone')?old('phone'):$user->phone}}">
                @error('phone')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}
                  </strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group photo-holder">
              <div class="input-holder">
                <label for="validationTooltip01">@lang('home.yourPhoto')
                </label>
                <input  class="form-control m-input" type="file"  name="photo">
              </div>
            </div>
          </div>
        </div>
        <button class="primary-fill submit-btn" type="submit">@lang('home.save')
        </button>
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
      }, false);})();
  });
</script>
@endpush
@endsection
