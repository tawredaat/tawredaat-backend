@extends('User.partials.index')
@section('page-title', __('home.requestSent') )
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
@section('content')
<div class="complate-page-wrapper">
<main class="complate-wrapper">
    <div class="complate-content-holder">
    <img src="{{asset('frontend_plugins/web/images/Greencheck.png')}}" alt="checked">
    <h2>@lang('home.thankYou')</h2>
    <h6>@lang('home.yourRequestSent')</h6>
    @if(session()->has('companyRequestSent')>0)
        <h6>@lang('home.ourSales') <strong>@lang('home.contactYou')</strong></h6>
    @endif
    </div>
</main>
</div>
@endsection


