@extends('Admin.index')
@section('orders-active', 'm-menu__item--active m-menu__item--open')
@section('orders-cancelled-view-active', 'm-menu__item--active')
@section('page-title', $MainTitle.' '.$SubTitle)
@section('content')
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">{{$MainTitle}}</h3>
            </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <!--Begin::Section-->
            <div class="m-portlet m-portlet--full-height ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">{{$SubTitle}}</h3>
                    </div>
                    </div>
                    <div class="m-portlet__head-tools">
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin::Content-->
                    <section class="content">
                        <ul>
                            <li>
                                <span style="font-weight: bold;">Cancelled By : </span>{{$order->cancelled_by ? $order->canceledBy->name : '-'}}
                            </li>
                            <li>
                                <span style="font-weight: bold;">Cancelled at : </span>{{$order->cancelled_at}}
                            </li>
                            <li>
                                <span style="font-weight: bold;">User ID : </span>{{$order->user->id}}
                            </li>
                            <li>
                                <span style="font-weight: bold;">Name : </span>{{$order->user->name}}
                            </li>
                            <li>
                                <span style="font-weight: bold;">Email : </span>{{$order->user->email}}
                            </li>
                            <li>
                                <span style="font-weight: bold;">Phone : </span>{{$order->user->phone}}
                            </li>
                            <li>
                                <span style="font-weight: bold;">Address : </span>{{$order->address}}
                            </li>
                            {{-- <li>
                                <span style="font-weight: bold;">Promocode:</span>{{$order->promocode}}
                            </li> --}}
                        </ul>
                        <hr>
                        <div style="overflow-x:auto;">
                            <table class="table table-striped- table-bordered table-hover"
                                    id="items-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    @if($item->shopProduct)
                                    <img width="100"
                                            src="{{ asset('storage/'.$item->shopProduct->image) }}"
                                            alt="{{ $item->shopProduct->name }}"/>
                                    @else
                                        Product deleted !
                                    @endif
                                </td>
                                <td>
                                    {{$item->shopProduct?$item->shopProduct->name:'Product Deleted!'}}
                                </td>
                                <td>{{$item->quantity}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->amount}}</td>
                            </tr>
                            @endforeach
                            </table>
                        </div>
                    </section>
                    <!--end::Content-->
                </div>
            </div>
        </div>
    </div>
  <!--End::Section-->
</div>
@push('script')
<script type="text/javascript">
  $(document).ready(function () {
    //call datatabel
    $('#items-table').DataTable({
      "order": [[0, "DESC"]]
    });
  });
</script>
@endpush
@endsection
