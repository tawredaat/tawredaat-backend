<!-- end:: Body -->
@extends('Admin.index')
@section('dynamic-page-active', 'm-menu__item--active m-menu__item--open')
@section('dynamic-page-edit-active', 'm-menu__item--active')
@section('page-title', 'Dynamic | Page | Edit')
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
                            {{ $MainTitle }}
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
                                    <form method="POST" action="{{ route('dynamic-page.update', $dynamic_page->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <!-- Name Fields -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>URL:</label>
                                                <input type="text" name="url" value="{{ old('url', $dynamic_page->url) }}" class="form-control m-input" placeholder="URL" required disabled>
                                                @error('url')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Name in English:</label>
                                                <input type="text" name="name_en" value="{{ old('name_en', $dynamic_page->translate('en')->name) }}" class="form-control m-input" placeholder="Name in English" required>
                                                @error('name_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Name in Arabic:</label>
                                                <input type="text" name="name_ar" value="{{ old('name_ar', $dynamic_page->translate('ar')->name) }}" class="form-control m-input" placeholder="Name in Arabic" required>
                                                @error('name_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                        <!-- Alt and Title Fields -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Alt Text in English:</label>
                                                <input type="text" name="alt_en" value="{{ old('alt_en', $dynamic_page->translate('en')->alt) }}" class="form-control m-input" placeholder="Alt Text in English" required>
                                                @error('alt_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Alt Text in Arabic:</label>
                                                <input type="text" name="alt_ar" value="{{ old('alt_ar', $dynamic_page->translate('ar')->alt) }}" class="form-control m-input" placeholder="Alt Text in Arabic" required>
                                                @error('alt_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                         <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Page Title in English:</label>
                                                <input type="text" name="page_title_en" value="{{ old('page_title_en', $dynamic_page->translate('en')->page_title) }}" class="form-control m-input" placeholder="Page Title in English" required>
                                                @error('page_title_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Page Title in Arabic:</label>
                                                <input type="text" name="page_title_ar" value="{{ old('page_title_ar', $dynamic_page->translate('ar')->page_title) }}" class="form-control m-input" placeholder="Page Title in Arabic" required>
                                                @error('page_title_ar')
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
                                                <textarea id="description_en" class="form-control" name="description_en" placeholder="Description in English..." required>{{ old('description_en', $dynamic_page->translate('en')->description) }}</textarea>
                                                @error('description_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Description in Arabic:</label>
                                                <textarea id="description_ar" class="form-control" name="description_ar" placeholder="Description in Arabic..." required>{{ old('description_ar', $dynamic_page->translate('ar')->description) }}</textarea>
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
                                                <input type="file" name="main_banner_en" class="form-control m-input">
                                                <img src="{{ asset('storage/' . $dynamic_page->translate('en')->main_banner) }}" alt="image-not-found" width="150">
                                                @error('main_banner_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <label>Image (Arabic):</label>
                                                <input type="file" name="main_banner_ar" class="form-control m-input">
                                                <img src="{{ asset('storage/' . $dynamic_page->translate('ar')->main_banner) }}" alt="image-not-found" width="150">
                                                @error('main_banner_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
        
                                            <div class="col-lg-6">
                                                <label>Mobile Image (English):</label>
                                                <input type="file" name="main_banner_mobile_en" class="form-control m-input">
                                                <img src="{{ asset('storage/' . $dynamic_page->translate('en')->main_banner_mobile) }}" alt="image-not-found" width="150">
                                                @error('main_banner_mobile_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
        
                                            <div class="col-lg-6">
                                                <label>Mobile Image (Arabic):</label>
                                                <input type="file" name="main_banner_mobile_ar" class="form-control m-input">
                                                <img src="{{ asset('storage/' . $dynamic_page->translate('ar')->main_banner_mobile) }}" alt="image-not-found" width="150">
                                                @error('main_banner_mobile_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Shop Products</label>
                                                <select class="form-control m-input" name="shopProducts[]" multiple required>
                                                    @foreach ($shopProducts as $product)
                                                        <option 
                                                            @if ($dynamic_page->shopProducts && in_array($product->id, $dynamic_page->shopProducts->pluck('shop_product_id')->toArray())) 
                                                                selected 
                                                            @endif 
                                                            value="{{ $product->id }}">
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('shopProducts')
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
