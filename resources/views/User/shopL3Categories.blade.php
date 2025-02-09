@extends('User.partials.index')
@section('page-title', __('home.shopCategores'))
@section('page-image', asset('storage/'.$setting->site_logo))
@section('content')
    <!-- start page content -->
    <main class="blog-holder">
        <div class="container">
            <div class="shop-page-wrapper">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb px-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.shop.products') }}">@lang('home.shop')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('home.categories')</li>
                    </ol>
                </nav>
                {{-- <!-- start All Categories  --> --}}
                <div class="all-categories-wrapper">
                    <h3 style="text-align: unset;margin: 10px 0;">@lang('home.allShopCategories')</h3>
                    <div class="all-categories-grid">
                        @foreach ($categories as $category)
                            @if($category->image)
                                    <div class="card-wrapper-updated-user">
                                        <a href="{{urldecode(route('user.shop.category.l3.products',['name'=>str_replace([' ','/'], '-',$category->name),'id'=>$category->id])) }}" class="category-card-holder">
                                            <img src="{{ $category->image }}" alt="">
                                        </a>
                                        <p class="category-card--name">{{$category->name}}</p>
                                    </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection

