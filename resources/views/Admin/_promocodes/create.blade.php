@extends('Admin.index')
@section('promoCodes-active', 'm-menu__item--active m-menu__item--open')
@section('promoCodes-create-active', 'm-menu__item--active')
@section('page-title', 'Promocodes|Create')
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
                                    <form method="POST" action="{{ route('promocodes.store') }}" id="promo-code-form"
                                        class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                                        @csrf
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Name in english</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="name_en" value="{{ old('name_en') }}" required
                                                            type="text" class="form-control m-input"
                                                            placeholder="Enter name in english...">
                                                    </div>
                                                    @error('name_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Name in arabic</label>
                                                    <input type="text" name="name_ar" value="{{ old('name_ar') }}"
                                                        required class="form-control m-input"
                                                        placeholder="Enter name in arabic...">
                                                    @error('name_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4">
                                                    <label>Code</label>
                                                    <input type="text" name="code" value="{{ old('code') }}"
                                                        required class="form-control m-input" placeholder="Enter Code...">
                                                    @error('code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Discount Type</label>
                                                        <select name="discount_type" id="discount_type" required=""
                                                            class="form-control m-input m-input--square"
                                                            id="exampleSelect1">
                                                            <option @if (old('discount_type') == 'value') selected @endif
                                                                value="value">Monetary value</option>
                                                            <option @if (old('discount_type') == 'percentage') selected @endif
                                                                value="percentage">%</option>
                                                            <option @if (old('discount_type') == 'remove shipping fees') selected @endif
                                                                value="remove shipping fees">Remove shipping fees</option>
                                                        </select>
                                                    </div>
                                                    @error('discount_type')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Discount</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="discount" id="discount" value="{{ old('discount') }}"
                                                            required type="number" step="0.01"
                                                            class="form-control m-input" placeholder="Enter discount...">
                                                    </div>
                                                    @error('discount')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                      <label>Min Amount</label>
                                                      <div class="m-input-icon m-input-icon--right">
                                                          <input name="min_amount"
                                                                 required
                                                                 id="min_amount" 
                                                                 value="{{ old('min_amount') }}"
                                                                 type="number" 
                                                                 step="0.01" 
                                                                 min="0" 
                                                                 class="form-control m-input" 
                                                                 placeholder="Enter Min Amount...">
                                                      </div>
                                                      @error('min_amount')
                                                          <span class="invalid-feedback" role="alert">
                                                              <strong>{{ $message }}</strong>
                                                          </span>
                                                      @enderror
                                                </div>
                                              	<div class="col-lg-4">
                                                    <label>Max Amount</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="max_amount" 
                                                               id="max_amount" 
                                                               value="{{ old('max_amount') }}"
                                                               type="number" 
                                                               step="0.01" 
                                                               min="0" 
                                                               class="form-control m-input" 
                                                               placeholder="Enter Max Amount...">
                                                    </div>
                                                    @error('max_amount')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Valid From</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="valid_from" id="valid_from" value="{{ old('valid_from') }}"
                                                            required type="date" 
                                                            class="form-control m-input" placeholder="Enter Valid From Date...">
                                                    </div>
                                                    @error('valid_from')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Valid To</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="valid_to" id="valid_to" value="{{ old('valid_to') }}"
                                                            required type="date" step="0.01"
                                                            class="form-control m-input" placeholder="Enter valid To Date...">
                                                    </div>
                                                    @error('valid_to')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label># of Uses</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="uses" id="uses" value="{{ old('uses') }}"
                                                            required type="number" step="0.01"
                                                            class="form-control m-input" placeholder="Enter No Of Uses...">
                                                    </div>
                                                    @error('uses')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Select a Brand</label>
                                                    <select name="brand_id[]" id="brand_id" class="form-control" multiple>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
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
@push('script')
    <script src="{{ asset('javascript/disable_discount.js') }}"></script>
@endpush
<!-- end:: Body -->
