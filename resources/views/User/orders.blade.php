@extends('User.partials.index')
@section('page-title', trans('home.orders') )
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
<main class="blog-holder">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb px-0">
        <li class="breadcrumb-item">
          <a href="{{ route('user.home') }}">@lang('home.home')
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">@lang('home.orders')
        </li>
      </ol>
    </nav>
    <div class="blogs-wrapper" style="text-align: center">
        @if(count($orders))
            <div class="table-responsive">
                <table class="table" style="background:#fff">
                    <thead style="background-color: #f4c536;" class="thead-dark table-dashed">
                        <tr style="color: #52504c;">
                            <th scope="col">#</th>
                            <th scope="col">@lang('home.status')</th>
                            <th scope="col">@lang('home.total')</th>
                            <th scope="col">@lang('home.date')</th>
                            <th scope="col">@lang('home.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            @if($order->isCancelled)
                                <tr style="background: #e5414161;opacity: 0.8;">
                                    <th scope="row">#{{$order->id}}</th>
                                    <td><span style="color:red;font-weight:bold;border-radius: 15px;;padding: 10px; top: 5px;position: relative;">@lang('home.cancelled')</span></td>
                                    <td>{{$order->total}} @lang('home.currency')</td>
                                    <td>{{$order->date .'|'. $order->time}} </td>
                                    <td>
                                        <a  href="{{route('user.order.details',$order->id)}}"  title="View order details" class="btn btn-primary" style="color:#fff;background:#23408d;border:1px solid #23408d;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <th scope="row">#{{$order->id}}</th>
                                    <td><span style="color:{{$order->statusColor}};font-weight:bold;border-radius: 15px;;padding: 10px; top: 5px;position: relative;">{{$order->status}}</span></td>
                                    <td>{{$order->total}} @lang('home.currency')</td>
                                    <td>{{$order->date .'|'. $order->time}} </td>
                                    <td>
                                        <a  href="{{route('user.order.details',$order->id)}}"  title="View order details" class="btn btn-primary" style="color:#fff;background:#23408d;border:1px solid #23408d;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
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
