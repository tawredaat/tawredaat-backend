@extends('Admin.index')
@section('categories-brands-store-pages-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Categories brands in the brands store page |Edit')
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
                                        action="{{ route('categories-brands-store-pages.update', $category_brand_store_page->id) }}"
                                        enctype="multipart/form-data"
                                        class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                                        @method('put')
                                        @csrf
                                        <input name="id" value="{{ $category_brand_store_page->id }}" type="hidden" />
                                        <div class="m-portlet__body">
                                            <div class="m-portlet__body">
                                                <div class="form-group m-form__group row">
                                                    <div class="col-lg-6">
                                                        <label>Category</label>
                                                        <select class="form-control m-input" name="category_id" required>

                                                            @foreach ($categories as $category)
                                                                <option @if ($category_brand_store_page->category_id == $category->id || old('category_id') == $category->id) selected @endif
                                                                    value="{{ $category->id }}">
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                        @error('category_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <label>Brands</label>
                                                        <select class="form-control m-input js-example-basic-multiple"
                                                            name="brands[]" multiple="multiple" required>
                                                            @if (count($selected_brands))
                                                                @foreach ($brands as $brand)
                                                                    <option
                                                                        @if (in_array($brand->id, $selected_brands)) selected @endif
                                                                        value="{{ $brand->id }}">
                                                                        {{ $brand->name }}
                                                                    </option>
                                                                @endforeach
                                                            @else
                                                                @foreach ($brands as $brand)
                                                                    <option value="{{ $brand->id }}">{{ $brand->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @if ($errors->has('brands.*'))
                                                            <span class="invalid-feedback"
                                                                role="alert"><strong>{{ $errors->first('brands.*') }}</strong></span>
                                                        @endif
                                                    </div>
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
@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endpush
