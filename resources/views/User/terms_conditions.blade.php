@extends('User.partials.index')
@section('page-title', trans('home.termsConditions') )
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
    <!-- start page content -->
    <main class="blog-holder terms-holder">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('home.termsConditions')</li>
                </ol>
            </nav>
            <div class="blogs-wrapper">
                    <p>{!! $terms?$terms->content:'' !!}</p>
            </div>
        </div>
    </main>
@endsection
