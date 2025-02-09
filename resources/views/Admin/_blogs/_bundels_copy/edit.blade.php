<!-- end:: Body -->
@extends('Admin.index')
@section('bundels-active', 'm-menu__item--active m-menu__item--open')
@section('bundels-edit-active', 'm-menu__item--active')
@section('page-title', 'Shop | Products | Edit')
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
                                    <form method="POST" action="{{ route('bundels.update', $bundel->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <!-- Name Fields -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Name in English:</label>
                                                <input type="text" name="name_en" value="{{ old('name_en', $bundel->translate('en')->name) }}" class="form-control m-input" placeholder="Name in English" required>
                                                @error('name_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Name in Arabic:</label>
                                                <input type="text" name="name_ar" value="{{ old('name_ar', $bundel->translate('ar')->name) }}" class="form-control m-input" placeholder="Name in Arabic" required>
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
                                                <input type="text" name="alt_en" value="{{ old('alt_en', $bundel->translate('en')->alt) }}" class="form-control m-input" placeholder="Alt Text in English" required>
                                                @error('alt_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Alt Text in Arabic:</label>
                                                <input type="text" name="alt_ar" value="{{ old('alt_ar', $bundel->translate('ar')->alt) }}" class="form-control m-input" placeholder="Alt Text in Arabic" required>
                                                @error('alt_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Title Fields -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Title in English:</label>
                                                <input type="text" name="title_en" value="{{ old('title_en', $bundel->translate('en')->title) }}" class="form-control m-input" placeholder="Title in English" required>
                                                @error('title_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Title in Arabic:</label>
                                                <input type="text" name="title_ar" value="{{ old('title_ar', $bundel->translate('ar')->title) }}" class="form-control m-input" placeholder="Title in Arabic" required>
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
                                                <textarea id="description_en" class="form-control" name="description_en" placeholder="Description in English..." required>{{ old('description_en', $bundel->translate('en')->description) }}</textarea>
                                                @error('description_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Description in Arabic:</label>
                                                <textarea id="description_ar" class="form-control" name="description_ar" placeholder="Description in Arabic..." required>{{ old('description_ar', $bundel->translate('ar')->description) }}</textarea>
                                                @error('description_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- Description Meta Fields -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Description Meta in English:</label>
                                                <textarea id="description_meta_en" class="form-control" name="description_meta_en" placeholder="Description Meta in English..." required>{{ old('description_meta_en', $bundel->translate('en')->description_meta) }}</textarea>
                                                @error('description_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Description Meta in Arabic:</label>
                                                <textarea id="description_meta_ar" class="form-control" name="description_meta_ar" placeholder="Description Meta in Arabic..." required>{{ old('description_meta_ar', $bundel->translate('ar')->description_meta) }}</textarea>
                                                @error('description_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- KeyWords  Fields -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Keywords in English:</label>
                                                <textarea id="keywords_en" class="form-control" name="keywords_en" placeholder="Keywords in English..." required>{{ old('keywords_en', $bundel->translate('en')->keywords) }}</textarea>
                                                @error('keywords_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Keywords in Arabic:</label>
                                                <textarea id="keywords_ar" class="form-control" name="keywords_ar" placeholder="Keywords in Arabic..." required>{{ old('keywords_ar', $bundel->translate('ar')->keywords) }}
                                                    </textarea>
                                                @error('keywords_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- KeyWords Meta Fields -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Keywords Meta in English:</label>
                                                <textarea id="keywords_meta_en" class="form-control" name="keywords_meta_en" placeholder="Keywords Meta in English..." required>{{ old('keywords_meta_en', $bundel->translate('en')->keywords_meta) }}</textarea>
                                                @error('keywords_meta_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Keywords Meta in Arabic:</label>
                                                <textarea id="keywords_meta_ar" class="form-control" name="keywords_meta_ar" placeholder="Keywords Meta in Arabic..." required>{{ old('keywords_meta_ar', $bundel->translate('ar')->keywords_meta) }}</textarea>
                                                @error('keywords_meta_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- Prices Fields -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Discount percentage:</label>
                                                <input type="number" name="discount_percentage" value="{{ old('discount_percentage', $bundel->discount_percentage) }}" class="form-control m-input" placeholder="Discount percentage:" required>
                                                @error('discount_percentage')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Quantity:</label>
                                                <input type="number" name="qty" value="{{ old('qty', $bundel->qty) }}" class="form-control m-input" placeholder="Quantity" required>
                                                @error('qty')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Seller in English:</label>
                                                <input type="text" name="seller_en" value="{{ old('seller_en', $bundel->translate('en')->seller) }}" class="form-control m-input" placeholder="Seller in English" required>
                                                @error('seller_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Seller in Arabic:</label>
                                                <input type="text" name="seller_ar" value="{{ old('seller_ar', $bundel->translate('ar')->seller) }}" class="form-control m-input" placeholder="Seller in Arabic" required>
                                                @error('seller_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>SLA in English:</label>
                                                <input type="text" name="sla_en" value="{{ old('sla_en', $bundel->translate('en')->sla) }}" class="form-control m-input" placeholder="SLA in English" required>
                                                @error('sla_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>SLA in Arabic:</label>
                                                <input type="text" name="sla_ar" value="{{ old('sla_ar', $bundel->translate('ar')->sla) }}" class="form-control m-input" placeholder="Seller in Arabic" required>
                                                @error('sla_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Note in English:</label>
                                                <input type="text" name="note_en" value="{{ old('note_en', $bundel->translate('en')->note) }}" class="form-control m-input" placeholder="Note in English" required>
                                                @error('note_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Note in Arabic:</label>
                                                <input type="text" name="note_ar" value="{{ old('note_ar', $bundel->translate('ar')->note) }}" class="form-control m-input" placeholder="Note in Arabic" required>
                                                @error('note_ar')
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
                                                <img src="{{ asset('storage/' . $bundel->translate('en')->image) }}" alt="image-not-found" width="150">
                                                @error('image_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <label>Image (Arabic):</label>
                                                <input type="file" name="image_ar" class="form-control m-input">
                                                <img src="{{ asset('storage/' . $bundel->translate('ar')->image) }}" alt="image-not-found" width="150">
                                                @error('image_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
        
                                            <div class="col-lg-6">
                                                <label>Mobile Image (English):</label>
                                                <input type="file" name="mobile_image_en" class="form-control m-input">
                                                <img src="{{ asset('storage/' . $bundel->translate('en')->mobile_image) }}" alt="image-not-found" width="150">
                                                @error('mobile_image_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
        
                                            <div class="col-lg-6">
                                                <label>Mobile Image (Arabic):</label>
                                                <input type="file" name="mobile_image_ar" class="form-control m-input">
                                                <img src="{{ asset('storage/' . $bundel->translate('ar')->mobile_image) }}" alt="image-not-found" width="150">
                                                @error('mobile_image_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>SKU Code:</label>
                                                <input type="text" name="sku_code" value="{{ old('sku_code', $bundel->sku_code) }}" class="form-control m-input" placeholder="SKU Code:" required>
                                                @error('discount_percentage')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Category</label>
                                                <select class="form-control m-input" name="category_id[]" multiple required>
                                                    @foreach ($categories as $category)
                                                        <option @if (in_array($category->id, $bundel->categories->pluck('id')->toArray())) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
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
