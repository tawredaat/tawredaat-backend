  <div class="filter-wrapper">
    <h4>
      @lang('home.CompanyFilter')
    </h4>
    <form method="GET" action="{{route('user.filter-in-companies')}}" class="companies-filter-form">
    <input type="hidden" value="{{request()->input('s')?request()->input('s'):request()->input('search_key')}}" name="search_key_" id="search-key-holder">
      <input type="hidden" value="{{isset($category)?$category->id:''}}" name="in_category" id="in-category-holder">
      <input type="hidden" value="{{isset($keyword)?$keyword:''}}" name="in_keyword" id="in-keyword-holder">
      <div class="filter-group-wrapper">
        <div class="accordion" id="accordionExample">
        @if(!isset($category))
          <div class="card" >
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
                         id="brand-check{{$br->id}}"
                         @if(isset($filterd_brands) && in_array($br->id,$filterd_brands->pluck('id')->toArray())) checked @endif
                         />
                  <label
                         class="custom-control-label"
                         for="brand-check{{$br->id}}"
                         >{{$br->name}}
                  </label
                    >
                </div>
                @endforeach
              </div>
            </div>
          </div>
          <div  class="card">
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
                @foreach($categories as $ct)
                <div class="custom-control custom-checkbox">
                  <input
                         type="checkbox"
                         name="categories[]"
                         value="{{$ct->id}}"
                         class="custom-control-input categories-filter"
                         id="category-check{{$ct->id}}"
                         @if(isset($filterd_categories) && in_array($ct->id,$filterd_categories->pluck('id')->toArray())) checked @endif
                         />
                  <label class="custom-control-label" for="category-check{{$ct->id}}"
                         >{{$ct->name}}
                  </label
                    >
                </div>
                @endforeach
              </div>
            </div>
          </div>
          @endif
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
                @lang('home.area')
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
                @foreach($areas as $area)
                <div class="custom-control custom-checkbox">
                  <input
                         type="checkbox"
                         name="areas[]"
                         value="{{$area->id}}"
                         class="custom-control-input areas-filter"
                         id="area-check{{$area->id}}"
                         @if(isset($filterd_areas) && in_array($area->id,$filterd_areas->pluck('id')->toArray())) checked @endif
                         />
                  <label
                         class="custom-control-label"
                         for="area-check{{$area->id}}"
                         >{{$area->name}}
                  </label
                    >
                </div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="card">
            <header
                    id="headingFour"
                    class="collapsed"
                    data-toggle="collapse"
                    data-target="#collapseFour"
                    aria-expanded="false"
                    aria-controls="collapseFour"
                    >
              <button type="button">
                @lang('home.companyType')
              </button>
              <div class="plusMinus-icon">
              </div>
            </header>
            <div
                 id="collapseFour"
                 class="collapse"
                 aria-labelledby="headingFour"
                 >
              <div class="card-body">
                @foreach($types as $type)
                <div class="custom-control custom-checkbox">
                  <input
                         type="checkbox"
                         name="types[]"
                         value="{{$type->id}}"
                         class="custom-control-input types-filter"
                         id="type-check{{$type->id}}"
                         @if(isset($filterd_type) && in_array($type->id,$filterd_type->pluck('id')->toArray())) checked @endif
                         />
                  <label
                         class="custom-control-label"
                         for="type-check{{$type->id}}"
                         >{{$type->name}}
                  </label
                    >
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        <br>
      </div>
    </form>
  </div>

