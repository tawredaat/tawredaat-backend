@extends('User.partials.index')
@section('page-title', __('home.filterProducts'))
@section('page-description', $setting->Meta_Description)
@section('page-image', asset('storage/'.$setting->site_logo))
<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
@section('canonical-link', $actual_link)

@section('pagination-links')
    @if($products->previousPageUrl() != null)

        <link rel="prev" href="{{urldecode($products->previousPageUrl())}}"/>

    @endif
    @if($products->nextPageUrl() != null)

        <link rel="next" href="{{urldecode($products->nextPageUrl())}}"/>

    @endif
@endsection

@if(App::isLocale('en'))
    @section('alternate-en-link', url()->current())
<?php
$seg = request()->segment(1);
?>
@section('alternate-ar-link', str_replace($seg, 'ar/'.$seg,url()->current()))
@else
    @section('alternate-ar-link', url()->current())
<?php
$en_link = str_replace("/ar", "", url()->current());
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
                        @if($key)
                            @lang('home.resultsIn') :
                            {{$key}}
                        @elseif($company)
                            @lang('home.resultsIn') :
                            {{$company->name}}
                        @elseif($brand)
                            @lang('home.resultsIn') :
                            {{$brand->name}}
                        @elseif($category_name)
                            @lang('home.resultsIn') :
                            {{$category_name->name}}
                        @endif
                    </li>
                </ol>
            </nav>
            <div class="search-content">
                @if(ProductHorizontalAd())
                    <div class="poster-wrapper" style="background: none;align-items: flex-start;">
                        <a href="{{ProductHorizontalAd()->url}}" target="_blank" style="width: 100%;height: 100%">
                            <img src="{{ asset('storage/'.ProductHorizontalAd()->image) }}" width="100" height="100"
                                 style="width: auto;">
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
                                <path d="M1 0h22l-9 15.094v8.906l-4-3v-5.906z"/>
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
                                <ul class="filter-group" style="margin: 0 0 10px;padding: 0;list-style: none;">
                                    @if($filterd_brands)
                                    @foreach($filterd_brands as $br)
                                        <li class="selected-refinment"
                                            style="display: inline-block;margin-bottom: 3px;">
                        <span
                            style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                            {{$br->name}}
                            <a href="#" data-brand="{{$br->id}}" class="remove-filer-products"
                               style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                        </span>
                                        </li>
                                    @endforeach
                                    @endif
                                    @if($filterd_categories)
                                    @foreach($filterd_categories as $cg)
                                        <li class="selected-refinment"
                                            style="display: inline-block;margin-bottom: 3px;">
                        <span
                            style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                            {{$cg->name}}
                            <a href="#" data-category="{{$cg->id}}" class="remove-filer-products"
                               style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                        </span>
                                        </li>
                                    @endforeach
                                    @endif
                                    @if($filterd_countries)
                                    @foreach($filterd_countries as $cn)
                                        <li class="selected-refinment"
                                            style="display: inline-block;margin-bottom: 3px;">
                        <span
                            style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                            {{$cn->name}}
                            <a href="#" data-country="{{$cn->id}}" class="remove-filer-products"
                               style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                        </span>
                                        </li>
                                    @endforeach
                                    @endif
                                    @if($filterd_companies)
                                    @foreach($filterd_companies as $cm)
                                        <li class="selected-refinment"
                                            style="display: inline-block;margin-bottom: 3px;">
                        <span
                            style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                            {{$cm->name}}
                            <a href="#" data-company="{{$cm->id}}" class="remove-filer-products"
                               style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                        </span>
                                        </li>
                                    @endforeach
                                    @endif
                                    @if($filterd_specifications)
                                    @foreach($filterd_specifications as $sp)
                                        <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                                            <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                                                {{($sp->specification?$sp->specification->name:' ').' : '.$sp->value}}
                                                <a href="#" data-specification="{{$sp->id}}" class="remove-filer-products"
                                                style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                                            </span>
                                        </li>
                                    @endforeach
                                    @endif
                                    @if($toPrice)
                                        <li>
                                            <span
                                                style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                                                {{__('home.fromPrice').' ('.$fromPrice.') ' . __('home.fromPrice') .' ('. $toPrice.')'}}
                                                <a href="#" data-price="1" class="remove-filer-products"
                                                style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
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
                    @if(ProductVerticalAd())
                        <div class="col-md-2 col-lg-2 poster-y-wrapper"
                             style="margin-top: 150px;background: none;align-items: flex-start;">
                            <a href="{{ProductVerticalAd()->url}}" target="_blank">
                                <img src="{{ asset('storage/'.ProductVerticalAd()->image) }}" width="100" height="100"
                                     style="width: 100%;height: auto;">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
