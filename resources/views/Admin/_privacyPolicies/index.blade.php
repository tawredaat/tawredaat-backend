@extends('Admin.index')
@section('pages-active', 'm-menu__item--active m-menu__item--open')
@section('privacy-policy-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', ' Privacy & Policy')
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
                                    <form method="POST" action="{{ route('privacy.policy.save') }}"
                                        class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label> Privacy & Policy in english</label>
                                                    <textarea class="form-control m-input" required name="content_en" id="descri_en">{!! old('content_en') ? old('content_en') : ($privacy ? $privacy->translate('en')->content : '') !!}</textarea>
                                                    @error('content_en')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Privacy & Policy in arabic</label>
                                                    <textarea required class="form-control m-input" name="content_ar" id="descri_ar">{!! old('content_ar') ? old('content_ar') : ($privacy ? $privacy->translate('ar')->content : '') !!}</textarea>
                                                    @error('content_ar')
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
            });
        </script>
    @endpush
@endsection
<!-- end:: Body -->
