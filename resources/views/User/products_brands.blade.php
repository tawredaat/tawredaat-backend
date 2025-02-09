@extends('User.partials.index')
@section('page-title', $brand->products_title)
@section('page-keywords', $brand->products_keywords)
@section('page-description',$brand->products_description)
@section('page-image', asset('storage/'.$setting->site_logo))
@section('canonical-link', urldecode(urldecode(url()->current().'?page='.$products->currentPage())))
@section('pagination-links')
@if($products->previousPageUrl() != null)

    <link rel="prev"  href="{{urldecode($products->previousPageUrl())}}" />

@endif
@if($products->nextPageUrl() != null)

    <link rel="next"  href="{{urldecode($products->nextPageUrl())}}" />

@endif
@endsection

@if(App::isLocale('en'))
    @section('alternate-en-link',urldecode(url()->current()) )
<?php
$ar_route = urldecode(route('user.brand-products',['name'=>str_replace([' '], '-','ar/'.$brand->translate('ar')->name),'id'=>$brand->id]));
$seg = request()->segment(1);


?>
@section('alternate-ar-link',$ar_route)
@else
    @section('alternate-ar-link', urldecode(url()->current()))
<?php
$en_link = urldecode(str_replace("/ar", "",route('user.brand-products',['name'=>str_replace([' '], '-',$brand->translate('en')->name),'id'=>$brand->id])));
?>
@section('alternate-en-link',$en_link)
@endif
@section('content')
<main class="search-holder">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{route('user.home')}}">@lang('home.home')
          </a>
        </li>
        <li class="breadcrumb-item ">
          @lang('home.products')
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          <a href="{{route('user.brand',['name'=>str_replace([' ','/'], '-',$brand->translate('en')->name),'id'=>$brand->id])}}">
            <h1>
              {{$brand->name}}
            </h1>
          </a>
        </li>
      </ol>
    </nav>
    <div class="search-content">
      @if(ProductHorizontalAd())
      <div class="poster-wrapper" style="background: none;align-items: flex-start;">
        <a href="{{ProductHorizontalAd()->url}}" target="_blank" style="width: 100%;height: 100%">
          <img src="{{ asset('storage/'.ProductHorizontalAd()->image) }}" width="100" height="100" style="width: auto;">
        </a>
      </div>
      @endif
      <div class="row">
                <div class="col-md-4 col-lg-3">
          <div class="res-filter-icon">
            <svg
                 xmlns="http://www.w3.org/2000/svg"
                 width="24"
                 height="24"
                 viewBox="0 0 24 24"
                 >
              <path d="M1 0h22l-9 15.094v8.906l-4-3v-5.906z" />
            </svg>
          </div>
          @include('User.partials.filter_product_box')
          <div class="overlay">
            <button>x
            </button>
          </div>
        </div>
        <div class="col-md-6 col-lg-7">
        <div class="search-grid-wrapper" id="search-grid-content">
            <div class="product-box-view">
              <h4>@lang('home.products')
                <span class="ml-10">({{$countProducts}})</span>
              </h4>
              @if(count($products))
                <div class="grid-holder">
                  @foreach($products as $product)
                    @include('User.viewProducts')
                  @endforeach
                </div>
                <br>
                {{$products->links()}}
              @else
                <h3>@lang('home.noProductSearch')</h3>
              @endif
            </div>
          </div>
        </div>
        </div>
        @if(ProductVerticalAd())
        <div class="col-md-2 col-lg-2 poster-y-wrapper" style="margin-top: 150px;background: none;align-items: flex-start;">
          <a href="{{ProductVerticalAd()->url}}" target="_blank" >
          <img src="{{ asset('storage/'.ProductVerticalAd()->image) }}" width="100" height="100" style="width: 100%;height: auto;">
          </a>
          </div>
        @endif
      </div>
    </div>
  </div>
</main>
@endsection
