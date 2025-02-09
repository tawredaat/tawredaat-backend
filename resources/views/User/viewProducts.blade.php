<div class="product-card card">
    <a href="{{urldecode(route('user.product',['name'=>urlencode(str_replace([' ','/'], '-',$product->name)),'brand'=>urldecode(str_replace([' ','/'], '-',$product->brand?$product->brand->name:'brand')),'id'=>$product->id]))}}" class="product-card card">
    {{--<img
      width="500" height="400" style="height: 300px"
       class="img-fluid"
       src="{{ asset('storage/'.$product->image) }}"
       alt="{{$product->alt}}"
       />--}}
<div class="card-img" style="height: 180px;background-image:url('{{asset('storage/'.$product->image)}}');background-size: cover;    background-position-x: center; ">
</div>
<br>
  <h5 title="{{$product->name}}" style="">{{$product->name}}</h5>
  @php
  $prices   = [];
  $minPrice = null;
  $minUnit  = null;
  @endphp
  @foreach($product->companyProducts as $companyProduct)
    <!-- Caclulate Discount value -->
      @if($companyProduct->discount_type=='percentage')
            @php
              $finalPrice = $companyProduct->price-(($companyProduct->price*$companyProduct->discount)/100);
            @endphp
      @else
          @php
            $finalPrice = $companyProduct->price-$companyProduct->discount;
          @endphp
      @endif
    <!-- end calculate discount value -->
  @if($finalPrice)
        @php
          array_push($prices,$finalPrice);
          $minPrice = min($prices);
        @endphp
      @if($minPrice==$finalPrice)
        @php $minUnit= $companyProduct->unit?'/'.$companyProduct->unit->name:'';  @endphp
      @endif
  @endif
  <!-- <br> -->
  @if($companyProduct->discount and($minPrice==$finalPrice))
    <span style="text-decoration: line-through;text-align: center;color: #bac4d9;font-size: 18px;">{{$companyProduct->price}}@lang('home.currency'){{$minUnit}}</span>
  @endif
  @endforeach
  @if($minPrice)
  <div class="price">
    {{$minPrice}}@lang('home.currency'){{$minUnit}}
  </div>
  @endif
</a>
@if($product->brand)
    <div class="brand">
        <h5>@lang('home.brand') :
        </h5>
            <a href="{{route('user.brand',['name'=>str_replace([' ','/'], '-',$product->brand->translate('en')->name),'id'=>$product->brand->id])}}">
                <img class="brand-img-card lazyload" width="100" data-src="{{ asset('storage/'.$product->brand->image) }}" alt="{{$product->brand?$product->brand->alt:'--'}}"/>
            </a>
          </div>
  @endif
    <!-- <div class="categories">
      <h5>Category : </h5>
      <p>terminal blocks</p>
    </div> -->
<div class="product-action-btn mt-1">
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
