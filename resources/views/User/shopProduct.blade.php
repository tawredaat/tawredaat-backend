@extends('User.partials.index')
@section('page-title', __('home.shop').' | '. $product->name)
@section('page-image', asset('storage/'.$setting->site_logo))
@section('content')
<!-- start page content -->
<main class="blog-holder">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb px-0">
        <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('user.shop.products') }}">@lang('home.shop')</a></li>
        <li class="breadcrumb-item"><a href="{{route('user.shop.categories.view.all')}}">@lang('home.categories')</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$product->name}}
        </li>
      </ol>
    </nav>
  </div>
  <div class="shop-category-wrapper">
    <div class="container">
        <div class="row">
          <div class="col-md-6 mb-4">
            <div class="view-proudct-wrapper row">
                <section class="slider-single-img col-12 m-auto" data-rtl="{{App::isLocale('ar')?true:false}}">
                    <div>
                        <img style="width:100%" data-src="{{ $product->image }}" alt="{{$product->alt}}" class="lazyload" />
                    </div>
                    @foreach($product->images as $img)
                        <div>
                            <img style="width:100%" data-src="{{ asset('storage/'.$img->path) }}" alt="{{$product->alt}}"class="lazyload" />
                        </div>
                    @endforeach
                </section>
                @if(count($product->images))
                    <section class="slider-multi-img col-12" style="margin-top:50px;" data-rtl="{{App::isLocale('ar')?true:false}}">
                            <div>
                                <img style="width:100%;padding:0 5px;" data-src="{{ $product->image  }}" alt="{{$product->alt}}" class="lazyload" />
                            </div>
                        @foreach($product->images as $img)
                            <div>
                                <img style="width:100%;padding:0 5px;" data-src="{{ asset('storage/'.$img->path) }}" alt="{{$product->alt}}" class="lazyload" />
                            </div>
                        @endforeach
                    </section>
                @endif
            </div>
          </div>
          <div class="col-md-6 mb-4 product-details-wrapper product-shop-details-wrapper">

            <h1 style="line-height: 1.7">{{$product->name}}</h1>
            @if($product->sku_code)
                <div class="sku">
                <h5>@lang('home.sku'): </h5>
                <span>{{$product->sku_code}} </span>
                </div>
            @endif
            <div class="brand">
              <h5>@lang('home.brand') : </h5>
              @if($product->brand)
                <img width="100" class="lazyload"  data-src="{{ asset('storage/'.$product->brand->image) }}" alt="{{$product->brand?$product->brand->alt:'--'}}"/>
              @endif
            </div>

            @if($product->pdf !=null)
                <div class="sku">
                    <a style="width: 100%" href="{{$product->pdf}}" target="_blank" download="{{$product->pdf}}" class="secondary-fill download-doc md-btn btn-lg">@lang('home.downloadPDF')</a>
                </div>
            @endif

            <div class="share-wrapper">
              <img style="margin-left: 10px; " data-src="{{ asset('frontend_plugins/web/images/facebook-app-symbol.svg')}}" data-js="facebook-share" alt="facebook-share-icon" class="lazyload"/>
              <span style="font-size:22px">@lang('home.share')</span>
            </div>

            <br>
            <div class="price">
                @lang('home.price'): <span>{{$product->new_price}}@lang('home.currency')/{{$product->quantity_type}}</span>
                <br>
                {{-- @if($product->old_price && $product->old_price > $product->new_price)
                    <span class="price" style="text-decoration: line-through;">
                    {{$product->old_price}}@lang('home.currency')/{{$product->quantity_type}}
                    </span>
                @endif --}}
            </div>
            <div class="product-card single-shop-product-page product-action-btn mt-1">
                @if(auth('web')->check())
                    @include('User.partials.cart_component_for_single_item')
                @else
                    @include('User.partials.cart_component_for_single_item_for_guest')
                @endif
            </div>
          </div>
          <div class="col-12 ">
            <div class="product-des-wrapper">
              <h4>@lang('home.descriptionOfProduct')</h4>
              @if($product->description)
                    <p style="line-height: 1.88">{!! $product->description !!}</p>
              @else
                    <p style="line-height: 1.88">@lang('home.thisProductHasNoDescription')</p>
              @endif
            </div>
          </div>
          <div class="col-12 ">
            <div class="product-spec-wrapper">
              <h4>@lang('home.specifications')
              </h4>
              <div class="row">
                @if(count($product->specifications))
                    @foreach($product->specifications as $specific)
                        <div class="col-sm-5">{{$specific->specification}}</div>
                        <div class="col-sm-7">{{$specific->value}}</div>
                    @endforeach
                @else
                <h5>
                     @lang('home.productHasNoSpecific')
                </h5>
                @endif
              </div>
            </div>
          </div>
            @if(count($releatedProducts))
                <div class="col-12">
                    <div class="related-product" style="margin:50px 0;">
                        <div class="slider-heading">
                            <h3>@lang('home.RelatedProducts')</h3>
                        </div>
                        <div class="content">
                            <div class="products-slider">
                                @foreach($releatedProducts as $product)
                                    @if($product)
                                        @include('User.viewShopProducts')
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
@push('script')
<script src="{{ asset('frontend_plugins/web/javascript/product.js') }}"></script>
@endpush
