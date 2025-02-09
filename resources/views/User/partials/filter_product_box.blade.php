<div class="filter-wrapper">
   <h4>@lang('home.productFilter')</h4>
   <form action="{{route('user.filter-in-products')}}" class="products-filter-form" method="GET">
      <input type="hidden" value="{{request()->input('s')?request()->input('s'):request()->input('search_key')}}" name="search_key_" id="search-key-holder">
      <input type="hidden" value="{{isset($brand)?$brand->id:''}}" name="in_brand" id="in-brand-holder">
      <input type="hidden" value="{{isset($company)?$company->id:''}}" name="in_company" id="in-company-holder">
      <input type="hidden" value="{{isset($categoryID)?$categoryID:''}}" name="in_category" id="in-category-holder">
      <input type="hidden" value="{{isset($category_level)?$category_level:''}}" name="in_category_level" id="in-category-level-holder">
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
                           @if(isset($filterd_brands) && in_array($br->id,$filterd_brands->pluck('id')->toArray())) checked @endif
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
            @if(count($categories))
            <div class="card">
               <header
                  id="headingTwo"
                  class="collapsed"
                  data-toggle="collapse"
                  data-target="#collapseTwo"
                  aria-expanded="false"
                  aria-controls="collapseTwo"
                  >
                  <button type="button">
                  @lang('home.category')
                  </button>
                  <div class="plusMinus-icon">
                  </div>
               </header>
               <div
                  id="collapseTwo"
                  class="collapse"
                  aria-labelledby="headingTwo"
                  >
                  <div class="card-body">
                     @foreach($categories as $cty)
                     <div class="custom-control custom-checkbox">
                        <input
                           type="checkbox"
                           name="categories[]"
                           value="{{$cty->id}}"
                           class="categories-filter custom-control-input"
                           id="category-check{{$cty->id}}"
                           @if(isset($filterd_categories) && in_array($cty->id,$filterd_categories->pluck('id')->toArray())) checked @endif
                           />
                        <label class="custom-control-label" for="category-check{{$cty->id}}"
                           >{{$cty->name}}
                        </label
                           >
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
            @endif
            @if(!isset($brand))
            <div class="card">
               <header
                  id="headingThree"
                  class="collapsed"
                  data-toggle="collapse"
                  data-target="#collapseThree"
                  aria-expanded="false"
                  aria-controls="collapseThree"
                  >
                  <button type="button">
                  @lang('home.brandOrigin')
                  </button>
                  <div class="plusMinus-icon">
                  </div>
               </header>
               <div
                  id="collapseThree"
                  class="collapse"
                  aria-labelledby="headingThree"
                  >
                  <div class="card-body">
                     @foreach($countries as $country)
                     <div class="custom-control custom-checkbox">
                        <input
                           type="checkbox"
                           name="countries[]"
                           value="{{$country->id}}"
                           class="countries-filter custom-control-input"
                           id="country-check{{$country->id}}"
                           @if(isset($filterd_countries) && in_array($country->id,$filterd_countries->pluck('id')->toArray())) checked @endif
                           />
                        <label
                           class="custom-control-label"
                           for="country-check{{$country->id}}"
                           >{{$country->name}}
                        </label
                           >
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
            @if(!isset($company))
            <div class="card">
               <header
                  id="headingThree"
                  class="collapsed"
                  data-toggle="collapse"
                  data-target="#collapseFour"
                  aria-expanded="false"
                  aria-controls="collapseFour"
                  >
                  <button type="button">
                  @lang('home.company')
                  </button>
                  <div class="plusMinus-icon">
                  </div>
               </header>
               <div
                  id="collapseFour"
                  class="collapse"
                  aria-labelledby="headingThree"
                  >
                  <div class="card-body">
                     @foreach($companies as $cm)
                     <div class="custom-control custom-checkbox">
                        <input
                           type="checkbox"
                           name="companies[]"
                           value="{{$cm->id}}"
                           class="companies-filter custom-control-input"
                           id="company-check{{$cm->id}}"
                           @if(isset($filterd_companies) && in_array($cm->id,$filterd_companies->pluck('id')->toArray())) checked @endif
                           />
                        <label
                           class="custom-control-label"
                           for="company-check{{$cm->id}}"
                           >{{$cm->name}}
                        </label
                           >
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
            @endif
            @endif
            @if(isset($specifications) && count($specifications))
            <div class="card">
               <header
                  id="headingSixSpecification"
                  class="collapsed"
                  data-toggle="collapse"
                  data-target="#collapseFiveSpecification"
                  aria-expanded="false"
                  aria-controls="collapseFive"
                  >
                  <button type="button">
                  @lang('home.specifications')
                  </button>
                  <div class="plusMinus-icon">
                  </div>
               </header>
               <div id="collapseFiveSpecification" class="collapse" aria-labelledby="headingSixSpecification" >
                    <div class="card-body" id="specificationsResult">
                        @foreach($specifications as $specification)
                            @if(count($specification->values))
                                <div class="card child-card">
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
                                            @foreach(collect($specification->values)->sortBy('value',SORT_NATURAL|SORT_NUMERIC)->all() as $value)
                                                <div class="custom-control custom-checkbox">
                                                    <input
                                                        type="checkbox"
                                                        name="specifications[]"
                                                        value="{{$value->id}}"
                                                        class="specifications-filter custom-control-input"
                                                        id="specification-check{{$value->id}}"
                                                        @if($value->selected) checked @endif
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="specification-check{{$value->id}}"
                                                    >
                                                            <span style="font-weight: bold">
                                                            </span> {{$value->value}}
                                                    </label
                                                    >
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
               </div>
            </div>
            @endif
         </div>
         {{-- <div class="price-range-wrapper">
            <div class="range-inputs-holder mb-20">
               <div class="num-input-holder">
                  <label for="">@lang('home.fromPrice')
                  </label>
                  <input type="number" name="from" placeholder="EGY" value="{{request()->input('from')}}" id="priceFrom">
               </div>
               <div class="num-input-holder">
                  <label for="">@lang('home.toPrice')
                  </label>
                  <input type="number" name="to" id="priceTo" value="{{request()->input('to')}}" placeholder="EGY">
               </div>
               <button style="margin: 15px 0;font-size: 13px;width: 56px;top: 15px;position: relative;"  class="applay-price-range primary-dark-fill btn-sm" type="button">Applay</button>
            </div>
         </div> --}}
      </div>
   </form>
</div>
