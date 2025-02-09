@extends('Admin.index')
@section('orders-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', $MainTitle . ' ' . $SubTitle)
@section('content')
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            <!-- BEGIN: Subheader -->
            <div class="m-subheader ">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h3 class="m-subheader__title ">{{ $MainTitle }}</h3>
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
                                <h3 class="m-portlet__head-text">{{ $SubTitle }}</h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin::Content-->
                        <section class="content">
                            <form method="GET" action="{{ route('orders.details.export') }}" id="filterDataForm">
                                <div
                                        style="display: grid;justify-content: flex-end;align-items:flex-end;margin-bottom: 20px">
                                    <div class="input-group" style="width: 100%">
                                        <input type="hidden" name="resourceId" value="{{ $order->id }}">
                                        <div class="input-group-append">
                                            <button id="exportButton" class="btn btn-primary" type="submit"
                                                    style="margin:0 5px" title="export data">Export Data as Excel Sheet
                                                <i class="fa fa-file"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <ul>
                                <li>
                                    <span style="font-weight: bold; font-size:20px">User ID : </span><span style="font-size:20px">{{ $order->user->id }}</span>
                                </li>
                              	<li>
                                    <span style="font-weight: bold; font-size:20px">User Type : </span><span style="font-size:20px">{{ $order->user->user_type }}</span>
                                </li>
                                <li>
                                    <span style="font-weight: bold; font-size:20px">Name : </span><span style=" font-size:20px">{{ $order->user->full_name }}</span>
                                </li>
                                <li>
                                    <span style="font-weight: bold; font-size:20px">Email : </span><span style=" font-size:20px">{{ $order->user->email }}</span>
                                </li>
                                <li>
                                    <span style="font-weight: bold; font-size:20px">Phone : </span><span style="font-size:20px">{{ $order->user->phone }}</span>
                                </li>
                                <li>
                                    <span style="font-weight: bold; font-size:20px">Address : </span><span style=" font-size:20px">{{ $order->address }}</span>
                                </li>
                              	<li>
                                    <span style="font-weight: bold; font-size:20px">Address Type : </span><span style=" font-size:20px">{{ $order->userAddress->address_type }}</span>
                                </li>
                              	<li>
                                    <span style="font-weight: bold; font-size:20px">Reciever Name : </span><span style=" font-size:20px">{{ $order->userAddress->reciever_name }}</span>
                                </li>
                              	<li>
                                    <span style="font-weight: bold; font-size:20px">Reciever Phone : </span><span style=" font-size:20px">{{ $order->userAddress->reciever_phone }}</span>
                                </li>
                              	@if($order->userAddress && $order->userAddress->latitude !== null && $order->userAddress->longitude !== null)
                                    <li>
                                        <span style="font-weight: bold; font-size:20px">Address: </span>
                                        <span style="font-size:20px">
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $order->userAddress->latitude }},{{ $order->userAddress->longitude }}" target="_blank">
                                                Location on Map
                                            </a>
                                        </span>
                                    </li>
                                @endif
                    			<li>
                                    <span style="font-weight: bold; font-size:20px">payment Method : </span><span style=" font-size:20px">{{ $order->payment->name }}</span>
                                </li>
                                <li>
                                <span style="font-weight: bold; font-size:20px">Promocode:</span><span style=" font-size:20px">{{$order->promocode}}</span>
                            	</li>
                            </ul>
                            <hr>


                            <div style="overflow-x:auto;">
                                <table class="table table-striped- table-bordered table-hover" id="items-table">
                                    <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Product name arabic</th>
                                        <th>Sku Code</th>
                                        <th>Internal Code</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>
                                                @if ($item->shopProduct)
                                                    <img width="100"
                                                         src="{{ asset('storage/' . $item->shopProduct->image) }}"
                                                         alt="{{ $item->shopProduct->name }}" />
                                                @elseif($item->manual_product_name)
                                                    No image available
                                                @else
                                                    Product deleted !
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->shopProduct)
                                                    {{ $item->shopProduct->name }}
                                                @elseif($item->manual_product_name)
                                                    {{ $item->manual_product_name }}
                                                @else
                                                    Product deleted !
                                                @endif

                                            </td>
                                            @if(isset($item->shopProduct->translations[0]['name']))
                                                <td>{{ $item->shopProduct->translations[0]['name']}}</td>
                                            @endif
                                            <td>{{ $item->shopProduct->sku_code }}</td>
                                            <td>{{ $item->shopProduct->internal_code }}</td>

                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->amount }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </section>


                        {{-- update fields  --}}
                        <div class="m-portlet m-portlet--full-height " style="margin-top:5rem;">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            Order info
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <section class="content table-responsive">
                                    <form id="order-form" method="post" action="{{ route('orders.update', $order->id) }}">
                                        <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                                        @csrf
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Address</label>
                                                <select name="address_id" required=""
                                                        data-route="{{ route('users.address') }}"
                                                        class="form-control m-input m-input--square" id="addresses">
                                                    @foreach ($addresses as $address)
                                                            <?php
                                                            $address_country = $address->country ? $address->country->name : '';
                                                            $address_area = $address->area;
                                                            $address_street = $address->street;
                                                            $address_building = $address->building;
                                                            $address_landmark = $address->landmark;
                                                            ?>
                                                        <option value="{{ $address->id }}"
                                                                @if (old('address_id') == $address->id || $order->address_id == $address->id) selected @endif>
                                                            {{ $address_country . ', ' . $address_area . ', ' . $address_street . ', ' . $address_building . ', ' . $address_landmark }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('address_id')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6">
                                                <label>Delivery Charge</label>
                                                <input class="form-control m-input m-input--square"
                                                       value="{{ $order->delivery_charge }}" name="delivery_charge"
                                                       id="delivery-charge"
                                                       data-route="{{ route('cities.delivery-charge') }}" />
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">

                                            <div class="col-lg-6">
                                                <label> Promo code:</label>
                                                <select name="promo_code_id" id="promocodes"
                                                        class="form-control m-input m-input--square">
                                                    <option value="">
                                                        {{ $order->promocode }}
                                                    </option>
                                                    @foreach ($promo_codes as $promo_code)
                                                        <option value="{{ $promo_code->id }}"
                                                                @if (old('promo_code_id') == $promo_code->id) selected @endif>
                                                            {{ $promo_code->code }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <span id="promo_code_invalid_feedback" class="invalid-feedback"
                                                      role="alert">
                                                    {{-- <strong>{{ $message }}</strong> --}}
                                                </span>

                                                @error('promo_code_id')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Order from:</label>
                                                <select name="order_from" id="promocodes"
                                                        class="form-control m-input m-input--square">
                                                    <option @if (old('order_from') == 'Web' || $order->order_from == 'Web') selected @endif
                                                    value="Web">Web
                                                    </option>
                                                    <option @if (old('order_from') == 'Mobile' || $order->order_from == 'Mobile') selected @endif
                                                    value="Mobile">
                                                        Mobile
                                                    </option>

                                                </select>

                                                <span id="promo_code_invalid_feedback" class="invalid-feedback"
                                                      role="alert">
                                                    {{-- <strong>{{ $message }}</strong> --}}
                                                </span>

                                                @error('order_from')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label> Payment:</label>
                                                <select name="payment_id" required
                                                        class="form-control m-input m-input--square">
                                                    <option value="">
                                                        Payment
                                                    </option>
                                                    @foreach ($payments as $payment)
                                                        <option value="{{ $payment->id }}"
                                                                @if (old('payment_id') == $payment->id || $order->payment_id == $payment->id) selected @endif>
                                                            {{ $payment->name }}
                                                        </option>
                                                    @endforeach
                                                </select>


                                                @error('payment_id')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6">
                                                <label> Comment:</label>
                                                <textarea class="form-control" name="comment">{{ $order->comment }}</textarea>

                                            </div>
                                        </div>

                                        {{-- <div class="form-group m-form__group row"> --}}
                                        @include('Admin._orders._components.details.table_edit')
                                        {{-- @include('Admin._orders._components.add_products') --}}
                                        {{-- </div> --}}

                                        <div class="form-group">
                                            <button class="btn btn-primary" style="float:right;margin:0.5rem;"
                                                    type="submit">Save
                                                {{-- <i class="fa fa-plus"></i> --}}
                                            </button>
                                        </div>
                                    </form>
                                </section>
                            </div>
                        </div>
                        {{-- update fields --}}
                        <!--end::Content-->
                    </div>
                </div>
            </div>
        </div>
        <!--End::Section-->
    </div>
    @push('script')
        <script type="text/javascript">
            $(document).ready(function() {
                //call datatabel
                $('#items-table').DataTable({
                    "order": [
                        [0, "DESC"]
                    ]
                });
            });
        </script>
        <script src="{{ asset('javascript/order/add_product_row_edit.js') }}"></script>
        {{-- <script src="{{ asset('javascript/order/add_manual_products.js') }}"></script> --}}
        {{-- <script src="{{ asset('javascript/user/set_delivery_charge.js') }}"></script> --}}
        {{-- <script src="{{ asset('javascript/shop_products/search_by_name.js') }}"></script> --}}
    @endpush


@endsection
