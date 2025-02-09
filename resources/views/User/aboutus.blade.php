@extends('User.partials.index')
@section('page-title', __('home.aboutUs'))
@section('page-description', $setting->Meta_Description)
@section('page-image', asset('storage/' . $setting->site_logo))
@section('canonical-link', url()->current())

@if (App::isLocale('en'))
    @section('alternate-en-link', url()->current())
    @section('alternate-ar-link', url()->current() . '/ar')
@else
    @section('alternate-ar-link', url()->current())
    <?php
    $en_link = str_replace('/ar', '', url()->current());
    ?>
    @section('alternate-en-link', $en_link)
@endif
@section('content')
    <!-- start page content -->
    <main class="about-holder">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @lang('home.aboutUs')
                    </li>
                </ol>
            </nav>
        </div>
        <div class="banner-holder">
            <img src="{{ asset('frontend_plugins/web/images/About-Us.jpg') }}" class="img-fluid" alt="About Tawredaat" />
        </div>
        <div class="container">
            <div class="about-content">
                <div class="about--article">
                    <h1>@lang('home.aboutUs') :</h1>
                    <p>
                        @lang('home.ourWebsite') <a href="{{ route('user.home') }}">"SouqKahraba.com"</a>
                        @lang('home.aboutParagraph')
                    </p>
                </div>
            </div>
        </div>
    </main>
@endsection
