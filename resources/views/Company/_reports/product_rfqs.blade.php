@extends('Company.index')
@section('reports-active', 'm-menu__item--active m-menu__item--open')
@section('reports-product-rfq-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Reports|Products RFQs')
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
                                    View all Product RFQs
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div
                            style="display: flex;justify-content: flex-end;align-items:flex-end;margin-bottom: 20px">
                            <form method="get" action="{{request()->url()}}" class="col-6">
                                <div class="form-group m-form__group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="">From</span>
                                        </div>
                                        <input type="date" name="start_date"
                                               value="{{request()->input('start_date')}}" class="form-control"
                                        >
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="">To</span>
                                        </div>
                                        <input type="date" name="end_date" value="{{request()->input('end_date')}}"
                                               class="form-control"

                                        >
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i
                                                    class="fa fa-filter">
                                                </i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable"
                               id="product_rfqs_datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User name</th>
                                <th>User phone</th>
                                <th>User Email</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>View</th>
                            </tr>
                            </thead>
                            <tbody id="categories_info">
                            @if(count($productRfqs) > 0)
                                @foreach ($productRfqs as $productRfq)
                                    <tr>
                                        <td>{{ ($loop->index + 1) }}</td>
                                        <td>{{ $productRfq->user?$productRfq->user->name:'Anonymous'}}</td>
                                        <td>{{ $productRfq->user?$productRfq->user->phone:'Anonymous'}}</td>
                                        <td>{{ $productRfq->user?$productRfq->user->email:'Anonymous' }}</td>
                                        <td>{{ $productRfq->created_at->format('d-M-Y') }}</td>
                                        <td>{{ date('h:i A', strtotime($productRfq->created_at)) }}</td>
                                        <td>
                                            <a href="{{route('company.product.rfq.details', $productRfq->id)}}"
                                               class="btn btn-sm btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="7" class="text-center">There are no requests.</td>
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
@section('script')
    <script type="text/javascript">
        $('#product_rfqs_datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    filename: 'Products RFQs',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }
            ]
        });
    </script>
@endsection
@endsection
<!-- end:: Body -->

