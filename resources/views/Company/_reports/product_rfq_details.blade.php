@extends('Company.index')
@section('reports-active', 'm-menu__item--active m-menu__item--open')
@section('reports-product-rfq-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Reports|Products RFQs|Details')
@section('content')
    <style type="text/css">
        .swal2-confirm {
            background: #3085d6 !important;
        }

        .swal2-cancel {
            background: #f12143 !important;
            color: #fff;
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
                </div>
            </div>
            <!-- END: Subheader -->
            <div class="m-content">
                <div style="display: none;"
                     class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30"
                     role="alert">
                    <div class="m-alert__icon">
                        <i class="flaticon-exclamation m--font-brand"></i>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Request Product(s)
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable"
                               id="general_rfq_datatable">
                            <thead>
                            <tr>
                                <th>Product name</th>
                                <th>Product Category</th>
                                <th>Product Brand</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                            </thead>
                            <tbody id="company_product_info">
                            @if($companyProduct)
                                <tr>
                                    <td>{{ $companyProduct->product->name}}</td>
                                    <td>{{ $companyProduct->product->category->name}} </td>
                                    <td>{{ $companyProduct->brand->name}}</td>
                                    <td>{{ $companyProduct->created_at }}</td>
                                    <td>{{ $companyProduct->created_at->format('d-M-Y') }}</td>
                                    <td>{{ date('h:i A', strtotime($companyProduct->created_at)) }}</td>
                                </tr>
                            @else
                                <td colspan="7" class="text-center">There are no products in this request.</td>
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
            <div class="m-content">
                <div style="display: none;"
                     class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30"
                     role="alert">
                    <div class="m-alert__icon">
                        <i class="flaticon-exclamation m--font-brand"></i>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Request Message
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <p>{{$productRfqMessage}}</p>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
@section('script')
    <script type="text/javascript">
        $('#general_rfq_datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    filename: 'Request Product(s)',
                }
            ]
        });
    </script>
@endsection
@endsection
<!-- end:: Body -->


