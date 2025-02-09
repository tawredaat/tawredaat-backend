@extends('User.partials.index')
@section('page-title', __('home.contactUs'))
@section('page-description', $setting->Meta_Description)
@section('page-image', asset('storage/'.$setting->site_logo))
@section('canonical-link', url()->current())

@if(App::isLocale('en'))
    @section('alternate-en-link', url()->current())
@section('alternate-ar-link', url()->current().'/ar')
@else
    @section('alternate-ar-link', url()->current())
<?php
$en_link = str_replace("/ar", "",url()->current());
?>
@section('alternate-en-link',$en_link)
@endif

@push('style')
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
@endpush
@section('content')
    <!-- start page content -->
    <main class="contactus-holder">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @lang('home.contactUs')
                    </li>
                </ol>
            </nav>
        </div>
        <div class="banner-holder">
            <img src="{{ asset('frontend_plugins/web/images/Contact-Us.jpg') }}" class="img-fluid" alt="Contact us"/>
        </div>
        <div class="container">
            <div class="contactus-content">
                <section class="contactus-section">
                    <div class="contactus-details">
                        <h2>@lang('home.contactUs') :</h2>
                        <div class="info-row">
                            <i class="fas fa-map-marker-alt"></i>
                            <p>@lang('home.address')</p>
                        </div>
                        <div class="info-row">
                            <i class="fas fa-mobile-alt"></i>
                            <a href="tel:+20233020208">+(202) 330 20208</a>
                        </div>
                        <div class="info-row-group">
                            <div class="info-row">
                                <i class="fas fa-globe"></i>
                                <a href="{{ route('user.home') }}">www.souqkahraba.com</a>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:info@souqkahraba.com">info@souqkahraba.com</a>
                            </div>
                        </div>
                    </div>
                    <div class="contactus-details">
                        <h2>@lang('home.listCompany') :</h2>
                        <div class="info-row">
                            <i class="fas fa-mobile-alt"></i>
                            <a href="tel:+201066228484">+20 1066 22 84 84</a>
                        </div>
                        <div class="info-row">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:michael@souqkahraba.com">michael@souqkahraba.com</a>
                        </div>
                    </div>
                    <div class="contactus-details">
                        <h2>@lang('home.customerCare') :</h2>
                        <div class="info-row">
                            <i class="fas fa-mobile-alt"></i>
                            <a href="tel:+201029020807">+20 1029 02 08 07</a>
                        </div>
                        <div class="info-row">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:customercare@souqkahraba.com">customercare@souqkahraba.com</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection
@push('script')
    <script>
        $(function () {
        });
    </script>
@endpush
