<div class="filter-wrapper">
  <h4>@lang('home.productFilter')</h4>
  <form action="{{route('user.filter-in-shop.products')}}" class="products-filter-form" method="GET">
    <input type="hidden" value="{{request()->input('s')?request()->input('s'):request()->input('search_key')}}" name="search_key_" id="search-key-holder">
    <input type="hidden" value="{{isset($brand)?$brand->id:request()->input('in_brand')}}" name="in_brand" id="in-brand-holder">
    <input type="hidden" value="{{isset($category_selected)?$category_selected->id:request()->input('in_category')}}" name="in_category" id="in-category-holder">
    <input type="hidden" value="{{isset($category_selected)?$category_selected->level:request()->input('category_level')}}" name="in_category_level" id="in-category-level-holder">
    <div class="filter-group-wrapper">
      <div class="accordion" id="accordionExample">
        @if(!isset($brand))
        <div class="card">
          <header
                  id="headingOne"
                  data-toggle="collapse"
                  class="collapsed"
                  data-target="#collapseOne"
                  aria-expanded="false"
                  aria-controls="collapseOne"
                  >
            <button type="button">
              @lang('home.brand')
            </button>
            <div class="plusMinus-icon">
            </div>
          </header>
          <div
               id="collapseOne"
               class="collapse"
               aria-labelledby="headingOne"
               >
            <div class="card-body">
              @foreach($brands as $br)
              <div class="custom-control custom-checkbox">
                <input
                       type="checkbox"
                       name="brands[]"
                       value="{{$br->id}}"
                       class="custom-control-input brands-filter"
                       id="brands-check{{$br->id}}"
                       data-n ="{{$br->name}}"
                       @if(isset($filtered_brands) && in_array($br->id,$filtered_brands->pluck('id')->toArray())) checked @endif
                />
                <label
                       class="custom-control-label"
                       for="brands-check{{$br->id}}"
                       >{{$br->name}}
                </label
                  >
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @endif
        @foreach($specifications as $specification)
            @if(count($specification->shop_product_values))
                <div class="card">
                    <header
                            id="headingThreeinside2"
                            class="collapsed"
                            data-toggle="collapse"
                            data-target="#collapseThreeinside{{$specification->id}}"
                            aria-expanded="false"
                            aria-controls="collapseThreeinside{{$specification->id}}"
                            >
                    <button type="button">
                        {{$specification->specification}}
                    </button>
                    <div class="plusMinus-icon">
                    </div>
                    </header>
                    <div
                        id="collapseThreeinside{{$specification->id}}"
                        class="collapse"
                        aria-labelledby="headingThreeinside{{$specification->id}}"
                        >
                    <div class="card-body">
                        @foreach($specification->shop_product_values as $value)
                        <div class="custom-control custom-checkbox">
                        <input
                                type="checkbox"
                                name="specifications[]"
                                value="{{$value->id}}"
                                class="specifications-filter custom-control-input"
                                id="specification-check{{$value->id}}"
                                @if($value->selected) checked @endif
                        />
                        <label class="custom-control-label" for="specification-check{{$value->id}}">
                            <span style="font-weight: bold"></span> {{$value->value}}
                        </label>
                        </div>
                        @endforeach
                    </div>
                    </div>
                </div>
            @endif
        @endforeach
      </div>
      <div class="price-range-wrapper">
        <div class="range-inputs-holder mb-20">
          <div class="num-input-holder">
            <label for="">@lang('home.fromPrice')
            </label>
            <input type="number" name="from" placeholder="@lang('home.currency')" value="{{request()->input('from')}}" id="priceFrom">
          </div>
          <div class="num-input-holder">
            <label for="">@lang('home.toPrice')
            </label>
            <input type="number" name="to" id="priceTo" value="{{request()->input('to')}}" placeholder="@lang('home.currency')">
          </div>
          <button style="margin: 15px 0;font-size: 13px;width: 56px;top: 15px;position: relative;"  class="applay-price-range primary-dark-fill btn-sm" type="button">@lang('home.apply')</button>
        </div>
      </div>
    </div>
  </form>
</div>
