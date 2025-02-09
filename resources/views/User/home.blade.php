@extends('User.partials.index')
@section('page-title', $setting->title )
@section('page-description', $setting->Meta_Description)
@section('page-keywords', $setting->keywords)
@section('page-image', asset('storage/'.$setting->site_logo))
@section('homePage-seo')
    <meta property="fb:app_id" content="714235722608093" />
    <meta property="og:title"  content="{{$setting->title}}"/>
    <meta property="og:description" content="{{$setting->Meta_Description}}"/>
    <meta property="og:type"  content="website"/>
    @if(App::isLocale('en'))
    <meta property="og:url" content="https://souqkahraba.com"/>
    @elseif(App::isLocale('ar'))
    <meta property="og:url" content="https://souqkahraba.com/ar"/>
    @endif
    <meta property="og:site_name" content="Souqkahraba"/>
    <meta property="og:image" content="{{asset('storage/'.$setting->site_logo)}}"/>
    <meta property="og:image:width" content="190" />
    <meta property="og:image:height" content="48" />
    <meta name="twitter:site" content="@souqkahraba"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title" content="{{$setting->title}}" />
    <meta name="twitter:description" content="{{$setting->Meta_Description}}"/>
@endsection
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
@push('style')
<style>

    .categories-grid-wrapper .category-card-holder .category-card--body h3 {
        font-size: 21px;
        font-weight: bold;
        text-transform: capitalize;
        margin-bottom: 20px;
    }
    .categories-grid-wrapper .category-card-holder .category-card--body h3 a {
        font-size: 21px;
        font-weight: bold;
        text-transform: capitalize;
        color: #000;
    }
    </style>
@endpush

@include('User.Modals.login')
<main class="home-holder">
  <div class="container">
    <div class="home-content">
      <div class="home-content-header">
        <div class="row">
          <div class="col-md-9 px-0 px-md-3">
            <div class="home-slider">
              @foreach($SiteBanners as $banner)
              <a href="{{$banner->url}}" target="_blank">
                <img src=" {{ asset('storage/'.$banner->img) }} " alt="@lang('home.ElectricalEquipment')|{{$banner->alt}}" />
              </a>
              @endforeach
            </div>
          </div>
          <div class="col-md-3 px-0 pr-md-3">
            <div class="row h-100 poster-wrapper">
              <div class="card col-6 col-md-12">
                @if($adBanner->firstImage)
                <a href="{{$adBanner->firstURL}}" target="_blank">
                  <img src=" {{ asset('storage/'.$adBanner->firstImage) }} " alt="@lang('home.ElectricalEquipment')|{{$adBanner->firstImageAlt}}"  style="width: 100%;height: 100%" />
                </a>
                @else
                  @lang('home.noAdsAvailable')
                @endif
              </div>
              <div class="card col-6 col-md-12">
                @if($adBanner->secondImage)
                <a href="{{$adBanner->secondURL}}" target="_blank">
                  <img src=" {{ asset('storage/'.$adBanner->secondImage) }} " alt="@lang('home.ElectricalEquipment')|{{$adBanner->secondImageAlt}}"  style="width: 100%;height: 100%" />
                </a>
                @else
                  @lang('home.noAdsAvailable')
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

        <!-- start new section site artilce -->
        <div class="site-section-wrapper">
            <h1>@lang('home.sectionHeader')</h1>
            <h2>
                @lang('home.sectionBody')
            </h2>
            <div class="site-article-holder">
                <div class="site-article-card">
                    <img class="article-card--img" src="{{ asset('frontend_plugins/web/images/Products-Icon.png')}}" alt="">
                    <div class="article-card--content">
                        <p>{{$productCount}}</p>
                        <p>@lang('home.products')</p>
                    </div>
                </div>
                <div class="site-article-card">
                    <img class="article-card--img" src="{{ asset('frontend_plugins/web/images/Company-Icon.png')}}" alt="">
                    <div class="article-card--content">
                        <p>{{$companiesCount}}</p>
                        <p>@lang('home.companies')</p>
                    </div>
                </div>
                <div class="site-article-card">
                    <img class="article-card--img" src="{{ asset('frontend_plugins/web/images/Brands-Icon.png')}}" alt="">
                    <div class="article-card--content">
                        <p>{{$bandCount}}</p>
                        <p>@lang('home.brands')</p>
                    </div>
                </div>
                <div class="site-article-card">
                    <img class="article-card--img" src="{{ asset('frontend_plugins/web/images/Category-Icon.png')}}" alt="">
                    <div class="article-card--content">
                        <p>{{$categories}}</p>
                        <p>@lang('home.categories')</p>
                    </div>
                </div>
            </div>
        </div>

      <div class="request-hint-wrapper">
        <div class="row">
          <div class="col-md-12">

            <a href="{{route('user.rfq')}}" target="_blank">

                <img class="img-fluid w-100 h-100" src="{{ asset('storage/'.$setting->rfq_image) }}" alt="rfq-img" />
            </a>

          </div>
<!--           <div class="col-md-6 d-flex justify-content-center flex-column py-5">
            <h2 class="text-center">@lang('home.oneRequest'),
              <br />@lang('home.multipleQuotes')
            </h2>
            <button class="primary-fill rounded lg-btn">
              @lang('home.requestForQuotationNow')
            </button>
          </div> -->
        </div>
      </div>

      <!-- end section -->

      <!-- start category grid -->
    @foreach ($gridCategories as $grid_category)
      <div class="categories-grid-wrapper">
        <h2>{{$grid_category->name}}</h2>
        <div class="categories-grid">
            <div class="categories-banner" style="background-image: url({{ asset('storage/'.$grid_category->image) }})">
              <div class="logo-holder">
                <img src="{{ asset('frontend_plugins/web/images/souqKLogo.png')}}" alt="@lang('home.ElectricalEquipment')|{{$grid_category->name}}">
              </div>
              <div class="content">
                <h5>{{$grid_category->name}}</h5>
                <p>@lang('home.productsAndSystems')</p>
                <a href="{{urldecode(route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$grid_category->name),'id'=>$grid_category->id])) }}" class="yellow-fill">@lang('home.viewAll')</a>
              </div>
            </div>
            @foreach ($grid_category->childs as $grid_category_level2)
                <div class="category-card-holder">
                <div class="category-card--img">
                    <img src="{!! asset('storage/'.$grid_category_level2->image) !!}" alt="@lang('home.ElectricalEquipment')|{{$grid_category_level2->name}}">
                </div>
                <div class="category-card--body">
                    <h3> <a href="{{ urldecode(route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$grid_category_level2->name),'id'=>$grid_category_level2->id])) }}">{{$grid_category_level2->name}}</a> </h3>
                    <ul>
                    @foreach ($grid_category_level2->childs as $grid_category_level3)
                    @if($loop->index<5)
                    <li>
                        <a href="{{urldecode(route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$grid_category_level3->name),'id'=>$grid_category_level3->id])) }}">{{$grid_category_level3->name}}</a>
                    </li>
                    @endif
                    @if($loop->index==5)
                        <li>
                            <a href="{{ urldecode(route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$grid_category_level2->name),'id'=>$grid_category_level2->id])) }}" class="more-link">@lang('home.viewMore')</a>
                        </li>
                    @endif
                    @endforeach
                    </ul>
                </div>
                </div>
            @endforeach
        </div>
      </div>
    @endforeach
      <!-- End category grid -->
        <div class="companies">
          <div class="slider-heading">
            <h2>@lang('home.trendingCompanies')</h2>
          </div>
          <div class="content">
            <div class="companies-slider">
              @foreach($TrendingCompanies as $company)
              @include('User.viewCompanies')
              @endforeach
            </div>
          </div>
        </div>
        <div class="brands brands-section-wrapper">
          <div class="slider-heading">
            <h2>@lang('home.trendingBrands')</h2>
          </div>
          <div class="content">
            <div class="brands-slider">
              @foreach($TrendingBrands as $brand)
              @include('User.viewBrands')
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
@push('script')
<script src="{{ asset('frontend_plugins/web/javascript/home.js') }}"></script>
@endpush
