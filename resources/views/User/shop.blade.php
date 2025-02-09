@extends('User.partials.index')
@section('page-title', __('home.shop'))
@section('page-image', asset('storage/'.$setting->site_logo))
@section('content')
@push('style')

@endpush
    <!-- start page content -->
    <main class="blog-holder">
        <div class="container">
            <div class="shop-page-wrapper">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb px-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('home.shop')</li>
                    </ol>
                </nav>
                <div class="shop-slider-wrapper">
                    @include('User.partials.shop_banners')
                </div>
                {{-- <!-- start All Categories  --> --}}
                <div class="all-categories-wrapper">
                    <h3 style="text-align: unset;margin: 10px 0;">@lang('home.allShopCategories')</h3>
                    <div class="all-categories-grid">
                        @foreach ($categories as $category)
                            @if($category->image)
                                @if($loop->index > 18)
                                    <div class="card-wrapper-updated-user" style="font-weight:bold">
                                        <a href="{{route('user.shop.categories.view.all')}}" style="color:#23408D" class="category-card-holder">@lang('home.viewMore')</a>
                                    </div>
                                    @break;
                                @else
                                    <div class="card-wrapper-updated-user">
                                        <a href="{{urldecode(route('user.shop.category.l3.products',['name'=>str_replace([' ','/'], '-',$category->name),'id'=>$category->id])) }}" class="category-card-holder">
                                            <img src="{{ $category->image }}" alt="">
                                        </a>
                                        <p class="category-card--name">{{$category->name}}</p>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
                {{-- Featured shop Products --}}
                @if(count($featured_shop_products))
                    <div class="featured-shop-products"style="margin-bottom:40px">
                        <div class="slider-heading">
                            <h2>@lang('home.trendingProducts')</h2>
                        </div>
                        <div class="content">
                            <div class="featured-shop-products-slider">
                                @foreach($featured_shop_products as $product)
                                    @include('User.viewShopProducts')
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                {{-- Best Seller shop  products --}}
                @if(count($best_seller_shop_products))
                    <div class="best-seller-shop-products">
                        <div class="slider-heading">
                            <h2>@lang('home.bestSellerShop')</h2>
                        </div>
                        <div class="content">
                            <div class="best-seller-shop-products-slider">
                                @foreach($best_seller_shop_products as $product)
                                    @include('User.viewShopProducts')
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
@push('script')
<script>
    $(document).ready(function () {
        @if(App::isLocale('en'))
        $(".home-slider").slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            cssEase: "ease",
            dots: false,
            autoplay: true,
        autoplaySpeed: 2000,
        });
        @else
        $(".home-slider").slick({
            infinite: true,
            rtl: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            cssEase: "ease",
            dots: false,
            autoplay: true,
            autoplaySpeed: 2000,
        });
        @endif
        $(".best-seller-shop-products-slider").slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: true,
            autoplay: true,
            autoplaySpeed: 2500,
            arrows: true,
            touchMove: true,
            pauseOnHover: false,
            cssEase: "ease",
            responsive: [{
                breakpoint: 992,
                settings: {
                slidesToShow: 3,
                slidesToScroll: 1
                }
            }
            ,{
                breakpoint: 768,
                settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }}
            ]
        });
        $(".featured-shop-products-slider").slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: true,
            autoplay: true,
            autoplaySpeed: 2500,
            arrows: true,
            touchMove: true,
            pauseOnHover: false,
            cssEase: "ease",
            responsive: [{
                breakpoint: 992,
                settings: {
                slidesToShow: 3,
                slidesToScroll: 1
                }
            }
            ,{
                breakpoint: 768,
                settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }}
            ]
        });
    });
</script>
@endpush

