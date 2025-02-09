<!-- end:: Body -->
@extends('Admin.index')
@section('seo-active', 'm-menu__item--active m-menu__item--open')
@section('seo-edit-active', 'm-menu__item--active')
@section('page-title', 'SEO | Edit')
@section('content')
    <style type="text/css">
        /* Your existing styles here */
    </style>
    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="m-subheader ">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h3 class="m-subheader__title ">
                            {{ $MainTitle }} - {{$seo->page_name}}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-content">
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <div class="m-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-portlet">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text">
                                                    {{ $SubTitle }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Form-->
                                    <form method="POST" action="{{ route('seo.update', $seo->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Title Fields -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Title in English:</label>
                                                <input type="text" name="title_en" value="{{ old('title_en', $seo->translate('en')->title) }}" class="form-control m-input" placeholder="Title in English" required>
                                                @error('title_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Title in Arabic:</label>
                                                <input type="text" name="title_ar" value="{{ old('title_ar', $seo->translate('ar')->title) }}" class="form-control m-input" placeholder="Title in Arabic" required>
                                                @error('title_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Description Fields -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Description in English:</label>
                                                <textarea id="description_en" class="form-control" name="description_en" placeholder="Description in English..." required>{{ old('description_en', $seo->translate('en')->description) }}</textarea>
                                                @error('description_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Description in Arabic:</label>
                                                <textarea id="description_ar" class="form-control" name="description_ar" placeholder="Description in Arabic..." required>{{ old('description_ar', $seo->translate('ar')->description) }}</textarea>
                                                @error('description_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Image (English):</label>
                                                <input type="file" name="image_en" class="form-control m-input">
                                                <img src="{{ asset('storage/' . $seo->translate('en')->image) }}" alt="image-not-found" width="150">
                                                @error('image_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <label>Image (Arabic):</label>
                                                <input type="file" name="image_ar" class="form-control m-input">
                                                <img src="{{ asset('storage/' . $seo->translate('ar')->image) }}" alt="image-not-found" width="150">
                                                @error('image_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- Submit Button -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-12 text-right">
                                                <button type="submit" class="btn btn-primary">Update</button>
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
<!-- end:: Body -->
