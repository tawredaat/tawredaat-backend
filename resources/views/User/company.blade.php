@extends('User.partials.index')
@section('page-title', $company->title)
@section('page-description', $company->description_meta)
@section('page-keywords', $company->keywords_meta)
@section('page-image', asset('storage/'.$company->logo))
@section('canonical-link',urldecode(url()->current()) )
@if(App::isLocale('en'))
    @section('alternate-en-link', urldecode(url()->current()))
<?php
$seg = request()->segment(1);
$ar_route = urldecode(route('user.company',['name'=>str_replace([' '], '-','ar/'.$company->translate('ar')->name),'id'=>$company->id]));
?>
@section('alternate-ar-link',$ar_route)
@else
    @section('alternate-ar-link', urldecode(url()->current()))
<?php
$en_route = urldecode(route('user.company',['name'=>str_replace([' ','/'], '-',$company->translate('en')->name),'id'=>$company->id]));
$en_link = str_replace("/ar", "",$en_route);
?>
@section('alternate-en-link',$en_link)
@endif
@section('content')
    @if(isLogged())
        @include('User.Modals.request_quotaion')
    @endif
    @include('User.Modals.more_info')
    <main class="company-holder">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('user.home')}}">@lang('home.home')
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('user.companies')}}">@lang('home.companies')
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{$company->name}}
                    </li>
                </ol>
            </nav>
            <div class="company-content">
                <div class="banner-holder">
                    @if(!is_null($company->mobileCover))
                        <img src="{{ asset('storage/'.$company->mobileCover) }}" class="img-fluid img-mob" alt="{{$company->alt}}">
                    @endif
                    <img src="{{ asset('storage/'.$company->cover) }}" class="img-fluid" alt="{{$company->alt}}">
                </div>
                <div class="row">
                    <div class="col-md-9 col-lg-8 company-info-wrapper">
                        <div class="details-holder">
                            <div>
                                <div class="logo">
                                    <img src="{{ asset('storage/'.$company->logo) }}" class="img-fluid"
                                         alt="{{$company->alt}}">
                                </div>
                                <div class="company-name">
                                    <h1>{{$company->name}}
                                    </h1>
                                <div class="company-details--contact">
                                    {{-- @if(isLogged()) --}}

                                        <a
                                           style="color:white"
                                           data-telephone="tel:{{$company->pri_contact_phone}}"
                                           class="primary-dark-fill w-100 sm-btn text-nowrap call-company call-tel-style"
                                           data-route="{{route('user.company-call')}}" data-company="{{$company->id}}">
                                            <!-- call-tel-style -->
                                            <span class="text"><img src="{{ asset('frontend_plugins/web/images/phone-call.svg')}}" width="17" class="mr-2 d-inline" alt="phone">@lang('home.callCompanyNow')</span>
                                            <span class="tel">{{$company->pri_contact_phone}}</span>
                                        </a>
                                    {{-- @else
                                        <a id="com-data" style="color:white" data-toggle="modal" data-target="#LoginModal"
                                           class="primary-dark-fill w-100 sm-btn text-nowrap call-company-login call-tel-style" data-company="{{$company->id}}" data-company-name="{{$company->name}}">
                                                              <span class="text"><img src="{{ asset('frontend_plugins/web/images/phone-call.svg')}}" width="17" class="mr-2 d-inline" alt="phone">@lang('home.callCompanyNow')</span>
                                                              <span class="tel">{{$company->pri_contact_phone}} 0100000000000</span>
                                        </a>
                                    @endif --}}
                                    @if( ! $company->whatsup_number == null)
                                    <a href="https://api.whatsapp.com/send?phone={{$company->pri_contact_phone}}" target="_blank" class="whatsapp-fill w-100 sm-btn ml-3">
                                        <img src="{{ asset('frontend_plugins/web/images/whatsapp.svg')}}" class="mr-2" width="27" alt="">
                                        @lang('home.sendWhatsapp')
                                    </a>
@endif
                                </div>
                                </div>
                            </div>
                            <div>
                                @if(count($company->areas))
                                    <address>
                                        <img data-src="{{ asset('frontend_plugins/web/images/location.png')}}"
                                        class="lazyload"
                                        alt="location"/>
                                        <span style="font-weight: bold;">
                  @lang('home.area') :
                </span> @foreach($company->areas as $area) {{$area->name}} @endforeach
                                    </address>
                                @endif
                                @if(count($company->company_types))
                                    <div class="location">
                                        <img data-src="{{ asset('frontend_plugins/web/images/agent.png')}}" class="lazyload" alt="agent"/>
                                        <span style="font-weight: bold;">@lang('home.businessType'):
                </span> @foreach($company->company_types as $type) {{$type->name}} @endforeach
                                    </div>
                                @endif
                                <time>
                                    <img data-src="{{ asset('frontend_plugins/web/images/date.png')}}" class="lazyload" alt="date"/>
                                    <span style="font-weight: bold;">@lang('home.yearEstablished') :
                </span> {{date('Y', strtotime($company->date) )}}
                                </time>
                            </div>
                            <!-- //end info box -->
                        </div>
                        <div
                            id="accordion"
                            class="accordion-wrapper"
                            role="tablist"
                            aria-multiselectable="true"
                        >
                            <!-- Accordion Item 1 -->
                            <div class="overview-holder">
                                <div class="card-header" role="tab" id="accordionHeadingOne">
                                    <div class="mb-0 row">
                                        <div class="col-12 no-padding accordion-head">
                                            <a
                                                data-toggle="collapse"
                                                data-parent="#accordion"
                                                href="#accordionBodyOne"
                                                aria-expanded="false"
                                                aria-controls="accordionBodyOne"
                                                class="collapsed"
                                            >
                                                <h3>@lang('home.overview')
                                                </h3>
                                                <div class="plusMinus-icon">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    id="accordionBodyOne"
                                    class="collapse"
                                    role="tabpanel"
                                    aria-labelledby="accordionHeadingOne"
                                    aria-expanded="false"
                                    data-parent="accordion"
                                >
                                    <div class="card-block col-12 pb-3">
                                        <p>
                                            @if(isset($company->description)){!! $company->description !!}@endif
                                            @if(isset($brand->description)){!! $brand->description !!}@endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @if(count($categories))
                            <!-- Accordion Item 2 -->
                            <div class="categories-holder">
                                <div class="card-header" role="tab" id="accordionHeadingTwo">
                                    <div class="mb-0 row">
                                        <div class="col-12 no-padding accordion-head">
                                            <a
                                                data-toggle="collapse"
                                                data-parent="#accordion"
                                                href="#accordionBodyTwo"
                                                aria-expanded="true"
                                                aria-controls="accordionBodyTwo"
                                                class="collapsed "
                                            >
                                                <h3>@lang('home.categories')
                                                </h3>
                                                <div class="plusMinus-icon">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    id="accordionBodyTwo"
                                    class="collapse"
                                    role="tabpanel"
                                    aria-labelledby="accordionHeadingTwo"
                                    aria-expanded="false"
                                    data-parent="accordion"
                                >
                                    <div class="card-block col-12">
                                        <div class="row categories-link mt-3">
                                            @foreach($categories as $category)
                                                <div class="col-md-6 col-lg-4">
                                                    <a href="{{route('user.CompanyCategory',['name'=>str_replace([' ','/'], '-',$category->name),'id'=>$category->id])}}"
                                                       class="primary-fill">{{$category->name}}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(count($keywords))
                            <!-- Accordion Item 3 -->
                                <div class="tags-holder">
                                    <div class="card-header" role="tab" id="accordionHeadingThree">
                                        <div class="mb-0 row">
                                            <div class="col-12 no-padding accordion-head">
                                                <a
                                                    data-toggle="collapse"
                                                    data-parent="#accordion"
                                                    href="#accordionBodyThree"
                                                    aria-expanded="true"
                                                    aria-controls="accordionBodyThree"
                                                    class="collapsed"
                                                >
                                                    <h3>@lang('home.tages')
                                                    </h3>
                                                    <div class="plusMinus-icon">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        id="accordionBodyThree"
                                        class="collapse"
                                        role="tabpanel"
                                        aria-labelledby="accordionHeadingThree"
                                        aria-expanded="false"
                                        data-parent="accordion"
                                    >
                                        <div class="card-block col-12">
                                            <div class="tags-content">
                                                @foreach($keywords as $key)
                                                    <div>
                                                        <a href="{{route('user.CompanyKeywords',$company->id).'?tag='.$key}}"
                                                           class="primary-fill">{{$key}}
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endif
                        @if(count($products))
                            <!-- Accordion Item 4 -->
                                <div class="tags-holder">
                                    <div class="card-header" role="tab" id="accordionHeadingFour">
                                        <div class="mb-0 row">
                                            <div class="col-12 no-padding accordion-head">
                                                <a
                                                    data-toggle="collapse"
                                                    data-parent="#accordion"
                                                    href="#accordionBodyFour"
                                                    aria-expanded="true"
                                                    aria-controls="accordionBodyFour"
                                                    class="collapsed"
                                                >
                                                    <h3>@lang('home.products')
                                                    </h3>
                                                    <div class="plusMinus-icon">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        id="accordionBodyFour"
                                        class="collapse"
                                        role="tabpanel"
                                        aria-labelledby="accordionHeadingFour"
                                        aria-expanded="false"
                                        data-parent="accordion"
                                    >
                                        <div class="card-block col-12">
                                            <div class="tags-content">
                                                @foreach($products as $product)
                                                    @include('User.viewCompanyProducts')
                                                @endforeach
                                            </div>
                                            @if(count($company->products) > 9)
                                                <div class="row" style="margin: 20px">
                                                    <a href="{{route('user.company-products',['name'=>str_replace([' ','/'], '-',$company->name),'id'=>$company->id])}}"
                                                       class="primary-dark-fill">@lang('home.browseAll')
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        @endif
                        @if(count($brands))
                            <!-- Accordion Item 7 -->
                                <div class="tags-holder">
                                    <div class="card-header" role="tab" id="accordionHeadingSeven">
                                        <div class="mb-0 row">
                                            <div class="col-12 no-padding accordion-head">
                                                <a
                                                    data-toggle="collapse"
                                                    data-parent="#accordion"
                                                    href="#accordionBodySeven"
                                                    aria-expanded="true"
                                                    aria-controls="accordionBodySeven"
                                                    class="collapsed"
                                                >
                                                    <h3>@lang('home.brands')
                                                    </h3>
                                                    <div class="plusMinus-icon">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        id="accordionBodySeven"
                                        class="collapse"
                                        role="tabpanel"
                                        aria-labelledby="accordionHeadingSeven"
                                        aria-expanded="false"
                                        data-parent="accordion"
                                    >
                                        <div class="card-block col-12">
                                            <div class="tags-content">
                                                @foreach($brands as $brand)
                                                    @include('User.viewCompanyBrands')
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endif
                        @if(count($company->members))
                            <!-- Accordion Item 5 -->
                                <div class="tags-holder">
                                    <div class="card-header" role="tab" id="accordionHeadingFive">
                                        <div class="mb-0 row">
                                            <div class="col-12 no-padding accordion-head">
                                                <a
                                                    data-toggle="collapse"
                                                    data-parent="#accordion"
                                                    href="#accordionBodyFive"
                                                    aria-expanded="true"
                                                    aria-controls="accordionBodyFive"
                                                    class="collapsed"
                                                >
                                                    <h3>@lang('home.members')
                                                    </h3>
                                                    <div class="plusMinus-icon">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        id="accordionBodyFive"
                                        class="collapse"
                                        role="tabpanel"
                                        aria-labelledby="accordionHeadingFive"
                                        aria-expanded="false"
                                        data-parent="accordion"
                                    >
                                        <div class="card-block col-12">
                                            <div class="tags-content">
                                                @foreach($company->members as $member)
                                                    <a class="product-card card">
                                                        <img class="img-fluid lazyload"
                                                             data-src="{{ asset('storage/'.$member->image) }}"
                                                             alt="{{$member->alt}}" height="300"/>
                                                        <h5>{{$member->name}}
                                                        </h5>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endif
                        @if(count($company->certificates))
                            <!-- Accordion Item 6 -->
                                <div class="tags-holder">
                                    <div class="card-header" role="tab" id="accordionHeadingSix">
                                        <div class="mb-0 row">
                                            <div class="col-12 no-padding accordion-head">
                                                <a
                                                    data-toggle="collapse"
                                                    data-parent="#accordion"
                                                    href="#accordionBodySix"
                                                    aria-expanded="true"
                                                    aria-controls="accordionBodySix"
                                                    class="collapsed"
                                                >
                                                    <h3>@lang('home.certificates')
                                                    </h3>
                                                    <div class="plusMinus-icon">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        id="accordionBodySix"
                                        class="collapse"
                                        role="tabpanel"
                                        aria-labelledby="accordionHeadingSix"
                                        aria-expanded="false"
                                        data-parent="accordion"
                                    >
                                        <div class="card-block col-12">
                                            <div class="tags-content">
                                                @foreach($company->certificates as $certificate)
                                                    <a href="{{ asset('storage/'.$certificate->name) }}" target="_blank"
                                                       download="{{$certificate->name}}"
                                                       class="secondary-fill download-doc md-btn">
                                                        <h5>{{$certificate->CertiName}}
                                                        </h5>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endif
                        @if(count($company->branches))
                            <!-- Accordion Item 8 -->
                                <div class="tags-holder">
                                    <div class="card-header" role="tab" id="accordionHeadingEight">
                                        <div class="mb-0 row">
                                            <div class="col-12 no-padding accordion-head">
                                                <a
                                                    data-toggle="collapse"
                                                    data-parent="#accordion"
                                                    href="#accordionBodyEight"
                                                    aria-expanded="true"
                                                    aria-controls="accordionBodyEight"
                                                    class="collapsed"
                                                >
                                                    <h3>@lang('home.branches')
                                                    </h3>
                                                    <div class="plusMinus-icon">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        id="accordionBodyEight"
                                        class="collapse"
                                        role="tabpanel"
                                        aria-labelledby="accordionHeadingEight"
                                        aria-expanded="false"
                                        data-parent="accordion"
                                    >
                                        <div class="card-block col-12">
                                            <div class="tags-content">
                                                @foreach($company->branches as $branch)
                                                    <div class="product-card card">
                                                        <img class="img-fluid lazyload"
                                                             data-src="{{ asset('storage/'.$branch->image) }}"
                                                             alt="{{$branch->alt}}" height="300"/>
                                                        <h5>{{$branch->name}}
                                                        </h5>
                                                        <article>{{$branch->address}}
                                                        </article>
                                                        <article>
                                                            <a href="{{$branch->location}}"
                                                               target="_blank">@lang('home.map')
                                                            </a>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 offset-lg-1 side-content-wrapper">
                        <div class="box">
                            <h3>@lang('home.companyInformation')
                            </h3>
                            {{-- @if(isLogged()) --}}
                                <a style="color: #fff" data-toggle="modal" data-target="#InfoModalCenter"
                                   class="primary-dark-fill btn_click" data-route="{{route('user.btns-click')}}"
                                   data-company="{{$company->id}}" data-click="more_info">@lang('home.viewMoreInfo')
                                </a>
                            {{-- @else
                                <a style="color: #fff" data-toggle="modal" data-target="#LoginModal"
                                   class="primary-dark-fill btn_click call-company-login" data-company="{{$company->id}}" data-company-name="{{$company->name}}">@lang('home.viewMoreInfo')
                                </a>
                            @endif --}}
                        </div>
                        <!-- End info box -->
                        <div class="box">
                            <h3>@lang('home.requestGeneralQuotaion')
                            </h3>
                            @if(isLogged())
                                <a data-toggle="modal" data-target="#RequestQuotationModal" style="color: #fff"
                                   class="primary-dark-fill">@lang('home.requestQuotation')
                                </a>
                            @else
                                <a style="color: #fff" data-toggle="modal" data-target="#LoginModal"
                                   class="primary-dark-fill  call-company-login" data-company="{{$company->id}}" data-company-name="{{$company->name}}">@lang('home.requestQuotation')
                                </a>
                            @endif
                        </div>
                        {{-- @if(isLogged()) --}}
                            @if($company->brochure)
                                <a href="{{ asset('storage/'.$company->brochure) }}" target="_blank"
                                   download="{{$company->brochure}}"
                                   class="secondary-fill download-doc md-btn btn_click"
                                   data-route="{{route('user.btns-click')}}" data-company="{{$company->id}}"
                                   data-click="brochure">@lang('home.downloadBrochureDocument')
                                </a>
                            @endif
                            @if($company->price_lists)
                                <a href="{{ asset('storage/'.$company->price_lists) }}" target="_blank"
                                   download="{{$company->price_lists}}"
                                   class="secondary-fill download-doc md-btn btn_click"
                                   data-route="{{route('user.btns-click')}}" data-company="{{$company->id}}"
                                   data-click="price_list">@lang('home.priceLists')
                                </a>
                            @endif
                        {{-- @else
                            @if($company->brochure)
                                <a style="color:white" data-toggle="modal" data-target="#LoginModal"
                                   class="secondary-fill download-doc md-btn">
                                    @lang('home.downloadBrochureDocument')
                                </a>
                            @endif
                            @if($company->price_lists)
                                    <a style="color:white" data-toggle="modal" data-target="#LoginModal"
                                       class="secondary-fill download-doc md-btn">
                                        @lang('home.priceLists')
                                    </a>
                            @endif
                        @endif --}}
                        @if(!is_null($setting->company_image))
                            <div class="box google-box user-box-adv lazyload">
                               <img src="{{ asset('storage/'.$setting->company_image) }}">
                            </div>
                        @endif
                    </div>
                    @if(count($relatedCompanies))
                        <div class="col-12">
                            <div class="related-copmany">
                                <div class="slider-heading">
                                    <h3>@lang('home.relatedCompanies')
                                    </h3>
                                </div>
                                <div class="content">
                                    <div class="companies-slider">
                                        @foreach($relatedCompanies as $company)
                                            @if($company)
                                                @include('User.viewCompanies')
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
    @push('script')
        <script src="{{ asset('frontend_plugins/web/javascript/company.js') }}">
        </script>
        <script>
            $(".call-company-login").on('click',function (){
                var c_id = $(this).data('company');
                var c_n = $(this).data('company-name');

                $("#cid").val(c_id);
                $("#c_name").val(c_n);

            });
        </script>
    @endpush
@endsection
