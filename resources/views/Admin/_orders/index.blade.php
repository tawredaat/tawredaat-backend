@extends('Admin.index')
@section('orders-active', 'm-menu__item--active m-menu__item--open')
@section('orders-view-active', 'm-menu__item--active')
@section('page-title', ' ' . $MainTitle . ' | ' . $SubTitle)
@section('content')
    <style type="text/css">
        .swal2-confirm {
            background: #3085d6 !important;
        }

        .swal2-cancel {
            background: #f12143 !important;
            color: #fff;
        }

        .swal2-popup {
            width: 50% !important;
            height: 40% !important;
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
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    {{ $SubTitle }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <section class="content">
                            <form method="GET" action="{{ route('orders.export') }}" id="filterDataForm">
                                <div
                                    style="display: flex;justify-content: flex-end;align-items:flex-end;margin-bottom: 20px">
                                    <div class="input-group" style="width: 50%">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="">From</span>
                                            <input type="date" name="start_date" id="startDateCol" class="form-control">
                                        </div>
                                        @if ($errors->has('start_date'))
                                            <span class="invalid-feedback" style="display:block;" role="alert">
                                                <strong>{{ $errors->first('start_date') }}</strong>
                                            </span>
                                        @endif
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="">To</span>
                                            <input type="date" name="end_date" id="endDateCol" class="form-control">
                                        </div>
                                        @if ($errors->has('end_date'))
                                            <span class="invalid-feedback" style="display:block;" role="alert">
                                                <strong>{{ $errors->first('end_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="input-group" style="width: 50%">
                                        <input type="text" name="value" id="searchField" class="form-control"
                                            aria-label="Text input with dropdown button">
                                        <div class="input-group-append">
                                            <select name="column" id="searchColumn" class="form-control"
                                                data-live-search="true" title="Please select a lunch ...">
                                                <option value="status">Staus</option>
                                                <option value="order_id">Order ID</option>
                                                <option value="user_id">User ID</option>
                                                <option value="user_name">User Name</option>
                                                <option value="user_email">User Email</option>
                                                <option value="user_phone">User Phone</option>
                                                <option value="subtotal">Subtotal</option>
                                                <option value="total">Total</option>
                                                <option value="discount">Discount</option>
                                                <option value="delivery_charge">Delivery Charge</option>
                                                {{-- <option value="promocode">Promocode</option> --}}
                                                <option value="payment_type">Payment Type</option>
                                                <option value="created_at">Created at</option>
                                            </select>
                                        </div>
                                        <div class="input-group-append">
                                            <button id="searchButton" class="btn btn-primary" type="button"
                                                title="search data">
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <button id="exportButton" class="btn btn-primary" type="submit"
                                                style="margin:0 5px" title="export data">
                                                <i class="fa fa-file"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div style="overflow-x:auto;">
                                <table class="table table-striped table-bordered table-hover table-checkable"
                                    id="orders-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Order ID</th>
                                            <th>User ID</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>User Phone</th>
                                            <th>Subtotal</th>
                                            <th>shipping Fees</th>
                                            <th>Total</th>
                                            <th>Discount</th>
                                            <th>Payment Type</th>
                                            <th>Created at</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="spinner">
                                        <tr>
                                            <td style="height: 100px;text-align: center;line-height: 100px;" colspan="18">
                                                <i class="fa fa-spinner fa-spin text-primary" style="font-size: 30px"
                                                    aria-hidden="true"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody id="orders-body">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <th>Status</th>
                                            <th>Order ID</th>
                                            <th>User ID</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>User Phone</th>
                                            <th>Subtotal</th>
                                            <th>shipping Fees</th>
                                            <th>Total</th>
                                            <th>Discount</th>
                                            <th>Payment Type</th>
                                            <th>Created at</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="paginationLinksContainer"
                                style="display: flex;justify-content: center;align-items: center;margin-top: 10px">
                            </div>
                        </section>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    @push('script')
        <script>
            function render(url) {
                $('#orders-body').css({
                    display: "none"
                });
                $('#spinner').css({
                    display: "table-row-group"
                });
                $.ajax({
                    url: url,
                    method: "get",
                    dataType: 'JSON',
                    success: function(data) {
                        $('#orders-body').css({
                            display: "table-row-group"
                        }).html(data.result);
                        $('#spinner').css({
                            display: "none"
                        });
                        $('#paginationLinksContainer').html(data.links)
                    },
                });
            }

            render("{{ route('orders.data.table') }}");

            $('#paginationLinksContainer').on('click', 'a.page-link', function(event) {
                event.stopPropagation();
                render($(this).attr('href'));
                return false;
            });

            $('#searchButton').on('click', function(event) {
                event.stopPropagation();
                render("{{ route('orders.data.table') }}?column=" + $('#searchColumn').val() + '&value=' + $(
                    '#searchField').val() + '&start_date=' + $('#startDateCol').val() + '&end_date=' + $(
                    '#endDateCol').val());
            });

            //reject order
            $("#orders-table").on('click', '.cancel-order', function() {
                Swal.fire({
                    title: 'Are you sure to cancel this order?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#000',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.value) {
                        var urls = $(this).data("route");
                        $.ajax({
                            url: urls,
                            method: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'JSON',
                            beforeSend: function() {},
                            success: function(data) {
                                if (data['success'] != null) {
                                    render("{{ route('orders.data.table') }}");
                                    Swal.fire('Cancelled!', data['success'], 'success');
                                } else if (data['validator'] != null)
                                    toastr.error(data['validator']);
                                else if (data['errors'] != null)
                                    toastr.error(data['errors']);
                            },
                            error: function(data) {
                                toastr.error('error occurred, Please try again later!');
                                render("{{ route('orders.data.table') }}");
                            }
                        });
                    }
                });
            });
        </script>
        <script>
            //change order status
            /* inputOptions can be an object or Promise */
            $("#orders-table").on('click', '.change-status-order', function() {
                start();
                var urls = $(this).data("route");
                async function start() {
                    const inputOptions = new Promise((resolve) => {
                        setTimeout(() => {
                            resolve(@json($orderStatuses))
                        }, 1000)
                    });
                    const {
                        value: status
                    } = await Swal.fire({
                        title: 'Please select order status',
                        input: 'radio',
                        inputOptions: inputOptions,
                        inputValidator: (value) => {
                            if (!value) {
                                return 'You need to choose status!'
                            }
                        }
                    })
                    if (status) {
                        $.ajax({
                            url: urls,
                            method: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                status: status
                            },
                            dataType: 'JSON',
                            beforeSend: function() {},
                            success: function(data) {
                                if (data['success'] != null) {
                                    Swal.fire('Changed!', data['success'], 'success');
                                    render("{{ route('orders.data.table') }}");
                                } else if (data['validator'] != null)
                                    toastr.error(data['validator']);
                                else if (data['errors'] != null)
                                    toastr.error(data['errors']);
                            },
                            error: function(data) {
                                toastr.error('error occurred, Please try again later!');
                                render("{{ route('orders.data.table') }}");
                            }
                        });
                    }
                }
            });
        </script>
    @endpush
@endsection
<!-- end:: Body -->
