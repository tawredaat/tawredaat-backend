@extends('Admin.index')
@section('cities-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Cities|Edit')
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
                                    <form method="POST" action="{{ route('cities.update', $city->id) }}"
                                        class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                                        @method('put')
                                        @csrf
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Name in english:</label>
                                                    <input type="text" name="name_en" required=""
                                                        value="{{ old('name_en') ? old('name_en') : $city->translate('en')->name }}"
                                                        class="form-control m-input" placeholder="Name in english...">
                                                    @error('name_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="">Name in arabic:</label>
                                                    <input type="text"
                                                        value="{{ old('name_ar') ? old('name_ar') : $city->translate('ar')->name }}"
                                                        name="name_ar" required="" class="form-control m-input"
                                                        placeholder="Name in arabic...">
                                                    @error('name_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Shipping Fees:</label>
                                                    <input type="text" name="shipping_fees" required=""
                                                        value="{{ old('shipping_fees', $city->shipping_fees) }}"
                                                        class="form-control m-input" placeholder="Shipping Fees...">
                                                    @error('shipping_fees')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
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
    </div>
@endsection
<!-- end:: Body -->
