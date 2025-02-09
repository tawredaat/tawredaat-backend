@extends('User.partials.index')
@section('page-title', __('home.cart'))
@section('page-image', asset('storage/'.$setting->site_logo))

@section('content')
    <!-- start page content -->
    <main class="blog-holder">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('home.cart')</li>
                </ol>
            </nav>
            @if($cart)
            <div class="shop-cart-wrapper">
                <h4> <span>@lang('home.cart')</span> ({!! __('home.youHaveCartIems',['itemsCount' => count($cart) ])  !!})</h4>
                <div class="shop-cart-list">
                    <?php $total = 0;?>
                @foreach ($cart as $item )
                    <?php $total += $item->cart_item_qty*$item->new_price;?>
                    <div class="shop-cart-product-holder" id="shop-cart-product-holder-{{$item->id}}">
                        <div class="cart-product-img">
                            <img src="{{$item->image}}" alt="{{$item->alt}}">
                        </div>
                        <div class="cart-product-content">
                            <p class="cart-product--title">
                                {{$item->name}}
                            </p>
                            <div class="cart-product-controls">
                                <div class="cart-product-controls-btn">
                                    <div class="cart-product-price">
                                        <span id="item-amount-{{$item->id}}">{{$item->cart_item_qty*$item->new_price}}</span>
                                        @lang('home.currency') / {{$item->quantity_type}}
                                    </div>
                                    <div class="quantity-holder">
                                        <div class="qty product-card">
                                            <span class="minus update-cart-item" data-route="{{route('user.guest.update.cart')}}" data-action="0"  data-cartitemid="{{$item->id}}"  data-shopproductid="{{$item->id}}" >-</span>
                                            <input type="number" disabled class="count" value="{{$item->cart_item_qty}}" min="1" max="{{$item->qty}}"/>
                                            <span class="plus update-cart-item" data-route="{{route('user.guest.update.cart')}}" data-action="1"  data-cartitemid="{{$item->id}}"  data-shopproductid="{{$item->id}}" >+</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="remove-product-cart product-card">
                                    <a title="remove item" class="delete-from-cart-btn" data-route="{{route('user.guest.delete.cart')}}" data-cartitemid="{{$item->id}}"  data-shopproductid="{{$item->id}}" >
                                    <img src="{{ asset('frontend_plugins/web/images/remove.svg')}}" alt="">
                                    @lang('home.removeFromCart')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                    <div class="total-card-wrapper">
                        <p id="cart-total-holder">
                            @lang('home.total') {{$total}} : <span> @lang('home.currency')</span>
                        </p>
                            <a data-toggle="modal" data-target="#LoginModal" href="#" class="primary-dark-fill">@lang('home.proceed')</a>
                    </div>
                </div>
            </div>
            @else
            <div class="shop-cart-wrapper">
                <h4> <span>@lang('home.cart')</span> (@lang('home.noCartItems'))</h4>
            </div>
            @endif
        </div>
    </main>
@endsection
@push('script')
{{-- <script src="{{ asset('frontend_plugins/web/javascript/product.js') }}"></script> --}}
@endpush
