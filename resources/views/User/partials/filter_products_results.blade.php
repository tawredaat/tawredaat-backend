<div class="product-box-view">
  <h4>@lang('home.products')
    <span class="ml-10">({{$countProducts}})</span>
  </h4>
   <ul class="filter-group" style="margin: 0 0 10px;padding: 0;list-style: none;">
    @if($brands)
        @foreach($brands as $br)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$br->name}}
                    <a  href="#" data-brand="{{$br->id}}" class="remove-filer-products" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
    @if($categories)
        @foreach($categories as $cg)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$cg->name}}
                    <a  href="#" data-category="{{$cg->id}}" class="remove-filer-products" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
    @if($countries)
        @foreach($countries as $cn)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$cn->name}}
                    <a  href="#" data-country="{{$cn->id}}" class="remove-filer-products" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
    @if($companies)
        @foreach($companies as $cm)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$cm->name}}
                    <a  href="#" data-company="{{$cm->id}}" class="remove-filer-products" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
    @if($specifications)
        @foreach($specifications as $sp)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                     {{($sp->specification?$sp->specification->name:' ').' : '.$sp->value}}
                    <a  href="#" data-specification="{{$sp->id}}" class="remove-filer-products" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
    @if($toPrice)
    <li>
        <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
            {{__('home.fromPrice').' ('.$fromPrice.') ' . __('home.fromPrice') .' ('. $toPrice.')'}}
            <a  href="#" data-price="1" class="remove-filer-products" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
        </span>
    </li>
    @endif
    @if($toPrice or $specifications or $categories or $companies or $categories or $brands)
        <!-- <li>
            <span style="background:#23408D !important;color: #fff;font-weight: bold;border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
            Clear All
                <a  href="#" data-clear="1" class="remove-filer-products" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;color:#fff">×</a>
            </span>
        <li> -->
    @endif
    </ul>
  @if(count($products))
  <div class="grid-holder">
    @foreach($products as $product)
      @include('User.viewProducts')
    @endforeach
  </div>
  <br>
  {{$products->links()}}
  @else
  <h3>@lang('home.noProductSearch')</h3>
  @endif
</div>
