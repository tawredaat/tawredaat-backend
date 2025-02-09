@extends('User.partials.index')
@section('page-title', trans('home.orders') .' | #'.$order->id )
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
@push('style')
<style>
.order-details .list-group-item span{
font-weight:bold;
@if(App::isLocale('en'))
margin-right:10px;
@else
margin-left:10px;
@endif
}
</style>
@endpush
<!-- start page content -->
<main class="blog-holder">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb px-0">
        <li class="breadcrumb-item">
          <a href="{{ route('user.home') }}">@lang('home.home')</a>
        </li>
        <li class="breadcrumb-item">
          <a href="{{ route('user.view.myOrders') }}"> @lang('home.orders')</a>
       </li>
        <li class="breadcrumb-item active" aria-current="page">
         #{{$order->id}}
       </li>
      </ol>
    </nav>
    <div class="blogs-wrapper">
        <section class="content">
            <ul class="list-group order-details">
            <li class="list-group-item"><span ># : </span> {{$order->id}}</li>
            @if(!$order->isCancelled)
            <li  class="list-group-item"><span >@lang('home.status') : </span> <span style="color:{{$order->statusColor}}">{{$order->status}}</span></li>
            @else
            <li class="list-group-item"><span >@lang('home.status') :  </span><span style="color:red">@lang('home.cancelled')</span></li>
            @endif
            <li class="list-group-item"><span >@lang('home.subtotal') : </span>  {{$order->subtotal}}</li>
            <li class="list-group-item"><span >@lang('home.total') : </span>  {{$order->total}}</li>
            <li class="list-group-item"><span >@lang('home.date') : </span>  {{$order->date}}</li>
            <li class="list-group-item"><span >@lang('home.time') : </span>  {{$order->time}}</li>
            @if($order->comment)
            <li class="list-group-item"><span >@lang('home.comment') : </span> {{$order->comment}}</li>
            @endif
            <li class="list-group-item"><span >@lang('home.orderAddress') : </span> {{$order->address}}</li>
            </ul>
        </section>
        <hr>
        @if(count($order->items))
            <div class="table-responsive">
                <table class="table" style="background:#fff">
                    <thead style="background-color: #f4c536;" class="thead-dark table-dashed">
                        <tr style="color: #52504c;">
                            <th scope="col">@lang('home.product')</th>
                            <th scope="col">@lang('home.image')</th>
                            <th scope="col">@lang('home.quantity')</th>
                            <th scope="col">@lang('home.price')</th>
                            <th scope="col">@lang('home.amount')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                                <tr>
                                    <th scope="row">{{$item->productName}}</th>
                                    <th scope="row"><img src="{{$item->productImage}}" width="100" alt="{{$item->productName}}" /></th>
                                    <th scope="row">{{$item->quantity}}</th>
                                    <th scope="row">{{$item->price}} @lang('home.currency')</th>
                                    <th scope="row">{{$item->amount}} @lang('home.currency')</th>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
                <h3 style="text-align: center;margin: 10px;font-weight: bold;">@lang('home.YouHaveNoOrdersYet')</h3>
        @endif
    </div>
  </div>
</main>
@endsection
@push('script')
<script>
    $(function() {
        $(document).on('click', '.shop-category--list .shop-categoryies-l1', function(e) {

        });
    });
</script>
@endpush
