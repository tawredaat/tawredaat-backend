@extends('User.partials.index')
@section('page-title', $blog->page_title)
@section('page-description', $blog->description_meta)
@section('page-meta_title', $blog->tags_meta)
@section('page-tags', $blog->meta_title)
@section('page-image', asset('storage/'.$setting->site_logo))
@section('canonical-link', urldecode(url()->current()))

@if(App::isLocale('en'))
    @section('alternate-en-link', urldecode(url()->current()))
<?php
    $ar_title = $blog->translate('ar')->title;
    $ar_route =  urldecode(route('user.single',['blogtitle'=> 'ar/'.str_replace([' ','/'], '-',$blog->translate('ar')->title),'id'=>$blog->id]));
?>
@section('alternate-ar-link', $ar_route)
@else
    @section('alternate-ar-link', urldecode(url()->current()))
<?php
$en_route =  urldecode(route('user.single',['blogtitle'=>str_replace([' ','/'], '-',$blog->translate('en')->title),'id'=>$blog->id]));
$en_route = str_replace("/ar","",$en_route);
?>
@section('alternate-en-link',$en_route)
@endif
@section('content')
    <!-- start page content -->
    <main class="single-blog-holder">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.blogs') }}">@lang('home.blogs')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                       {{$blog->title}}
                    </li>
                </ol>
            </nav>
            <div class="single-blog-content-wrapper">
                <div class="single-blog--hero">
                    <img data-src="{{asset('storage/'.$blog->image)}}" class="lazyload" alt="{{$blog->alt}}" />
                </div>
                <h3 class="single-blog--title">{{$blog->title}}</h3>
                <time class="single-blog--time"> {{$blog->created_at->format('l j F Y')}}</time>
                <div class="single-blog--paragraph">
                    {!! $blog->description !!}
                </div>
            </div>
            <div class="related-section">
                <div class="slider-heading">
                    <h3>@lang('home.related_blog')</h3>

                </div>
                <div class="related-news-grid">
                    @foreach($blog->filtertags() as $obj)
                    <a href="{{ route('user.single',['blogtitle'=>str_replace([' ','/'], '-',$obj->title),'id'=>$obj->id]) }}" class="blog-card-holder">
                        <div class="blog-card--img">
                            <img data-src="{{asset('storage/'.$obj->image)}}" class="lazyload" alt="{{$obj->alt}}" />
                        </div>
                        <div class="blog-card--article">
                            <h4 class="blog-card--article__title">
                                {{$obj->title}}
                            </h4>
                            <time class="blog-card--article__time"> {{$obj->created_at->format('l j F Y')}}</time>
                            <p class="blog-card--article__paragraph">
                                {!! Strip_tags($obj->description) !!}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
