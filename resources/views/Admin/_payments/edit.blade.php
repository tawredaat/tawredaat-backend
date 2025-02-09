@extends('Admin.index')

@section('payments-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Payments | Edit')

@section('content')
<style>
    .invalid-feedback {
        display: block;
    }
</style>

<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title">{{ $MainTitle }}</h3>
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
                                            <h3 class="m-portlet__head-text">{{ $SubTitle }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form method="POST" action="{{ route('payments.update', $payment->id) }}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="m-portlet__body">
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Name in English</label>
                                                <div class="m-input-icon m-input-icon--right">
                                                    <input name="name_en" value="{{ old('name_en', $payment->translate('en')->name) }}" required type="text" class="form-control m-input" placeholder="Enter English name">
                                                </div>
                                                @error('name_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6">
                                                <label>Name in Arabic</label>
                                                <input type="text" name="name_ar" value="{{ old('name_ar', $payment->translate('ar')->name) }}" required class="form-control m-input" placeholder="Enter Arabic name">
                                                @error('name_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6">
                                                <label>Note in English</label>
                                                <div class="m-input-icon m-input-icon--right">
                                                    <input name="note_en" value="{{ old('note_en', $payment->translate('en')->note) }}" type="text" class="form-control m-input" placeholder="Enter English note">
                                                </div>
                                                @error('note_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6">
                                                <label>Note in Arabic</label>
                                                <input type="text" name="note_ar" value="{{ old('note_ar', $payment->translate('ar')->note) }}" class="form-control m-input" placeholder="Enter Arabic note">
                                                @error('note_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6">
                                                <label>Additional Percentage</label>
                                                <input type="text" name="additional_percentage" value="{{ old('additional_percentage', $payment->additional_percentage) }}" required class="form-control m-input" placeholder="Enter Additional Percentage">
                                                @error('additional_percentage')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <label>Payment Type</label>
                                                <select class="form-control m-input" name="payment_type" required>
                                                    <option value="0" {{ $payment->payment_type == 0 ? 'selected' : '' }}>Full Payment</option>
                                                    <option value="1" {{ $payment->payment_type == 1 ? 'selected' : '' }}>Partial Payment</option>
                                                </select>
                                                @error('payment_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <label>Image:</label>
                                                <input type="file" name="image" class="form-control m-input">
                                                <img src="{{ asset('storage/' . $payment->image) }}" alt="image-not-found" width="150">
                                                @error('image')
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
                                                <div class="col-lg-6"></div>
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
        </div>
    </div>
</div>
@endsection
<!-- end::Body -->
