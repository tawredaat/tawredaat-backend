@extends('User.partials.index')
@section('page-title', __('home.shopProducts'))
@section('page-image', asset('storage/'.$setting->site_logo))
@section('content')
    <!-- start page content -->
    <main class="blog-holder shop-products-wrapper">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.shop.products') }}">@lang('home.shop')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('user.shop.categories.view.all')}}">@lang('home.categories')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('home.products')</li>
                </ol>
            </nav>
            <div class="search-content">
                @if(ProductHorizontalAd())
                <div class="poster-wrapper" style="background: none;align-items: flex-start;">
                    <a href="{{ProductHorizontalAd()->url}}" target="_blank" style="width: 100%;height: 100%">
                        @if(!is_null(ProductHorizontalAd()->mobileimg))
                            <img data-src="{{ asset('storage/'.ProductHorizontalAd()->mobileimg) }}" class="img-mob lazyload" width="100" height="100" style="width: auto;">
                        @endif
                    <img data-src="{{ asset('storage/'.ProductHorizontalAd()->image) }}" class="lazyload" width="100" height="100" style="width: auto;">
                    </a>
                </div>
                @endif
                <div class="row" id="shop-products-content-box">
                    @include('User.partials.shop_products_content_component')
                </div>
              </div>
        </div>
    </main>
@endsection

