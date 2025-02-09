@extends('Admin.index')
@section('settings-section-active', 'm-menu__item--active m-menu__item--open')
@section('settings-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Website|Settings|Create')
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
                                    <form method="POST" action="{{ route('site.settings.store') }}"
                                        class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Free shipping amount</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="free_shipping_amount"
                                                            value="{{ old('free_shipping_amount') }}" required
                                                            type="number" step="any" class="form-control m-input"
                                                            placeholder="Enter free_shipping_amount...">
                                                    </div>
                                                    @error('free_shipping_amount')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>


                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4">
                                                    <label>Email</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="email" value="{{ old('email') }}" required
                                                            type="text" class="form-control m-input"
                                                            placeholder="Enter email...">
                                                    </div>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Logo alt in english</label>
                                                    <input type="text" value="{{ old('alt_en') }}" name="alt_en"
                                                        class="form-control m-input" placeholder="alt logo in english...">
                                                    @error('alt_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Logo alt in arabic</label>
                                                    <input type="text" value="{{ old('alt_ar') }}" name="alt_ar"
                                                        placeholder="alt logo in arabic..." class="form-control m-input">
                                                    @error('alt_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>English logo</label>
                                                    <input type="file" name="logo_en" required
                                                        class="form-control m-input">
                                                    @error('logo_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Arabic logo</label>
                                                    <input type="file" name="logo_ar" required
                                                        class="form-control m-input">
                                                    @error('logo_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>






                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>English FRQ Image</label>
                                                    <input type="file" name="rfq_image_en" required
                                                        class="form-control m-input">
                                                    @error('rfq_image_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Arabic FRQ Image</label>
                                                    <input type="file" name="rfq_image_ar" required
                                                        class="form-control m-input">
                                                    @error('rfq_image_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>



                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Home Title in english</label>
                                                    <input type="text" value="{{ old('title_en') }}" name="title_en"
                                                        class="form-control m-input" placeholder="Home Title in english...">
                                                    @error('title_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Home title in arabic</label>
                                                    <input type="text" value="{{ old('title_ar') }}" name="title_ar"
                                                        placeholder="Home title in arabic..."
                                                        class="form-control m-input">
                                                    @error('title_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Home Keywords in english</label>
                                                    <input type="text" id="keywords_en"
                                                        value="{{ old('keywords_en') }}" name="keywords_en"
                                                        class="form-control m-input"
                                                        placeholder="Home Keywords in english...">
                                                    @error('keywords_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Home Keywords in arabic</label>
                                                    <input type="text" id="keywords_ar"
                                                        value="{{ old('keywords_ar') }}" name="keywords_ar"
                                                        placeholder="Home Keywords in arabic..."
                                                        class="form-control m-input">
                                                    @error('keywords_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Home Meta Description in english</label>
                                                    <textarea class="form-control m-input" required name="Meta_Description_en">{{ old('Meta_Description_en') }}</textarea>
                                                    @error('Meta_Description_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Home Meta Description in arabic</label>
                                                    <textarea required class="form-control m-input" name="Meta_Description_ar">{{ old('Meta_Description_ar') }}</textarea>
                                                    @error('Meta_Description_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-3">
                                                    <label>English Site logo</label>
                                                    <input type="file" name="site_logo_en" required
                                                        class="form-control m-input">
                                                    @error('site_logo_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Arabic Site logo</label>
                                                    <input type="file" name="site_logo_ar"
                                                        class="form-control m-input">
                                                    @error('site_logo_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Site Logo alt in english</label>
                                                    <input type="text" value="{{ old('siteLogoAlt_en') }}"
                                                        name="siteLogoAlt_en" class="form-control m-input"
                                                        placeholder="Site alt logo in english...">
                                                    @error('siteLogoAlt_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Site Logo alt in arabic</label>
                                                    <input type="text" value="{{ old('siteLogoAlt_ar') }}"
                                                        name="siteLogoAlt_ar" placeholder="Site alt logo in arabic..."
                                                        class="form-control m-input">
                                                    @error('siteLogoAlt_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-3">
                                                    <label>English Footer logo</label>
                                                    <input type="file" name="footer_logo_en" required
                                                        class="form-control m-input">
                                                    @error('footer_logo_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Arabic Footer logo</label>
                                                    <input type="file" name="footer_logo_ar"
                                                        class="form-control m-input">
                                                    @error('footer_logo_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Site Logo alt in english</label>
                                                    <input type="text" value="{{ old('footerLogoAlt_en') }}"
                                                        name="footerLogoAlt_en" class="form-control m-input"
                                                        placeholder="Footer alt logo in english...">
                                                    @error('footerLogoAlt_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Footer Logo alt in arabic</label>
                                                    <input type="text" value="{{ old('footerLogoAlt_ar') }}"
                                                        name="footerLogoAlt_ar" placeholder="Footer alt logo in arabic..."
                                                        class="form-control m-input">
                                                    @error('footerLogoAlt_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Phone</label>
                                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                                        required class="form-control m-input"
                                                        placeholder="Enter Phone...">
                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>fax</label>
                                                    <input type="text" name="fax" value="{{ old('fax') }}"
                                                        class="form-control m-input" placeholder="Enter Fax...">
                                                    @error('fax')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Facebook</label>
                                                    <input type="text" name="facebook" value="{{ old('facebook') }}"
                                                        class="form-control m-input" placeholder="Enter facebook link...">
                                                    @error('facebook')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>insta</label>
                                                    <input type="text" name="insta" value="{{ old('insta') }}"
                                                        class="form-control m-input"
                                                        placeholder="Enter instagram link...">
                                                    @error('insta')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>youtube</label>
                                                    <input type="text" name="youtube" value="{{ old('youtube') }}"
                                                        class="form-control m-input" placeholder="Enter youtube link...">
                                                    @error('youtube')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>linkedin</label>
                                                    <input type="text" name="linkedin" value="{{ old('linkedin') }}"
                                                        class="form-control m-input" placeholder="Enter linkedin link...">
                                                    @error('linkedin')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>twitter</label>
                                                    <input type="text" name="twitter" value="{{ old('twitter') }}"
                                                        class="form-control m-input" placeholder="Enter twitter link...">
                                                    @error('twitter')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Address in english</label>
                                                    <input type="text" name="address_en"
                                                        value="{{ old('address_en') }}" required
                                                        class="form-control m-input"
                                                        placeholder="Enter address in english...">
                                                    @error('address_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Address in arabic</label>
                                                    <input type="text" name="address_ar"
                                                        value="{{ old('address_ar') }}" required
                                                        class="form-control m-input"
                                                        placeholder="Enter address in arabic...">
                                                    @error('address_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Footer Description in english</label>
                                                    <textarea id="descri_en" required name="description_en">{{ old('description_en') }}</textarea>
                                                    @error('description_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Footer Description in arabic</label>
                                                    <textarea id="descri_ar" required name="description_ar">{{ old('description_ar') }}</textarea>
                                                    @error('description_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row" style="">
                                                <div class="col-lg-6">
                                                    <label>Brand store banner</label>
                                                    <input type="file" name="brand_store_banner"
                                                        class="form-control m-input">
                                                    <br>
                                                    @error('brand_store_banner')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Home RFQ Banner in english</label>
                                                    <input type="file" name="rfq_banner_en"
                                                        class="form-control m-input">
                                                    @error('rfq_banner_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Home RFQ Banner in arabic</label>
                                                    <input type="file" name="rfq_banner_ar"
                                                        class="form-control m-input">
                                                    @error('rfq_banner_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12">
                                                    <label>Favicon</label>
                                                    <input type="file" name="favicon" class="form-control m-input">
                                                    @error('favicon')
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
                $('#descri_ar').summernote({
                    tabsize: 2,
                    height: 150
                });
                $('#descri_en').summernote({
                    tabsize: 2,
                    height: 150
                });
                $('#keywords_ar,#keywords_en').tagsinput({
                    confirmKeys: [13, 188]
                });

                $('.bootstrap-tagsinput').on('keypress', function(e) {
                    if (e.keyCode == 13) {
                        e.keyCode = 188;
                        e.preventDefault();
                    };
                });
            });
        </script>
    @endpush
@endsection
<!-- end:: Body -->
