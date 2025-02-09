@extends('Admin.index')
@section('shop-products-active', 'm-menu__item--active m-menu__item--open')
@section('shop-products-mass-active', 'm-menu__item--active')
@section('page-title', 'Shop | Products | Import excel file')
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

    #CustomerTable_wrapper {
        overflow-x: scroll;
    }

    .col-md-3,
    .col-md-2 {
        height: 100px;
    }
</style>
@section('content')
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
                                      <div class="m-portlet__head-tools ml-auto">
                                        <a class="btn btn-danger" href="{{ asset('storage/massUploadSheets/Shop Product Mass Upload.xlsx') }}" download="product_mass_upload.xlsx">
                                            Download Template
                                        </a>
                                    </div>
                                    </div>
                                    <!--begin::Form-->
                                    <form method="post" enctype="multipart/form-data"
                                        class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                                        action="{{ route('shop.products.import') }}">
                                        @csrf
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12">
                                                    {{-- <label>Excel sheet must be in xls,xlsx,xlm,xla,xlc,xlt,xlw </label> --}}
                                                    <input type="file" name="file" required="" accept=".csv"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                                            <div class="m-form__actions m-form__actions--solid">
                                                <div class="row">
                                                    <div class="col-lg-6 m--align-left">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <br>
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
