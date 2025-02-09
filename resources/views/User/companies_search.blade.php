@extends('User.partials.index')
@section('page-title', __('home.searchCompanies'))
@section('page-description', $setting->Meta_Description)
@section('page-image', asset('storage/'.$setting->site_logo))
<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
@section('canonical-link', $actual_link)
@section('pagination-links')
@if($companies->previousPageUrl() != null)
<link rel="prev"  href="{{urldecode($companies->previousPageUrl())}}" />
@endif
@if($companies->nextPageUrl() != null)
<link rel="next"  href="{{urldecode($companies->nextPageUrl())}}" />
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
$en_link = str_replace("/ar", "",url()->current());
?>
@section('alternate-en-link',$en_link)
@endif
@section('content')
@include('User.Modals.login')
<main class="search-holder">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{route('user.home')}}">@lang('home.home')
          </a>
        </li>
        <li class="breadcrumb-item">
          <a href="{{route('user.companies')}}">@lang('home.companies')
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          @lang('home.search')
        </li>
      </ol>
    </nav>
    <div class="search-content">
      @if(CompanyHorizontalAd())
      <div class="poster-wrapper" style="background: none;align-items: flex-start;">
        <a href="{{CompanyHorizontalAd()->url}}" target="_blank" style="width: 100%;height: 100%">
          <img src="{{ asset('storage/'.CompanyHorizontalAd()->image) }}" width="100" height="100" style="width: auto;">
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
          @include('User.partials.filter_company_box')
          <div class="overlay">
            <button>x
            </button>
          </div>
        </div>
        <div class="col-md-6 col-lg-7">
          <div class="search-grid-wrapper" id="search-grid-content">
            <div class="company-box-view">
              <h4>@lang('home.companies')
                <span class="ml-10"> ({{$countCompanies}})
                </span>
              </h4>
              @if(count($companies))
              <div class="grid-holder">
                @foreach($companies as $company)
                   @include('User.viewCompanies')
                @endforeach
              </div>
              {{$companies->links()}}
              @else
              <h3>@lang('home.noCompanySearch')
              </h3>
              @endif
            </div>
          </div>
        </div>
        @if(CompanyVerticalAd())
        <div class="col-md-2 col-lg-2 poster-y-wrapper" style="margin-top: 150px;background: none;align-items: flex-start;">
          <a href="{{CompanyVerticalAd()->url}}" target="_blank" style="width: 100%;height: 100%">
            <img src="{{ asset('storage/'.CompanyVerticalAd()->image) }}" width="100" height="100" style="width: 100%;height: auto;">
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>
</main>
@endsection
