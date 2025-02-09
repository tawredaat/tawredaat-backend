@extends('Admin.index')
@section('shop-products-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Shop | Products | Edit')
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
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h3 class="m-subheader__title ">
                                {{ $MainTitle }}
                            </h3>
                        </div>
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
                                    <form method="POST" action="{{ route('shop.products.update', $product->id) }}"
                                        class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Name in english:</label>
                                                    <input type="text"
                                                        value="{{ old('name_en') ? old('name_en') : $product->translate('en')->name }}"
                                                        name="name_en" required="" class="form-control m-input"
                                                        placeholder="Name in english...">
                                                    @error('name_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="">Name in arabic:</label>
                                                    <input type="text"
                                                        value="{{ old('name_ar') ? old('name_ar') : $product->translate('ar')->name }}"
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
                                                    <label>Slug in English (automatically generated):</label>
                                                    <input type="text"
                                                        value="{{ old('slug') ? old('slug') : $product->translate('en')->slug }}"
                                                        slug="slug" readonly class="form-control m-input"
                                                        placeholder="Slug in English...">
                                                    @error('slug')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="">Slug in Arabic (automatically generated):</label>
                                                    <input type="text"
                                                        value="{{ old('slug') ? old('slug') : $product->translate('ar')->slug }}"
                                                        slug="slug" readonly class="form-control m-input"
                                                        placeholder="Slug in Arabic...">
                                                    @error('slug')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4">
                                                    <label>Old Price : ( Offer Price)</label>
                                                    <input type="text"
                                                        value="{{ $product->old_price ? $product->old_price : old('old_price') }}"
                                                        name="old_price" class="form-control m-input"
                                                        placeholder="Old Price...">
                                                    @error('old_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>New Price :(Product price used in sale)</label>
                                                    <input type="text"
                                                        value="{{ $product->new_price ? $product->new_price : old('new_price') }}"
                                                        name="new_price" required="" class="form-control m-input"
                                                        placeholder="New Price...">
                                                    @error('new_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="" for="check">Sold By
                                                        {{ config('global.used_app_name', 'Tawredaat') }} :</label>
                                                    <input type="checkbox" id="check"
                                                        {{ $product->soled_by_souqkahrba ? 'checked' : '' }}
                                                        name="soled_by_souq" value="1" class="form-control m-input">
                                                    @error('soled_by_souq')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Qty :</label>
                                                    <input type="number"
                                                        value="{{ $product->qty ? $product->qty : old('qty') }}"
                                                        name="qty" required="" class="form-control m-input"
                                                        placeholder="qty...">
                                                    @error('qty')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="">Qty Type :</label>
                                                    <select required name="qty_type" class="form-control m-input">
                                                        @foreach ($quantityTypes as $qty_type)
                                                            <option @if ($product->quantity_type_id == $qty_type->id || old('qty_type') == $qty_type->id) selected @endif
                                                                value="{{ $qty_type->id }}">
                                                                {{ $qty_type->name . ' | ' . $qty_type->translate('ar')->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('qty_type')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>English Title:</label>
                                                    <input type="text"
                                                        value="{{ old('title_en') ? old('title_en') : $product->translate('en')->title }}"
                                                        class="form-control" name="title_en"
                                                        placeholder="Title in english...">
                                                    @error('title_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Arabic Title:</label>
                                                    <input type="text"
                                                        value="{{ old('title_ar') ? old('title_ar') : $product->translate('ar')->title }}"
                                                        class="form-control" name="title_ar"
                                                        placeholder="Title in arabic...">
                                                    @error('title_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>From (Delivery Time Zone):</label>
                                                    <input type="number"  value="{{ $product->from ? $product->from : old('from') }}"
                                                        class="form-control" name="from"
                                                        placeholder="From...">
                                                    @error('from')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>To (Delivery Time Zone):</label>
                                                    <input type="number" value="{{ $product->to ? $product->to : old('to') }}"
                                                        class="form-control" name="to"
                                                        placeholder="To...">
                                                    @error('to')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label class="">Main Image:</label>
                                                    <input type="file" name="image"
                                                        class="form-control m-input"><br>
                                                    @if ($product->image)
                                                        <img alt="image-not-found"
                                                            src="{{ asset('storage/' . $product->image) }}"
                                                            width="80">
                                                    @endif
                                                    @error('image')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                                <div class="col-lg-6">
                                                    <label class="">Mobile Image:</label>
                                                    <input type="file" name="mobileimg"
                                                        class="form-control m-input"><br>
                                                    @if ($product->mobileimg)
                                                        <img alt="image-not-found"
                                                            src="{{ asset('storage/' . $product->mobileimg) }}"
                                                            width="80">
                                                    @endif
                                                    @error('mobileimg')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                              	<div class="col-lg-6">
                                                    <label class="">Image two:</label>
                                                    <input type="file" name="image_name1"
                                                        class="form-control m-input"><br>
                                                    @if ($product->image_name1)
                                                        <img alt="image-not-found"
                                                            src="{{ asset('storage/' . $product->image_name1) }}"
                                                            width="80">
                                                    @endif
                                                    @error('image_name1')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                              	<div class="col-lg-6">
                                                    <label class="">Image Three:</label>
                                                    <input type="file" name="image_name2"
                                                        class="form-control m-input"><br>
                                                    @if ($product->image_name2)
                                                        <img alt="image-not-found"
                                                            src="{{ asset('storage/' . $product->image_name2) }}"
                                                            width="80">
                                                    @endif
                                                    @error('image_name2')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                              	<div class="col-lg-6">
                                                    <label class="">Image Four:</label>
                                                    <input type="file" name="image_name3"
                                                        class="form-control m-input"><br>
                                                    @if ($product->image_name3)
                                                        <img alt="image-not-found"
                                                            src="{{ asset('storage/' . $product->image_name3) }}"
                                                            width="80">
                                                    @endif
                                                    @error('image_name3')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="">PDF:</label>
                                                    <input type="file" name="pdf"
                                                        class="form-control m-input"><br>
                                                    @if ($product->pdf)
                                                        <a href="{{ asset('storage/' . $product->pdf) }}"
                                                            class="btn btn-primary"><i class="fa fa-download"></i>Product
                                                            PDF</a>
                                                    @endif
                                                    @error('pdf')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>ALT image in english:</label>
                                                    <input type="text"
                                                        value="{{ old('alt_en') ? old('alt_en') : $product->translate('en')->alt }}"
                                                        name="alt_en" class="form-control m-input"
                                                        placeholder="Alt image in english...">
                                                    @error('alt_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="">Alt image in arabic:</label>
                                                    <input type="text" name="alt_ar"
                                                        value="{{ old('alt_ar') ? old('alt_ar') : $product->translate('ar')->alt }}"
                                                        class="form-control m-input" placeholder="Alt image in arabic...">
                                                    @error('alt_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>English Keywords:</label>
                                                    <input id="keywords_en" data-role="tagsinput" class="form-control"
                                                        name="keywords_en" placeholder="english keywords"
                                                        value="{{ old('keywords_en') ? old('keywords_en') : $product->translate('en')->keywords }}">
                                                    @error('keywords_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Arabic Keywords:</label>
                                                    <input id="keywords_ar" data-role="tagsinput" class="form-control"
                                                        name="keywords_ar" placeholder="Arabic keywords"
                                                        value="{{ old('keywords_ar') ? old('keywords_ar') : $product->translate('ar')->keywords }}">
                                                    @error('keywords_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Keywords meta in english:</label>
                                                    <input id="keywords_meta_en" data-role="tagsinput"
                                                        class="form-control" name="keywords_meta_en"
                                                        placeholder="Keywords meta in english..."
                                                        value="{{ old('keywords_meta_en') ? old('keywords_meta_en') : $product->translate('en')->keywords_meta }}">

                                                    @error('keywords_meta_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Arabic Keywords Meta:</label>
                                                    <input id="keywords_meta_ar" data-role="tagsinput"
                                                        class="form-control" name="keywords_meta_ar"
                                                        placeholder="Keywords meta in arabic..."
                                                        value="{{ old('keywords_meta_ar') ? old('keywords_meta_ar') : $product->translate('ar')->keywords_meta }}">
                                                    @error('keywords_meta_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Description in English:</label>
                                                    <textarea id="description_en" class="form-control" name="description_en" placeholder="Description in english">{{ old('description_en') ? old('description_en') : $product->translate('en')->description }}</textarea>
                                                    @error('description_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Description in Arabic:</label>
                                                    <textarea id="description_ar" class="form-control" name="description_ar" placeholder="Description Arabic">{{ old('description_ar') ? old('description_ar') : $product->translate('ar')->description }}</textarea>
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
                                                    <textarea class="form-control" name="description_meta_en" placeholder="Description Meta English">{{ old('description_meta_en') ? old('description_meta_en') : $product->translate('en')->description_meta }}</textarea> @error('description_meta_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Description Meta in Arabic:</label>
                                                    <textarea class="form-control" name="description_meta_ar" placeholder="Description Meta Arabic">{{ old('description_meta_ar') ? old('description_meta_ar') : $product->translate('ar')->description_meta }}</textarea>
                                                    @error('description_meta_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Video link:</label>
                                                    <input type="text" name="video"
                                                        value="{{ old('video') ? old('video') : $product->video }}"
                                                        class="form-control m-input" placeholder="Video Link...">
                                                    @error('video')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>SKU Code:</label>
                                                    <input type="text" name="sku_code"
                                                        value="{{ old('sku_code') ? old('sku_code') : $product->sku_code }}"
                                                        class="form-control m-input" placeholder="SKU code...">
                                                    @error('sku_code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Brand</label>
                                                    <select class="form-control m-input" name="brand_id" required>
                                                        @if (old('brand_id'))
                                                            @foreach ($brands as $brand)
                                                                <option @if (old('brand_id') == $brand->id) selected @endif
                                                                    value="{{ $brand->id }}">{{ $brand->name }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            @foreach ($brands as $brand)
                                                                <option @if ($product->brand_id == $brand->id) selected @endif
                                                                    value="{{ $brand->id }}">{{ $brand->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('brand_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Category</label>
                                                    <select class="form-control m-input " name="category_id" required>
                                                        @if (old('category_id'))
                                                            @foreach ($level3Categories as $category)
                                                                <option @if (old('cateogry_id') == $category->id) selected @endif
                                                                    value="{{ $category->id }}">{{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            @foreach ($level3Categories as $category)
                                                                <option @if ($product->category_id == $category->id) selected @endif
                                                                    value="{{ $category->id }}">{{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('category_id')
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
    @push('script')
        <script type="text/javascript">
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
                $('#description_en').summernote({
                    tabsize: 2,
                    height: 150
                });
                $('#description_ar').summernote({
                    tabsize: 2,
                    height: 150
                });
            });
            $('#keywords_en, #keywords_ar,#keywords_meta_en,#keywords_meta_ar').tagsinput({
                confirmKeys: [13, 188]
            });

            $('.bootstrap-tagsinput').on('keypress', function(e) {
                if (e.keyCode == 13) {
                    e.keyCode = 188;
                    e.preventDefault();
                };
            });
        </script>
    @endpush
@endsection
<!-- end:: Body -->
