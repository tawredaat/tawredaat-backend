@extends('User.partials.index')
@section('page-title', __('home.filterCompanies'))
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
            @if($key)
            @lang('home.resultsIn') :
            {{$key}}
            @elseif($category)
            @lang('home.resultsIn') :
            {{$category->name}}
            @elseif($keyword)
            @lang('home.resultsIn') :
            {{$keyword}}
            @endif
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
                <ul class="filter-group" style="margin: 0 0 10px;padding: 0;list-style: none;">
               @if($filterd_brands)
                @foreach($filterd_brands as $br)
                <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                    <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$br->name}}
                    <a  href="#" data-brand="{{$br->id}}" class="remove-filer-companies" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×
                    </a>
                    </span>
                </li>
                @endforeach
                @endif
                @if($filterd_categories)
                @foreach($filterd_categories as $cg)
                <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                    <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$cg->name}}
                    <a  href="#" data-category="{{$cg->id}}" class="remove-filer-companies" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×
                    </a>
                    </span>
                </li>
                @endforeach
                @endif
                @if($filterd_areas)
                @foreach($filterd_areas as $ar)
                <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                    <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$ar->name}}
                    <a  href="#" data-area="{{$ar->id}}" class="remove-filer-companies" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×
                    </a>
                    </span>
                </li>
                @endforeach
                @endif
                @if($filterd_types)
                @foreach($filterd_types as $tyb)
                <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                    <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$tyb->name}}
                    <a  href="#" data-type="{{$tyb->id}}" class="remove-filer-companies" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×
                    </a>
                    </span>
                </li>
                @endforeach
                @endif
                </ul>
                @if(count($companies))
                    <div class="grid-holder">
                    @foreach($companies as $company)
                        @include('User.viewCompanies')
                    @endforeach
                    </div>
                    {{$companies->links()}}
                @else
                    <h3>@lang('home.noCompanySearch')</h3>
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
