@extends('User.partials.index')
@section('page-title', $product->title)
@section('page-description', $product->description_meta)
@section('page-keywords', $product->keywords_meta)
@section('page-image',asset('storage/'.$product->image))
@section('canonical-link',urldecode(url()->current()) )
@if(App::isLocale('en'))
  @section('alternate-en-link', urldecode(url()->current()))
<?php
$ar_route = urldecode(route('user.product',['name'=>str_replace([' '], '-','ar/'.$product->translate('ar')->name),'brand'=>str_replace([' ','/'], '-',$product->brand?$product->brand->translate('ar')->name:'brand'),'id'=>$product->id]));
$seg = request()->segment(1);


?>
@section('alternate-ar-link',$ar_route)
@else
    @section('alternate-ar-link', urldecode(url()->current()))
<?php
$en_link = urldecode(str_replace("/ar", "",route('user.product',['name'=>str_replace([' ','/'], '-',$product->translate('en')->name),'brand'=>str_replace([' ','/'], '-',$product->brand?$product->brand->translate('en')->name:'brand'),'id'=>$product->id])));
?>
@section('alternate-en-link',$en_link)
@endif
@section('content')
@include('User.Modals.login')
<main class="product-holder">
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
          {{$product->name}}
          </h1>
        </li>
      </ol>
    </nav>
    <div class="product-content">
      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="view-proudct-wrapper row">
            <section class="slider-single-img col-12 m-auto" data-rtl="{{App::isLocale('ar')?true:false}}">
              <div>
                <img
                     data-src="{{ asset('storage/'.$product->image) }}"
                     alt="{{$product->alt}}"
                     class="lazyload"
                     />
              </div>
              @foreach($product->images as $img)
              <div>
                <img
                     data-src="{{ asset('storage/'.$img->path) }}"
                     alt="{{$product->alt}}"
                     class="lazyload"
                     />
              </div>
              @endforeach
            </section>
            <section class="slider-multi-img col-12" data-rtl="{{App::isLocale('ar')?true:false}}">
              @if(count($product->images))
              <div>
                <img
                     data-src="{{ asset('storage/'.$product->image) }}"
                     alt="{{$product->alt}}"
                     />
              </div>
              @endif
              @foreach($product->images as $img)
              <div>
                <img
                     data-src="{{ asset('storage/'.$img->path) }}"
                     alt="product img"
                     class="lazyload"
                     />
              </div>
              @endforeach
            </section>
          </div>
        </div>
        <div class="col-md-6 mb-4 product-details-wrapper">
          <h1 style="line-height: 1.7">{{$product->name}}
          </h1>
          <div class="sku">
            <h5>@lang('home.sku'):
            </h5>
            <span>{{$product->sku_code}}
            </span>
          </div>
          <div class="brand">
            <h5>@lang('home.brand') :
            </h5>
            @if($product->brand)
            <a href="{{route('user.brand',['name'=>str_replace([' ','/'], '-',$product->brand->translate('en')->name),'id'=>$product->brand->id])}}">
              <img width="100" class="lazyload"  data-src="{{ asset('storage/'.$product->brand->image) }}" alt="{{$product->brand?$product->brand->alt:'--'}}"/>
            </a>
            @endif
          </div>
            @if($product->pdf !=null)
          <div class="sku">
            <a style="width: 100%" href="{{ asset('storage/'.$product->pdf) }}" target="_blank" download="{{$product->pdf}}" class="secondary-fill download-doc md-btn btn-lg">@lang('home.downloadPDF')
            </a>
          </div>
            @endif
          <div class="share-wrapper">
            <img style="margin-left: 10px; " data-src="{{ asset('frontend_plugins/web/images/facebook-app-symbol.svg')}}" data-js="facebook-share" alt="facebook-share-icon" class="lazyload"/>
                 <span style="font-size:22px">@lang('home.share')</span>
          </div>
          <div class="product-action-btn mt-1 mt-md-5">
              @if(!is_null($product->getBestRankCompany()))
            <a
              data-telephone="tel:{{$product->getBestRankCompany()}}"
              class="primary-dark-fill text-nowrap m-2 call-company call-tel-style yellow-rounded"
              >
              <span class="text"><img src="{{ asset('frontend_plugins/web/images/phone-call-blue.svg')}}"
                width="20" class="mr-2 d-inline" alt="phone">@lang('home.callNow')</span>
              <span class="tel">{{$product->getBestRankCompany()}}</span>
            </a>
              @endif
            @if(isLogged())
            <a
            data-toggle="modal"
            data-target="#bestpriceModal"
            data-route="{{route('user.product.rfq.best',$product->id)}}"
            data-brand="{{$product->brand?$product->brand->name:''}}"
            data-product="{{$product->name}}"
            data-sku="{{$product->sku_code}}"
            data-image="{{asset('storage/'.$product->image)}}"
            style="color:#fff"
            class="primary-dark-fill primary-rounded m-2 bet-best-price-product">
                <img width="22" class="mr-2 d-inline" src="{{ asset('frontend_plugins/web/images/Get-Price-icon.png')}}"
                alt="">@lang('home.bestPrice')</a>
            @else
            <a data-toggle="modal" data-target="#LoginModal" style="color:#fff" class="primary-dark-fill primary-rounded m-2">
                <img width="22" class="mr-2 d-inline" src="{{ asset('frontend_plugins/web/images/Get-Price-icon.png')}}"
                alt="">@lang('home.bestPrice')</a>
            @endif
        </div>
        </div>

        <div class="col-12">
          <div class="product-available-wrapper">
            <button class="primary-fill lg-btn">
              @lang('home.productAvailable')
            </button>
            <div class="product-available-list">

              @if(count($product->companyProducts))
                @foreach($product->companyProducts as $companyProduct)
                    <div style="display:none" class="quantity-holder">
                        <h5>@lang('home.quantity')</h5>
                        <div class="qty">
                            <span class="minus">-</span>
                            <input type="number" class="count" value="1" min="1" max="{{$companyProduct->qty}}"/>
                            <span class="plus">+</span>
                            <p class="text-danger d-none warning-max-msg">
                                @lang('home.orderMoreThanInStock')
                            </p>
                        </div>
                    </div>
                  <div class="product-available-card">
                    <div class="product-available--info">
                      <div class="img-holder">
                        <a href="{{route('user.company',['name'=>str_replace([' ','/'], '-',$companyProduct->company->translate('en')->name),'id'=>$companyProduct->company->id])}}" class="logo-holder">
                          <img data-src="{{ asset('storage/'.$companyProduct->company->logo) }}" alt="{{$companyProduct->company->alt}}" class="lazyload"/>
                        </a>
                      </div>
                      <h4 class="product-available__name">{{$companyProduct->company->name}}</h4>
                    </div>

                    <div class="product-available--contact">
                      <a href="tel:{{$companyProduct->company->pri_contact_phone}}" class="primary-dark-fill w-100 sm-btn text-nowrap call-tel-style">
                        <span class="text"><img src="{{ asset('frontend_plugins/web/images/phone-call.svg')}}" width="17" class="mr-2 d-inline" alt="phone">@lang('home.callCompanyNow')</span>
                        <span class="tel">{{$companyProduct->company->pri_contact_phone}}</span>
                      </a>

                      {{--<a style="color:white" data-telephone="tel:{{$company->pri_contact_phone}}"
                        class="primary-dark-fill w-100 sm-btn text-nowrap call-company call-tel-style"
                        data-route="{{route('user.company-call')}}" data-company="{{$company->id}}" data-company-name="{{$company->name}}">
                         <span class="text"><img src="{{ asset('frontend_plugins/web/images/phone-call.svg')}}" width="17" class="mr-2 d-inline" alt="phone">@lang('home.callCompanyNow')</span>
                         <span class="tel">{{$company->pri_contact_phone}}</span>
                     </a>--}}

                      <a href="https://api.whatsapp.com/send?phone={{$companyProduct->company->pri_contact_phone}}" target="_blank" class="whatsapp-fill w-100 sm-btn">
                        <img src="{{ asset('frontend_plugins/web/images/whatsapp.svg')}}" class="mr-2"
                             width="19" alt=""/>@lang('home.sendWhatsapp')
                      </a>

                      <a @if(Auth::check()) href="#"  class="yellow-fill w-100 sm-btn sendrfq" @else  href="{{route('login')}}"  class="yellow-fill w-100 sm-btn"  @endif data-company="{{$companyProduct->company->id}}" data-product="{{$companyProduct->id}}">
                        <img src="{{ asset('frontend_plugins/web/images/RFQ-Icon.png')}}" class="mr-2" width="19" alt=""/>
                        @lang('home.requestForQuotationNow')
                      </a>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
          </div>
        </div>
        {{--<div class="col-12">
          <div class="seller-list-wrapper">
              @if(count($product->companyProducts))
                @foreach($product->companyProducts as $companyProduct)
                    <div>
                      <a href="{{route('user.company',['name'=>str_replace([' ','/'], '-',$companyProduct->company->translate('en')->name),'id'=>$companyProduct->company->id])}}" class="logo-holder">
                        <img data-src="{{ asset('storage/'.$companyProduct->company->logo) }}" alt="{{$companyProduct->company->alt}}" class="lazyload" />
                      </a>
                      <div class="seller-name">
                        <h5>@lang('home.seller')
                        </h5>
                        <a style="color: #2e2e2e" href="{{route('user.company',['name'=>str_replace([' ','/'], '-',$companyProduct->company->translate('en')->name),'id'=>$companyProduct->company->id])}}" class="logo-holder">
                          <p  class="name">{{$companyProduct->company->name}}</p>
                        </a>
                      </div>
                      <div class="price">
                        <h5>@lang('home.price')
                        </h5>
                        <p>{{$companyProduct->price}}@lang('home.currency')
                        </p>
                      </div>
                      <div class="stock-holder">
                        <h5>@lang('home.inStock')
                        </h5>
                        <p class="stock-num">{{$companyProduct->qty}}
                        </p>
                      </div>
                      <div style="display:none" class="quantity-holder">
                            <h5>@lang('home.quantity')</h5>
                            <div class="qty">
                                <span class="minus">-</span>
                                <input type="number" class="count" value="1" min="1" max="{{$companyProduct->qty}}"/>
                                <span class="plus">+</span>
                                <p class="text-danger d-none warning-max-msg">
                                    @lang('home.orderMoreThanInStock')
                                </p>
                            </div>
                      </div>
                      <div class="action-holder">
                            --}}{{-- @if(isLogged()) --}}{{--
                              <a
                                style="color:white" data-telephone="tel:{{$companyProduct->company->pri_contact_phone}}"
                                 class="primary-dark-fill mr-20  text-nowrap call-company call-tel-style"
                                 data-route="{{route('user.company-call')}}" data-company="{{$companyProduct->company->id}}">
                                  <!-- call-tel-style -->
                                  <span class="text"><img src="{{ asset('frontend_plugins/web/images/phone-call.svg')}}" width="17" class="mr-2 d-inline" alt="phone">@lang('home.callCompanyNow')</span>
                                  <span class="tel">{{$companyProduct->company->pri_contact_phone}}
                                  </span>
                              </a>
                          --}}{{-- @else

                              <a style="color:white" data-product="{{$product->id}}" data-pname="{{$product->name}}" data-bname="{{$product->brand->name}}" data-toggle="modal" data-target="#LoginModal"
                                 class="primary-dark-fill mr-20  text-nowrap productlog">
                                                    <span class="text">@lang('home.callCompanyNow')</span>
                              </a>
                            @endif --}}{{--
                        --}}{{-- <button class="primary-dark-fill add-cart-btn">
                          @lang('home.addToCart')
                          <img
                               class="ml-10 lazyload"
                               data-src="{{ asset('frontend_plugins/web/images/shopping-cart.svg')}}"
                               alt="shopping-cart-icon"
                               />
                        </button> --}}{{--
                      </div>
                    </div>
                @endforeach
              @else
              <div>
                  <div style="display: none;" class="quantity-holder">
                        <h5>@lang('home.quantity')
                        </h5>
                        <div class="qty">
                          <span class="minus">-
                          </span>
                          <input
                                 type="number"
                                 class="count"
                                 value="1"
                                 min="1"
                                 max="1"
                                 />
                          <span class="plus">+
                          </span>
                          <p class="text-danger d-none warning-max-msg">
                            @lang('home.orderMoreThanInStock')
                          </p>
                        </div>
                      </div>
              </div>
              @endif
          </div>
        </div>--}}
        <div class="col-12 ">
          <div class="product-des-wrapper">
            <h4>@lang('home.descriptionOfProduct')
            </h4>
            <p style="line-height: 1.88">{!!$product->description!!}
            </p>
          </div>
        </div>
        <div class="col-12 ">
          <div class="product-spec-wrapper">
            <h4>@lang('home.specifications')
            </h4>
            <div class="row">
              @if(count($product->specifications))
              @foreach($product->specifications as $specific)
              <div class="col-sm-5">{{$specific->specification->name}}
              </div>
              <div class="col-sm-7">{{$specific->value}}
              </div>
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
          <div class="related-product">
            <div class="slider-heading">
              <h3>@lang('home.RelatedProducts')
              </h3>
            </div>
            <div class="content">
              <div class="products-slider">
                @foreach($releatedProducts as $product)
                @if($product)
                  @include('User.viewProducts')
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
    <input type="hidden" id="token" value="{{csrf_token()}}" />
</main>
@push('script')
<script src="{{ asset('frontend_plugins/web/javascript/product.js') }}"></script>
    <script>
        $(".productlog").on('click',function (){
            var p_name = $(this).data('pname');
            var p_id = $(this).data('product');
            var b_name = $(this).data('bname');

            $("#pro_name").val(p_name);
            $("#pro_id").val(p_id);
            $("#bra_name").val(b_name);

        });


    </script>


    <script>

        $(".sendrfq").on('click',function (){
            var company_id = $(this).data('company');
            var product_id = $(this).data('product');
            var _token = $("#token").val();

            $.ajax({

                url: "{{route('user.product-rfq')}}",
                method: "post",
                data: {company_id:company_id,_token:_token,product_id:product_id},
                success:function (data) {

                  if(data === 0){
                      toastr.error("You already Sent A RFQ");

                  }else{
                      toastr.success("RFQ Sent Successfully");

                  }


                }


            });



        });


    </script>
@endpush
@endsection
