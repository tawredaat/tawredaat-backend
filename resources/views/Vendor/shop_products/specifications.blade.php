@extends('Vendor.index')
@section('shop-products-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Shop | Products | specifications')
@section('content')
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
                                {{ $main_title }}
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
                                                    {{ $sub_title }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Form-->
                                    <div class="m-portlet__body">
                                        <div class="table-resposive">
                                            <table class="table table-striped- table-bordered table-hover table-checkable"
                                                id="ProductsImages">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Specification in Arabic</th>
                                                        <th>Values in Arabic</th>
                                                        <th>Specification in English</th>
                                                        <th>Values in English</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($product->specifications))
                                                        @foreach ($product->specifications as $specification)
                                                            <tr>
                                                                <td>{{ $loop->index + 1 }}</td>
                                                                <td>{{ $specification->specification ? $specification->specification->translate('ar')->name : '--' }}
                                                                </td>
                                                                <td>
                                                                    @if ($specification->translation)
                                                                        {{ $specification->translate('ar')->value }}
                                                                    @else
                                                                        {{ $specification->value }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ $specification->specification ? $specification->specification->translate('en')->name : '--' }}
                                                                </td>
                                                                <td>
                                                                    @if ($specification->translation)
                                                                        {{ $specification->translate('en')->value }}
                                                                    @else
                                                                        {{ $specification->value }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <td colspan="3" style="text-align:center;"> This product has no
                                                            specifications</td>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
    @endpush
@endsection
<!-- end:: Body -->
