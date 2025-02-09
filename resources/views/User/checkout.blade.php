@extends('User.partials.index')
@section('page-title', __('home.checkout'))
@section('page-image', asset('storage/'.$setting->site_logo))

@section('content')
    <!-- start page content -->
    <main class="blog-holder">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('home.checkout')}}</li>
                    {{-- @if($cart->address)
                    <li><span>Delivery Address :</span>{{$cart->address->building}} {{$cart->address->street}}. {{$cart->address->area}} , .....</li>
                    @endif --}}
                </ol>
            </nav>
            <div class="shop-cart-wrapper">
                <div class="shop-cart-list">
                    @foreach ($cart->items as $item )
                        <div class="shop-cart-product-holder" id="shop-cart-product-holder-{{$item->shopProduct?$item->shopProduct->id:''}}">
                            <div class="cart-product-img">
                                <img src="{{$item->shopProduct?$item->shopProduct->image:''}}" alt="{{$item->shopProduct?$item->shopProduct->alt:''}}">
                            </div>
                            <div class="cart-product-content">
                                <p class="cart-product--title">
                                    {{$item->shopProduct?$item->shopProduct->name:''}}
                                </p>
                                <div class="cart-product-controls">
                                    <div class="cart-product-controls-btn">
                                        <div class="cart-product-price">
                                            <span>{{$item->amount}}</span>
                                            @lang('home.currency') / {{$item->quantity_type}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="shop-checkout-wrapper">
                <div class="shop-checkout-header">
                    <h3>{{__('home.selectPayment')}}</h3>
                    <a href="{{route('user.view.cart')}}"> <img class="mr-2" src="{{ asset('frontend_plugins/web/images/cart_blue.svg')}}" alt="">{{__('home.backToCart')}}</a>
                </div>
                <div class="shop-checkout-content">
                    <div class="shop-checkout-body">
                        <div class="radio-buttons">
                        @foreach ($payments as $payment)
                            <div class="rdio rdio-primary"> <input class="select-payment-type-radio" data-route="{{route('user.select-payment.checkout')}}" name="radio" value="{{$payment->id}}" id="radio{{$payment->id}}" type="radio" @if($cart->payment && $cart->payment->id==$payment->id)checked @endif>
                              <label for="radio{{$payment->id}}">{{$payment->name}}
                                  {{-- <p class="extra-p">
                                      You will pay 30% only and pay the remaining cash when order delivered
                                    </p> --}}
                                </label>
                            </div>
                        @endforeach
                          </div>
                    </div>
                    <div class="shop-checkout-aside">
                        <p>
                            {{__('home.total')}} : <span>{{$cart->itemsTotal}} @lang('home.currency')</span>
                        </p>
                        <a href="{{route('user.send.checkout')}}" class="primary-dark-fill">{{__('home.PlaceOrder')}}</a>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection
