@extends('User.partials.index')
@section('page-title', isset($categoryTitle)?$categoryTitle:__('home.filterCategories'))

@section('page-image', asset('storage/'.$setting->site_logo))



@if($categoryMetaDesc !=null)
    @section('page-description',$categoryMetaDesc)
@else
    @section('page-description', $setting->Meta_Description)
    @endif

@if($categoryMetakeywords !=null)
    @section('page-keywords', $categoryMetakeywords)
@else
    @section('page-keywords', $setting->keywords)
@endif
@if(Str::contains(url()->current(), 'page'))
@section('canonical-link', urldecode(urldecode(url()->current().'?page='.$products->currentPage())))
@else
    @section('canonical-link', urldecode(urldecode(url()->current())))
@endif


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

$ar_route =urldecode(route('user.filter-by-category1',['name'=>str_replace([' '], '-','ar/'.$categoryArName),'id'=>$categoryID]));
?>
@section('alternate-ar-link',$ar_route)
@else
    @section('alternate-ar-link', urldecode(url()->current()))
<?php
$en_route =urldecode(route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$categoryEnName),'id'=>$categoryID]));
$en_link = str_replace("/ar", "",$en_route);
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
        <li class="breadcrumb-item">
          <a href="{{route('user.products')}}">@lang('home.products')
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          <h1>  
            {{isset($categoryTitle)?$categoryTitle:''}}
          </h1>
        </li>
      </ol>
    </nav>
    <div class="search-content">
    @if(isset($categoryID) AND CategoryHorizontalAd($categoryID))
          <div class="poster-wrapper">
            <a href="{{CategoryHorizontalAd($categoryID)->url}}" target="_blank" style="width: 100%;height: 100%">
                @if(!is_null(CategoryHorizontalAd($categoryID)->mobileimg))
                    <img src="{{ asset('storage/'.CategoryHorizontalAd($categoryID)->mobileimg) }}" class="img-mob" width="100" height="100" style="width: 100%;height: 100%">
                @endif
              <img src="{{ asset('storage/'.CategoryHorizontalAd($categoryID)->image) }}" width="100" height="100" style="width: 100%;height: 100%">
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
        @if(isset($categoryID) AND CategoryVerticalAd($categoryID))
        <div class="col-md-2 col-lg-2 poster-y-wrapper">
          <a href="{{CategoryVerticalAd($categoryID)->url}}" target="_blank" style="width: 100%;height: 100%">
          <img src="{{ asset('storage/'.CategoryVerticalAd($categoryID)->image) }}" width="100" height="100" style="width: 100%;height: 100%">
          </a>
          </div>
        @endif
      </div>
    </div>
  </div>
</main>
@endsection
