@extends('User.partials.index')
@section('page-title', $brand->title)
@section('page-description', $brand->description_meta)
@section('page-keywords', $brand->keywords_meta)
@section('page-image', asset('storage/'.$brand->image))
@section('canonical-link',urldecode(url()->current()) )
@if(App::isLocale('en'))
    @section('alternate-en-link',urldecode(url()->current()) )
<?php
$ar_route = urldecode(route('user.brand',['name'=>str_replace([' '], '-','ar/'.$brand->translate('ar')->name),'id'=>$brand->id]));
$seg = request()->segment(1);


?>
@section('alternate-ar-link',$ar_route)
@else
    @section('alternate-ar-link', urldecode(url()->current()))
<?php
$en_link =urldecode(str_replace("/ar", "",route('user.brand',['name'=>str_replace([' ','/'], '-',$brand->translate('en')->name),'id'=>$brand->id]))) ;
?>
@section('alternate-en-link',$en_link)
@endif

@section('content')
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
        <li class="breadcrumb-item active" aria-current="page">{{$brand->name}}
        </li>
      </ol>
    </nav>
    <div class="brand-content">
      <div class="row">
        <div class="col-md-9 col-lg-8  brand-info-wrapper">
          <div class="brand-logo-holder">
            <img data-src="{{ asset('storage/'.$brand->image) }}" class="lazyload"  alt="{{$brand->alt}}" />
          </div>
          <div class="details-holder">
            <div class="name">
              <img data-src="{{ asset('frontend_plugins/web/images/right-mark.png')}}" class="lazyload"  alt="right-mark-icon" /> 
              <h1>
                {{$brand->name}}
              </h1>
            </div>
            <div class="country">
              @if($brand->country)
              <img width="50" data-src="{{ asset('storage/'.$brand->country->flag) }}" class="lazyload"  alt="{{$brand->country->name}}" /> {{$brand->country->name}}
              @endif
            </div>
          </div>
          <div
               id="accordion"
               class="accordion-wrapper"
               role="tablist"
               aria-multiselectable="true"
               >
            <!-- Accordion Item 1 -->
            <div class="overview-holder">
              <div class="card-header" role="tab" id="accordionHeadingOne">
                <div class="mb-0 row">
                  <div class="col-12 no-padding accordion-head">
                    <a
                       data-toggle="collapse"
                       data-parent="#accordion"
                       href="#accordionBodyOne"
                       aria-expanded="false"
                       aria-controls="accordionBodyOne"
                       class="collapsed"
                       >
                      <h3>@lang('home.overview')
                      </h3>
                      <div class="plusMinus-icon">
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              <div
                   id="accordionBodyOne"
                   class="collapse"
                   role="tabpanel"
                   aria-labelledby="accordionHeadingOne"
                   aria-expanded="false"
                   data-parent="accordion"
                   >
                <div class="card-block col-12 pb-3">
                  <p>
                    @if(isset($company->description)){!! $company->description !!}@endif
                    @if(isset($brand->description)){!! $brand->description !!}@endif
                  </p>
                </div>
              </div>
            </div>
            <!-- Accordion Item 2 -->
            <div class="categories-holder">
              <div class="card-header" role="tab" id="accordionHeadingTwo">
                <div class="mb-0 row">
                  <div class="col-12 no-padding accordion-head">
                    <a
                       data-toggle="collapse"
                       data-parent="#accordion"
                       href="#accordionBodyTwo"
                       aria-expanded="true"
                       aria-controls="accordionBodyTwo"
                       class="collapsed"
                       >
                      <h3>@lang('home.categories')
                      </h3>
                      <div class="plusMinus-icon">
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              <div
                   id="accordionBodyTwo"
                   class="collapse"
                   role="tabpanel"
                   aria-labelledby="accordionHeadingTwo"
                   aria-expanded="false"
                   data-parent="accordion"
                   >
                <div class="card-block col-12">
                  <div class="row categories-link mt-3">
                    @foreach($categories as $category)
                    <div class="col-md-6 col-lg-4">
                      <a href="{{route('user.BrandCategory',['name'=>str_replace([' ','/'], '-',$category->translate('en')->name),'id'=>$category->id])}}" class="primary-fill">{{$category->name}}
                      </a>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
            @if(count($keywords))
            <!-- Accordion Item 3 -->
            <div class="tags-holder">
              <div class="card-header" role="tab" id="accordionHeadingThree">
                <div class="mb-0 row">
                  <div class="col-12 no-padding accordion-head">
                    <a
                       data-toggle="collapse"
                       data-parent="#accordion"
                       href="#accordionBodyThree"
                       aria-expanded="true"
                       aria-controls="accordionBodyThree"
                       class="collapsed"
                       >
                      <h3>@lang('home.tages')
                      </h3>
                      <div class="plusMinus-icon">
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              <div
                   id="accordionBodyThree"
                   class="collapse"
                   role="tabpanel"
                   aria-labelledby="accordionHeadingThree"
                   aria-expanded="false"
                   data-parent="accordion"
                   >
                <div class="card-block col-12">
                  <div class="tags-content">
                    @foreach($keywords as $key)
                      <div>
                        <a href="{{route('user.BrandKeywords',$brand->id).'?tag='.$key}}" class="primary-fill">{{$key}}
                        </a>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
        <div class="col-md-3 offset-lg-1  side-content-wrapper">
          <div class="box">
            <h3>@lang('home.products')
            </h3>
            <a href="{{urldecode(route('user.brand-products',['name'=>str_replace([' ','/','-'], '_',$brand->name),'id'=>$brand->id]))}}" class="primary-dark-fill">@lang('home.browseAll')
            </a>
          </div>
          <div class="box">
            <h3>@lang('home.distributor')
            </h3>
            <a href="{{urldecode(route('user.brand-companies',['name'=>str_replace([' ','/','-'], '_',$brand->translate('en')->name),'id'=>$brand->id]))}}" class="primary-dark-fill">@lang('home.browseAll')
            </a>
          </div>
          @if($brand->pdf)
          <div class="box">
            <h3>@lang('home.catalouge')
            </h3>
            <a href="{{$brand->pdf}}" target="_blank" download="" class="primary-dark-fill">@lang('home.DownloadBrand')
            </a>
          </div>
          @endif
          @if(!is_null($setting->brand_image))
              <div class="box google-box user-box-adv">
                  <img src="{{ asset('storage/'.$setting->brand_image) }}" class="lazyload" />
              </div>
          @endif
        </div>
        @if(count($relatedBrands))
        <div class="col-12">
          <div class="related-brand">
            <div class="slider-heading">
              <h3>@lang('home.RelatedBrands')
              </h3>
            </div>
            <div class="content">
              <div class="brands-slider">
                @foreach($relatedBrands as $brand)
                @if($brand)
                    @include('User.viewBrands')
                @endif
                @endforeach
              </div>
            </div>
          </div>
        </div>
        @endif
</div>
</div>
</main>
@push('script')
<script src="{{ asset('frontend_plugins/web/javascript/brand.js') }}"></script>
@endpush
@endsection
