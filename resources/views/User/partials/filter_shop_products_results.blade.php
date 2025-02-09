<div class="product-box-view">
  <h4>@lang('home.products')
    <span class="ml-10">({{$countProducts}})</span>
  </h4>
   <ul class="filter-group" style="margin: 0 0 10px;padding: 0;list-style: none;">
    @if(isset($filtered_brands))
        @foreach($filtered_brands as $br)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$br->name}}
                    <a  href="#" data-brand="{{$br->id}}" class="remove-filer-products" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
    @if(isset($filtered_categories))
        @foreach($filtered_categories as $cg)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$cg->name}}
                    <a  href="#" data-category="{{$cg->id}}" class="remove-filer-products" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
    @if(isset($filtered_countries))
        @foreach($filtered_countries as $cn)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$cn->name}}
                    <a  href="#" data-country="{{$cn->id}}" class="remove-filer-products" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
    @if(isset($filtered_specifications))
        @foreach($filtered_specifications as $sp)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                     {{($sp->specification?$sp->specification->name:' ').' : '.$sp->value}}
                    <a  href="#" data-specification="{{$sp->id}}" class="remove-filer-products" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
    @if(isset($toPrice) && $toPrice)
    <li>
        <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
            {{__('home.fromPrice').' ('.$fromPrice.') ' . __('home.fromPrice') .' ('. $toPrice.')'}}
            <a  href="#" data-price="1" class="remove-filer-products" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
        </span>
    </li>
    @endif
    </ul>
  @if(count($shop_products))
  <div class="grid-holder">
    @foreach($shop_products as $product)
      @include('User.viewShopProducts')
    @endforeach
  </div>
  <br>
        {!! $shop_products_links !!}
  @else
  <h3>@lang('home.noProductSearch')</h3>
  @endif
</div>
