@extends('Admin.index')
@section('bundels-active', 'm-menu__item--active m-menu__item--open')
@section('bundels-create-active', 'm-menu__item--active')
@section('page-title', 'Shop | Products | Create')
@section('content')
    <style type="text/css">
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

        .bootstrap-tagsinput {
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            display: block;
            padding: 4px 6px;
            color: #555;
            vertical-align: middle;
            border-radius: 4px;
            max-width: 100%;
            line-height: 22px;
            cursor: text;
        }

        .bootstrap-tagsinput input {
            border: none;
            box-shadow: none;
            outline: none;
            background-color: transparent;
            padding: 0 6px;
            margin: 0;
            width: auto;
            max-width: inherit;
        }

        .tag {
            background: #888;
            padding: 2px;
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
                                    <form method="POST" action="{{ route('bundels.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <!-- Name Fields -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Name in English:</label>
                                                <input type="text" name="name_en" value="{{ old('name_en') }}" class="form-control m-input" placeholder="Name in English" required>
                                                @error('name_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Name in Arabic:</label>
                                                <input type="text" name="name_ar" value="{{ old('name_ar') }}" class="form-control m-input" placeholder="Name in Arabic" required>
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
                                                <input type="text" name="alt_en" value="{{ old('alt_en') }}" class="form-control m-input" placeholder="Alt Text in English" required>
                                                @error('alt_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Alt Text in Arabic:</label>
                                                <input type="text" name="alt_ar" value="{{ old('alt_ar') }}" class="form-control m-input" placeholder="Alt Text in Arabic" required>
                                                @error('alt_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Title in English:</label>
                                                <input type="text" name="title_en" value="{{ old('title_en') }}" class="form-control m-input" placeholder="Title in English" required>
                                                @error('title_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Title in Arabic:</label>
                                                <input type="text" name="title_ar" value="{{ old('title_ar') }}" class="form-control m-input" placeholder="Title in Arabic" required>
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
                                                <textarea id="description_en" class="form-control" name="description_en" placeholder="Description in English..." required>{{ old('description_en') }}</textarea>
                                                @error('description_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Description in Arabic:</label>
                                                <textarea id="description_ar" class="form-control" name="description_ar" placeholder="Description in Arabic..." required>{{ old('description_ar') }}</textarea>
                                                @error('description_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Description Meta in English:</label>
                                                <textarea id="description_meta_en" class="form-control" name="description_meta_en" placeholder="Description Meta in English..." required>{{ old('description_meta_en') }}</textarea>
                                                @error('description_meta_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Description Meta in Arabic:</label>
                                                <textarea id="description_meta_ar" class="form-control" name="description_meta_ar" placeholder="Description Meta in Arabic..." required>{{ old('description_meta_ar') }}</textarea>
                                                @error('description_meta_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Keywords En:</label>
                                                <input type="text" name="keywords_en" value="{{ old('keywords_en') }}" class="form-control m-input" placeholder="Keywords En" required>
                                                @error('keywords_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Keywords AR:</label>
                                                <input type="text" name="keywords_ar" value="{{ old('keywords_ar') }}" class="form-control m-input" placeholder="Keywords AR" required>
                                                @error('keywords_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Keywords Meta En:</label>
                                                <input type="text" name="keywords_meta_en" value="{{ old('keywords_meta_en') }}" class="form-control m-input" placeholder="Keywords Meta En" required>
                                                @error('keywords_meta_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Keywords Meta AR:</label>
                                                <input type="text" name="keywords_meta_ar" value="{{ old('Keywords_meta_ar') }}" class="form-control m-input" placeholder="Keywords Meta AR" required>
                                                @error('Keywords_meta_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                        <!-- Discount percentage-->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Discount percentage:</label>
                                                <input type="text" name="discount_percentage" value="{{ old('discount_percentage') }}" class="form-control m-input" placeholder="Discount percentage" required>
                                                @error('discount_percentage')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        
                                            <div class="col-lg-6">
                                                <label>Quantity:</label>
                                                <input type="text" name="qty" value="{{ old('qty') }}" class="form-control m-input" placeholder="Quantity" required>
                                                @error('qty')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                        <!-- Seller Information -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Seller Name in English:</label>
                                                <input type="text" name="seller_en" value="{{ old('seller_en') }}" class="form-control m-input" placeholder="Seller Name in English" required>
                                                @error('seller_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Seller Name in Arabic:</label>
                                                <input type="text" name="seller_ar" value="{{ old('seller_ar') }}" class="form-control m-input" placeholder="Seller Name in Arabic" required>
                                                @error('seller_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                        <!-- SLA Information -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>SLA in English:</label>
                                                <input type="text" name="sla_en" value="{{ old('sla_en') }}" class="form-control m-input" placeholder="SLA in English" required>
                                                @error('sla_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>SLA in Arabic:</label>
                                                <input type="text" name="sla_ar" value="{{ old('sla_ar') }}" class="form-control m-input" placeholder="SLA in Arabic" required>
                                                @error('sla_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                        <!-- Note Fields -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Note in English:</label>
                                                <input type="text" name="note_en" value="{{ old('note_en') }}" class="form-control m-input" placeholder="Note in English" required>
                                                @error('note_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Note in Arabic:</label>
                                                <input type="text" name="note_ar" value="{{ old('note_ar') }}" class="form-control m-input" placeholder="Note in Arabic" required>
                                                @error('note_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Image in Arabic:</label>
                                                <input type="file" name="image_ar" class="form-control-file" accept="image/*" required>
                                                @error('image_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Image in English:</label>
                                                <input type="file" name="image_en" class="form-control-file" accept="image/*" required>
                                                @error('image_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Mobile Image in Arabic:</label>
                                                <input type="file" name="mobile_image_ar" class="form-control-file" accept="image/*" required>
                                                @error('mobile_image_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Mobile Image in English:</label>
                                                <input type="file" name="mobile_image_en" class="form-control-file" accept="image/*" required>
                                                @error('mobile_image_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Brand and Category -->
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Sku Code:</label>
                                                <input type="text" name="sku_code" class="form-control m-input" placeholder="Sku Code" required>
                                                @error('sku_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Category</label>
                                                <select class="form-control m-input" name="category_id[]" multiple required>
                                                    @foreach ($categories as $category)
                                                        <option @if (in_array($category->id, old('category_id', []))) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                <button type="submit" class="btn btn-primary">Save</button>
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
