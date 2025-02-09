<div class="filter-wrapper">
<h4>
    @lang('home.brandFilter')
</h4>
<form method="GET" action="{{route('user.filter-in-brands')}}" class="brands-filter-form">
<input type="hidden" value="{{request()->input('s')?request()->input('s'):request()->input('search_key')}}" name="search_key_" id="search-key-holder">
      <input type="hidden" value="{{isset($category)?$category->id:''}}" name="in_category" id="in-category-holder">
      <input type="hidden" value="{{isset($keyword)?$keyword:''}}" name="in_keyword" id="in-keyword-holder">
    <div class="filter-group-wrapper">
    <div class="accordion" id="accordionExample">
        @if(!isset($category))
        <div class="card">
        <header
                id="headingOne"
                data-toggle="collapse"
                class="collapsed"
                data-target="#collapseOne"
                aria-expanded="true"
                aria-controls="collapseOne"
                >
            <button type="button">
            @lang('home.category')
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
                <label
                        class="custom-control-label"
                        for="category-check{{$ct->id}}"
                        >{{$ct->name}}
                </label>
            </div>
            @endforeach
            </div>
        </div>
        </div>
        @endif
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
            @lang('home.brandOrigin')
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
            @foreach($countries as $country)
            <div class="custom-control custom-checkbox">
                <input
                        type="checkbox"
                        name="countries[]"
                        value="{{$country->id}}"
                        class="custom-control-input countries-filter"
                        id="country-check{{$country->id}}"
                        @if(isset($filterd_countries) && in_array($country->id,$filterd_countries->pluck('id')->toArray())) checked @endif
                        />
                <label class="custom-control-label" for="country-check{{$country->id}}"
                        >{{$country->name}}
                </label>
            </div>
            @endforeach
            </div>
        </div>
        </div>
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
            @lang('home.company')
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
            @foreach($companies as $company)
            <div class="custom-control custom-checkbox">
                <input
                        type="checkbox"
                        name="companies[]"
                        value="{{$company->id}}"
                        class="custom-control-input companies-filter"
                        id="company-check{{$company->id}}"
                        @if(isset($filterd_companies) && in_array($company->id,$filterd_companies->pluck('id')->toArray())) checked @endif
                        />
                <label
                        class="custom-control-label"
                        for="company-check{{$company->id}}"
                        >{{$company->name}}
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
