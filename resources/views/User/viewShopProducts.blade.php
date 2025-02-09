<div class="product-card card">
    <a href="{{urldecode(route('user.shop.product',['name'=>urlencode(str_replace([' ','/'], '-',$product->name)),'brand'=>urldecode(str_replace([' ','/'], '-',$product->brand?$product->brand->name:'brand')),'id'=>$product->id]))}}" class="product-card card">
        <div class="card-img" style="height: 180px;background-image:url('{{$product->image}}');background-size: cover;    background-position-x: center; "></div>
        <h5 title="{{$product->name}}">{{$product->name}}</h5>
        @if($product->new_price>0 && $product->old_price>$product->new_price)
            <span style="text-decoration: line-through;text-align: center;color: #bac4d9;font-size: 18px;">{{$product->old_price}} @lang('home.currency')</span>
        @endif
        <div class="price" style="display:block !important">
            {{$product->new_price}}@lang('home.currency')/{{$product->quantity_type}}
        </div>
        <div class="vat-including">
            <span>@lang('home.includingVat')</span>
        </div>
    </a>

    @if($product->brand)
    <div class="brand">
        <h5>@lang('home.brand') : </h5>
            <img class="brand-img-card lazyload" width="100" data-src="{{ asset('storage/'.$product->brand->image) }}" alt="{{$product->brand?$product->brand->alt:'--'}}"/>
    </div>
    @endif
    <div class="product-action-btn mt-1 shop-product-content-{{$product->id}}">
        @if(auth('web')->check())
            @include('User.partials.cart_component')
        @else
            @include('User.partials.cart_component_for_guest')
        @endif
    </div>
</div>
