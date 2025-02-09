@extends('Admin.index')
@section('banners-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Banner | Create')
@section('content')
?>
<style>
    ::-webkit-file-upload-button {
        background-color: #5867dd;
        border: 1px solid #5867dd;
        border-radius: 5px;
        color: #fff;
        padding: 5px 10px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    ::-webkit-file-upload-button:hover {
        background-color: #4752b1;
    }

    .invalid-feedback {
        display: block;
    }

    .form-group label {
        font-weight: bold;
        color: #4a4a4a;
    }

    .form-group img {
        margin-top: 10px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .m-form__group.row > div {
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #5867dd;
        border-color: #5867dd;
        padding: 10px 20px;
        font-weight: bold;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #4752b1;
        border-color: #4752b1;
    }

    .m-portlet__head-text {
        color: #5867dd;
        font-weight: bold;
    }
</style>
<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title">{{ $MainTitle }}</h3>
                </div>
            </div>
        </div>
        <div class="m-content">
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Portlet-->
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">{{ $SubTitle }}</h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('banners.update', $banner->id) }}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label>Image (Arabic):</label>
                                        <input type="file" name="image_ar" class="form-control m-input">
                                        <img src="{{ asset('storage/' . $banner->translate('ar')->img) }}" alt="image-not-found" width="150">
                                        @error('image_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Image (English):</label>
                                        <input type="file" name="image_en" class="form-control m-input">
                                        <img src="{{ asset('storage/' . $banner->translate('en')->img) }}" alt="image-not-found" width="150">
                                        @error('image_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Mobile Image (Arabic):</label>
                                        <input type="file" name="mobile_image_ar" class="form-control m-input">
                                        <img src="{{ asset('storage/' . $banner->translate('ar')->mobileimg) }}" alt="image-not-found" width="150">
                                        @error('mobile_image_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Mobile Image (English):</label>
                                        <input type="file" name="mobile_image_en" class="form-control m-input">
                                        <img src="{{ asset('storage/' . $banner->translate('en')->mobileimg) }}" alt="image-not-found" width="150">
                                        @error('mobile_image_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label>Alt text (English):</label>
                                        <input type="text" name="altEN" value="{{ old('altEN', $banner->translate('en')->alt) }}" required class="form-control m-input" placeholder="Alt text in English...">
                                        @error('altEN')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Alt text (Arabic):</label>
                                        <input type="text" name="altAR" value="{{ old('altAR', $banner->translate('ar')->alt) }}" required class="form-control m-input" placeholder="Alt text in Arabic...">
                                        @error('altAR')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label>URL (English):</label>
                                        <input type="text" name="urlEN" value="{{ old('urlEN', $banner->translate('en')->url) }}" required class="form-control m-input" placeholder="URL in English">
                                        @error('urlEN')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label>URL (Arabic):</label>
                                        <input type="text" name="urlAR" value="{{ old('urlAR', $banner->translate('ar')->url) }}" required class="form-control m-input" placeholder="URL in Arabic">
                                        @error('urlAR')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <!--<div class="form-group m-form__group row">-->
                                    <!--    <div class="col-lg-12">-->
                                    <!--        <label>Select Section:</label>-->
                                    <!--        <select name="section" class="form-control m-input" required>-->
                                    <!--            <option value="1" {{ (old('section') == '1' || (isset($banner) && $banner->section == '1')) ? 'selected' : '' }}>Slider</option>-->
                                    <!--            <option value="2" {{ (old('section') == '2' || (isset($banner) && $banner->section == '2')) ? 'selected' : '' }}>First Section Banners</option>-->
                                    <!--            <option value="3" {{ (old('section') == '3' || (isset($banner) && $banner->section == '3')) ? 'selected' : '' }}>Second Section Banners</option>-->
                                    <!--            <option value="4" {{ (old('section') == '4' || (isset($banner) && $banner->section == '4')) ? 'selected' : '' }}>Third Section Banners</option>-->
                                    <!--        </select>-->
                                    <!--        @error('section')-->
                                    <!--            <span class="invalid-feedback" role="alert">-->
                                    <!--                <strong>{{ $message }}</strong>-->
                                    <!--            </span>-->
                                    <!--        @enderror-->
                                    <!--    </div>-->
                                    <!--</div>-->
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
</div>
@endsection
<!-- end::Body -->
