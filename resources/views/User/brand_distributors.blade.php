@extends('User.partials.index')
@section('page-title', $brand->distributors_title)
@section('page-keywords', $brand->distributors_keywords)
@section('page-description',$brand->distributors_description)
@section('page-image', asset('storage/'.$setting->site_logo))
@section('canonical-link', url()->current())
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
<main class="brand-holder">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{route('user.home')}}">@lang('home.home')
          </a>
        </li>
        <li class="breadcrumb-item">
          <a href="{{route('user.brands')}}">@lang('home.brands')
          </a>
        </li>
        <li class="breadcrumb-item" aria-current="page">{{$brand->name}}
        </li>
        <li class="breadcrumb-item" aria-current="page">@lang('home.distributor')
        </li>
        <li class="breadcrumb-item active" aria-current="page">@lang('home.browseAll')
        </li>
      </ol>
    </nav>
    <div class="brand-content">
      <div class="row">
        <div class="col-md-12 col-lg-12  brand-info-wrapper">
          <div class="brand-logo-holder">
            <img src="{{ asset('storage/'.$brand->image) }}" alt="{{$brand->alt}}" />
          </div>
          <div class="details-holder">
            <div class="name">
              <img src="{{ asset('frontend_plugins/web/images/right-mark.png')}}" alt="right-mark-icon" /> 
              <h1>
                {{$brand->name}}
              </h1>
            </div>
            <div class="country">
              @if($brand->country)
              <img width="50" src="{{ asset('storage/'.$brand->country->flag) }}" alt="{{$brand->country->name}}" /> {{$brand->country->name}}
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        @if(count($companies))
            @foreach($companyBrandTypes as $type)
            @if(count($type->types))
            <div class="col-12">
                <div class="related-brand">
                  <div class="slider-heading">
                    <h3>{{$type->name}}</h3>
                  </div>
                  <div class="content">
                    <div class="brands-slider">
                      @foreach($companies as $c)
                      @php $company = $c->company; @endphp
                      @if($company and  $c->company_type_id==$type->id)

                          @include('User.viewCompanies')
                      @endif
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
              @endif
            @endforeach
        @else
            <div class="col-12">
                <div class="related-brand">
                  <div class="" style="text-align: center;">
                    <h3>{{$brand->name}}  @lang('home.hasNoDistributors')</h3>
                  </div>
                </div>
              </div>
        @endif
      </div>
    </div>
  </div>
</main>
@push('script')
<script src="{{ asset('frontend_plugins/web/javascript/brand.js') }}"></script>
@endpush
@endsection
