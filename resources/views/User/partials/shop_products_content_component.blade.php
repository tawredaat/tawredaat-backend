<div class="col-md-4 col-lg-3">
    <div class="res-filter-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path d="M1 0h22l-9 15.094v8.906l-4-3v-5.906z" />
        </svg>
    </div>
    {{-- Box that used in filter(categories, brands, from&price ) --}}
    @include('User.partials.filter_shop_product_box')
    <div class="overlay"><button>x</button></div>
</div>
<div class="col-md-6 col-lg-7">
    <div class="search-grid-wrapper" id="search-grid-content">
        @include('User.partials.filter_shop_products_results')
    </div>
</div>
@if(ProductVerticalAd())
    <div class="col-md-2 col-lg-2 poster-y-wrapper" style="margin-top: 150px;background: none;align-items: flex-start;">
        <a href="{{ProductVerticalAd()->url}}" target="_blank" >
            <img data-src="{{ asset('storage/'.ProductVerticalAd()->image) }}" class="lazyload" width="100" height="100" style="width: 100%;height: auto;">
        </a>
    </div>
@endif
