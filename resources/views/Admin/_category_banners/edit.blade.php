@extends('Admin.index')
@section('categories-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Banner|Create')
@section('content')
    <style>
        ::-webkit-file-upload-button {
            background-color: #5867dd;
            border: 1px solid #5867dd;
            border-radius: 5px;
            color: #fff;
            padding: 2px;

        }

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
                            {{ $main_title }}
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
                                                    {{ $sub_title }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Form-->
                                    <form method="POST"
                                        action="{{ route('category-banners.update', $category_banner->id) }}"
                                        class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Image Ar:</label>
                                                    <input type="file"
                                                        value="{{ old('image_ar') ? old('image_ar') : $category_banner->translate('ar')->image }}"
                                                        name="image_ar" class="form-control m-input">
                                                    <img alt="image-not-found"
                                                        src="{{ asset('storage/' . $category_banner->translate('ar')->image) }}"
                                                        width="80">
                                                    @error('image')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-lg-6">
                                                    <label>Image En:</label>
                                                    <input type="file"
                                                        value="{{ old('image_en') ? old('image_en') : $category_banner->translate('en')->image }}"
                                                        name="image_en" class="form-control m-input">
                                                    <img alt="image-not-found"
                                                        src="{{ asset('storage/' . $category_banner->translate('en')->image) }}"
                                                        width="80">
                                                    @error('mobile_image')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-lg-6">
                                                    <label>Mobile Image Ar:</label>
                                                    <input type="file"
                                                        value="{{ old('mobile_image_ar') ? old('mobile_image_ar') : $category_banner->translate('ar')->mobile_image }}"
                                                        name="mobile_image_ar" class="form-control m-input">
                                                    <img alt="image-not-found"
                                                        src="{{ asset('storage/' . $category_banner->translate('ar')->mobile_image) }}"
                                                        width="80">
                                                    @error('image')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-lg-6">
                                                    <label>Image En:</label>
                                                    <input type="file"
                                                        value="{{ old('mobile_image_en') ? old('mobile_image_en') : $category_banner->translate('en')->mobile_image }}"
                                                        name="mobile_image_en" class="form-control m-input">
                                                    <img alt="image-not-found"
                                                        src="{{ asset('storage/' . $category_banner->translate('en')->mobile_image) }}"
                                                        width="80">
                                                    @error('mobile_image')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>ALt text in english:</label>
                                                    <input type="text"
                                                        value="{{ old('alt_en') ? old('alt_en') : $category_banner->translate('en')->alt }}"
                                                        name="alt_en" required="" class="form-control m-input"
                                                        placeholder="ALt text in english...">
                                                    @error('alt_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="">ALt text in arabic:</label>
                                                    <input type="text"
                                                        value="{{ old('alt_ar') ? old('alt_ar') : $category_banner->translate('ar')->alt }}"
                                                        name="alt_ar" required="" class="form-control m-input"
                                                        placeholder="ALt text in arabic...">
                                                    @error('alt_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label class="">URL:</label>
                                                    <input type="text"
                                                        value="{{ old('url') ? old('url') : $category_banner->url }}"
                                                        name="url" required="" class="form-control m-input"
                                                        placeholder="URL...">
                                                    @error('url')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                            <label>Select Section:</label>
                                            <select name="section" class="form-control m-input" required>
                                                <option value="1" {{ (old('section') == '1' || (isset($banner) && $banner->section == '1')) ? 'selected' : '' }}>Main Banner</option>
                                                <option value="2" {{ (old('section') == '2' || (isset($banner) && $banner->section == '2')) ? 'selected' : '' }}>Ads # 1</option>
                                                <option value="3" {{ (old('section') == '3' || (isset($banner) && $banner->section == '3')) ? 'selected' : '' }}>Ads # 2</option>
                                                <option value="4" {{ (old('section') == '4' || (isset($banner) && $banner->section == '4')) ? 'selected' : '' }}>Ads # 3</option>
                                            </select>
                                            @error('section')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
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
