{{-- if this product in user cart  --}}
    @if($product->inCart)
        <div class="quantity-holder">
            <div class="qty">
                <span class="minus update-cart-item" data-route="{{route('user.update.cart')}}" data-action="0"  data-cartitemid="{{$product->cart_item_id}}"  data-shopproductid="{{$product->id}}" >-</span>
                <input type="number" disabled value="{{$product->cart_item_qty}}" class="form-control count product-qty-{{$product->id}}"   min="1" max="{{$product->qty}}"/>
                <span class="plus update-cart-item" data-route="{{route('user.update.cart')}}" data-action="1" data-cartitemid="{{$product->cart_item_id}}"  data-shopproductid="{{$product->id}}" >+</span>
            </div>
        </div>
        <a style="font-weight: bold;" title="remove item" data-route="{{route('user.delete.cart')}}" data-cartitemid="{{$product->cart_item_id}}"  data-shopproductid="{{$product->id}}"   class="yellow-rounded yellow-fill m-2 delete-from-cart-btn">
                <img style="width:24px !important" class="mr-2 d-inline" src="{{ asset('frontend_plugins/web/images/remove.svg')}}" alt="">@lang('home.added')</a>
{{-- if this product not in user cart  --}}
    @else
        <div class="quantity-holder">
            <div class="qty">
                <span class="minus">-</span>
                <input type="number" class="form-control count product-qty-{{$product->id}}"  value="1" min="1" max="{{$product->qty}}"/>
                <span class="plus">+</span>
            </div>
        </div>
        @if(isLogged())
            <a style="font-weight: bold;" data-route="{{route('user.add.cart')}}" data-shopproductid="{{$product->id}}"   class="yellow-rounded yellow-fill m-2 add-to-cart-btn">
            <img width="44" class="mr-2 d-inline" src="{{ asset('frontend_plugins/web/images/shopping-cart.svg')}}" alt="">@lang('home.AddToCart')</a>
        @else
            <a style="font-weight: bold;" data-toggle="modal" data-target="#LoginModal"  class="yellow-rounded yellow-fill m-2">
            <img width="44" class="mr-2 d-inline" src="{{ asset('frontend_plugins/web/images/shopping-cart.svg')}}" alt="">@lang('home.AddToCart')</a>
        @endif
    @endif
