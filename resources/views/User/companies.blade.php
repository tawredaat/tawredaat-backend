@extends('User.partials.index')
@section('page-title', __('home.companies'))
@section('page-description', $setting->Meta_Description)
@section('page-image', asset('storage/'.$setting->site_logo))
@if(Str::contains(url()->current(), 'page'))
@section('canonical-link', urldecode(urldecode(url()->current().'?page='.$companies->currentPage())))
@else
    @section('canonical-link', urldecode(urldecode(url()->current())))

@endif
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
          @lang('home.companies')
        </li>
        @if(isset($keyword))
        <li class="breadcrumb-item active" aria-current="page">
            {{$keyword}}
        </li>
        @endif
        @if(isset($category))
        <li class="breadcrumb-item active" aria-current="page">
            {{$category->name}}
        </li>
        @endif
      </ol>
    </nav>
    <div class="search-content">
      @if(CompanyHorizontalAd())
      <div class="poster-wrapper" style="background: none;align-items: flex-start;">
        <a href="{{CompanyHorizontalAd()->url}}" target="_blank" style="width: 100%;height: 100%">
          @if(!is_null(CompanyHorizontalAd()->mobileimg))
          <img data-src="{{ asset('storage/'.CompanyHorizontalAd()->mobileimg) }}" class="img-mob lazyload" width="100" height="100" style="width: auto;">
          @endif
          <img data-src="{{ asset('storage/'.CompanyHorizontalAd()->image) }}" class="lazyload" width="100" height="100" style="width: auto;">
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
            <button>x</button>
          </div>
        </div>
        <div class="col-md-6 col-lg-7">
          <div class="search-grid-wrapper" id="search-grid-content">
            <div class="company-box-view">
                <h4>@lang('home.companies')
                  <span class="ml-10"> ({{$countCompanies}})</span>
                </h4>
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
          <a href="{{CompanyVerticalAd()->url}}" target="_blank" >
            <img data-src="{{ asset('storage/'.CompanyVerticalAd()->image) }}" class="lazyload"  width="100" height="100" style="width: 100%;height: auto;">
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>
    <input id="token" type="hidden" name="_token" value="{{csrf_token()}}" />
</main>
@endsection
@push('script')
<script>
  // function sendcompanyparams(){
  //     console.log($(this));
  //     // var c_id = $(this).data('company');
  //     // var c_n = $(this).data('company-name');
  //     // console.log(c_id);
  //     // console.log(c_n);
  // }
  $(".call-company-login").on('click',function (){
    var c_id = $(this).data('company');
    var c_n = $(this).data('company-name');
    $("#cid").val(c_id);
    $("#c_name").val(c_n);
  });
</script>
    <script>
        $(".whatsClick").on('click',function (){
            var companyID = $(this).data('company');
var _token = $("#token").val();
            $.ajax({
                url: "{{route('user.company-whatsCall')}}",
                method: 'POST',
                data: {_token: _token, companyID: companyID},
                dataType: 'JSON',
                success: function (data) {


                }
                , error: function (data) {

                }

            });


        });


    </script>
@endpush
