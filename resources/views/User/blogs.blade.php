@extends('User.partials.index')
@section('page-title', trans('home.blogs'))
@section('page-image', asset('storage/'.$setting->site_logo))
@if(Str::contains(url()->current(), 'page'))
    @section('canonical-link', urldecode(urldecode(url()->current().'?page='.$blogs->currentPage())))

@else
@section('canonical-link', urldecode(urldecode(url()->current())))
@endif
@section('pagination-links')
    @if($blogs->previousPageUrl() != null)
        <link rel="prev"  href="{{urldecode($blogs->previousPageUrl())}}" />
    @endif
    @if($blogs->nextPageUrl() != null)
        <link rel="next"  href="{{urldecode($blogs->nextPageUrl())}}" />
    @endif
@endsection

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
    <main class="blog-holder">
         <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('home.blog')</li>
                </ol>
            </nav>
           <div class="blogs-wrapper">
               @foreach($blogs as $blog)
                <a href="{{ urldecode(route('user.single',['blogtitle'=>str_replace([' ','/','?'], '-',$blog->title),'id'=>$blog->id])) }}" class="blog-card-holder">
                       <div class="blog-card--img">
                              <img src="{{asset('storage/'.$blog->image)}}" alt="" />
                            </div>
                       <div class="blog-card--article">
                              <h4 class="blog-card--article__title">
                                    {{$blog->title}}
                                 </h4>
                             <time class="blog-card--article__time">
                                 {{$blog->created_at->format('l j F Y')}}</time
                                 >
                              <p class="blog-card--article__paragraph">
                                  {!! Strip_tags($blog->description) !!}
                              </p>
                            </div>
                      </a>
               @endforeach
              </div>

            {!! $blogs->links() !!}
             <br>
        </div>
   </main>
@endsection
