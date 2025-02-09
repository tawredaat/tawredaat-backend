@extends('User.partials.index')
@section('page-title', __('home.selectAddress'))
@section('page-image', '')

@section('content')
    <!-- start page content -->
    <main class="blog-holder">
        <div class="container">
        <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order Placed</li>
                </ol>
            </nav> -->
            <div class="shop-select-address-wrapper shop-checkout-wrapper shop-wide">
                <div class="shop-checkout-header">
                    <h3>{{__('home.selectAddress')}}</h3>
                    <a href=""><img class="mr-2" src="{{ asset('frontend_plugins/web/images/cart_blue.svg')}}" alt="">{{__('home.backToCart')}}</a>
                </div>
                <div class="shop-checkout-content">
                    <div class="shop-checkout-body">
                        <div class="radio-buttons">
                        @foreach ($addresses as $address )
                            <div class="rdio rdio-primary"> <input data-route="{{route('user.select-address.checkout')}}" class="select-user-cart-address" name="radio" value="{{$address->id}}" id="radio{{$address->id}}" type="radio" @if($cart->address && $cart->address->id==$address->id)checked @endif>
                              <label for="radio{{$address->id}}">{{$address->building}} {{$address->street}}. {{$address->area}} , {{$address->country?$address->country->name:''}} {{$address->landmark?' ,'.$address->landmark:''}}</label>
                            </div>
                        @endforeach
                          </div>
                    </div>
                    <div class="shop-checkout-aside">
                        <p>
                            {{__('home.total')}} : <span>{{$cart->itemsTotal}} @lang('home.currency')</span>
                        </p>
                        <a href="{{route('user.view.checkout')}}" class="primary-dark-fill" style="font-size:16px">{{__('home.proceedToPayment')}}</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="divider-x"></div>
        <div class="container">
            <div class="add-address-wrapper shop-wide">
                <h3>{{__('home.addNewAddress')}}</h3>
                <div class="add-address-body">
                    <form class="" method="post" action="{{route('user.add-address.checkout')}}" id="needs-validation" novalidate>
                        @csrf
                        <div class="form-content-holder">
                        <div class="form-inpt-holder">
                            <div class="form-group">
                              <label class="text-inverse" for="select-menu">{{__('home.yourCity')}}*</label>
                              <select class="custom-select d-block form-control" id="image" name="country_id" required>
                                <option value="">*{{__('home.selectCity')}}</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                              </select>
                              <div class="invalid-feedback">
                                @lang('home.selectValidCountry')
                              </div>
                            </div>
                          </div>
                          <div class="form-inpt-holder">
                             <div class="form-group">
                              <label class="text-inverse" for="validationCustom01">{{__('home.area')}}*</label>
                              <input type="text" name="area" class="form-control" id="validationCustom01" placeholder="{{__('home.area')}}" value="" required>
                              <div class="invalid-feedback">
                                @lang('home.selectValidArea')
                              </div>
                            </div>
                          </div>
                          <div class="form-inpt-holder">
                            <div class="form-group">
                              <label class="text-inverse" for="validationCustom02">{{__('home.street')}}*</label>
                              <input type="text" name="street" class="form-control" id="validationCustom02" placeholder="{{__('home.street')}}" value="" required>
                              <div class="invalid-feedback">
                                @lang('home.selectValidStreet')
                              </div>
                            </div>
                          </div>
                          <div class="form-inpt-holder">
                            <div class="form-group">
                              <label class="text-inverse" for="validationCustom03">{{__('home.BuildingNum')}}*</label>
                              <input type="text" name="building" class="form-control" id="validationCustom03" placeholder="{{__('home.BuildingNum')}}" required>
                              <div class="invalid-feedback">
                                @lang('home.selectValidBuilding')
                              </div>
                            </div>
                          </div>
                          <div class="form-inpt-holder">
                            <div class="form-group">
                              <label class="text-inverse" for="validationCustom03">{{__('home.landmark')}}</label>
                              <input type="text" name="landmark" class="form-control" id="validationCustom03" placeholder="{{__('home.landmark')}}">
                              {{-- <div class="invalid-feedback">
                                Please provide a valid Landmark.
                              </div> --}}
                            </div>
                          </div>
                          </div>

                        <div class="row">
                          <div class="col-lg-12 col-sm-12 col-12 text-left mt-5">
                              <button class="primary-dark-outline" type="submit">{{__('home.save')}}</button>
                          </div>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
<script>
(function() {
    'use strict';
    window.addEventListener('load', function() {
      var form = document.getElementById('needs-validation');
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    }, false);
  })();
</script>
@endpush
