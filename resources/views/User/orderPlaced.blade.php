@extends('User.partials.index')
@section('page-title', __('home.OrderPlaced'))
@section('page-image', '')

@section('content')
    <!-- start page content -->
    <main class="blog-holder">
        <div class="container">
            <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order Placed</li>
                </ol>
            </nav> -->
            <div class="order-place-wrapper">
                <div class="order-place-card">
                    <img src="{{ asset('frontend_plugins/web/images/checked.svg')}}" alt="">
                    <h4>@lang('home.OrderPlaced')</h4>
                    <p>@lang('home.oderSentMessage')</p>
                        <a href="{{ route('user.home') }}" class="primary-dark-fill">@lang('home.backToHome')</a>
                </div>
            </div>
        </div>
    </main>
@endsection
