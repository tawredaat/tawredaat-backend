@extends('Admin.index')
@section('orders-active', 'm-menu__item--active m-menu__item--open')
@section('orders-create-active', 'm-menu__item--active')
@section('page-title', 'Orders | Create')
@section('content')
    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <!-- BEGIN: Left Aside -->
        <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <!-- BEGIN: Subheader -->
            <div class="m-subheader ">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h3 class="m-subheader__title ">
                            {{ $MainTitle }}
                        </h3>
                    </div>
                </div>
            </div>
            <!-- END: Subheader -->
            <div class="m-content">
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <div class="m-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::Portlet-->
                                <div class="m-portlet">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <span class="m-portlet__head-icon m--hide">
                                                    <i class="la la-gear"></i>
                                                </span>
                                                <h3 class="m-portlet__head-text">
                                                    {{ $SubTitle }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Form-->
                                    <form method="POST" action="{{ route('orders.store') }}"
                                        class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                                        @csrf
                                        <input type="hidden" value="0" name="order_id" />

                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label for="types">User</label>
                                                    <select name="user_id" data-actions-box="true" data-live-search="true"
                                                        class="form-control m-input selectpicker" id="users" required>

                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('user'))
                                                        <em class="invalid-feedback">
                                                            {{ $errors->first('user') }}
                                                        </em>
                                                    @endif
                                                </div>

                                            </div>

                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Address</label>
                                                    <select name="address_id" required=""
                                                        data-route="{{ route('users.address') }}"
                                                        class="form-control m-input m-input--square" id="addresses">

                                                        <option value="address">Addresses
                                                        </option>
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
                                                        name="delivery_charge" id="delivery-charge"
                                                        data-route="{{ route('cities.delivery-charge') }}" />
                                                </div>
                                            </div>

                                            <div
                                                class="form-group
                                                        m-form__group row">

                                                <div class="col-lg-6">
                                                    <label> Promo code:</label>
                                                    <select name="promo_code_id" id="promocodes"
                                                        class="form-control m-input m-input--square">
                                                        <option value="">
                                                            Promo code
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
                                                        <option @if (old('order_from') == 'Web') selected @endif
                                                            value="Web">Web</option>
                                                        <option @if (old('order_from') == 'Mobile') selected @endif
                                                            value="Mobile">Mobile</option>

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
                                                                @if (old('payment_id') == $payment->id) selected @endif>
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
                                                    <textarea class="form-control" name="comment"></textarea>

                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                @include('Admin._orders._components.details.table')
                                            </div>
                                        </div>
                                </div>
                                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                                    <div class="m-form__actions m-form__actions--solid">
                                        <div class="row">
                                            <div class="col-lg-6">
                                            </div>
                                            <div class="col-lg-6 m--align-right">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Portlet-->
                        </div>
                    </div>
                </div>
            </div>
            <!--End::Section-->
        </div>
    </div>

@endsection

@push('script')
    <script src="{{ asset('javascript/order/add_product_row.js') }}"></script>
    <script src="{{ asset('javascript/user/get_user_addresses.js') }}"></script>
    <script src="{{ asset('javascript/user/set_delivery_charge.js') }}"></script>
    <script src="{{ asset('javascript/shop_products/search_by_name.js') }}"></script>
@endpush



<!-- end:: Body -->
