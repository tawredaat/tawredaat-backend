@extends('Admin.index')
@section('orders-active', 'm-menu__item--active m-menu__item--open')
@section('orders-cancelled-view-active', 'm-menu__item--active')
@section('page-title', ' '.$MainTitle.' | '.$SubTitle)
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
                    <div class="mr-auto">
                        <h3 class="m-subheader__title ">
                            {{$MainTitle}}
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
                                    {{$SubTitle}}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <section class="content">
                            <div style="display: flex;justify-content: flex-end;align-items:flex-end;margin-bottom: 20px">
                                <div class="input-group" style="width: 500px">
                                    <input type="text" id="searchField" class="form-control"
                                            aria-label="Text input with dropdown button">
                                    <div class="input-group-append">
                                        <select id="searchColumn" class=" form-control" data-live-search="true"
                                                title="Please select a lunch ...">
                                            <option value="cancelled_by">Cancelled By</option>
                                            <option value="cancelled_at">Cancelled at</option>
                                            <option value="order_id">Order ID</option>
                                            <option value="user_id">User ID</option>
                                            <option value="user_name">User Name</option>
                                            <option value="user_email">User Email</option>
                                            <option value="user_phone">User Phone</option>
                                            <option value="subtotal">Subtotal</option>
                                            <option value="total">Total</option>
                                            <option value="discount">Discount</option>
                                            {{-- <option value="promocode">Promocode</option> --}}
                                            <option value="payment_type">Payment Type</option>
                                            <option value="created_at">Created at</option>
                                        </select>
                                    </div>
                                    <div class="input-group-append">
                                        <button id="searchButton" class="btn btn-primary" type="button"><i
                                                class="fa fa-search"></i>
                                        </button>

                                    </div>
                                </div>
                            </div>
                            <div style="overflow-x:auto;">
                                <table class="table table-striped table-bordered table-hover table-checkable"
                                        id="orders-table" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Cancelled By</th>
                                        <th>Cancelled at</th>
                                        <th>Order ID</th>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>User Phone</th>
                                        <th>Subtotal</th>
                                        <th>Total</th>
                                        <th>Discount</th>
                                        <th>Payment Type</th>
                                        <th>Created at</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="spinner">
                                    <tr>
                                        <td style="height: 100px;text-align: center;line-height: 100px;"
                                            colspan="18">
                                            <i class="fa fa-spinner fa-spin text-primary" style="font-size: 30px"
                                                aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody id="orders-body">
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Cancelled By</th>
                                        <th>Cancelled at</th>
                                        <th>Order ID</th>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>User Phone</th>
                                        <th>Subtotal</th>
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
                $('#orders-body').css({display: "none"});
                $('#spinner').css({display: "table-row-group"});
                $.ajax({
                    url: url,
                    method: "get",
                    dataType: 'JSON',
                    success: function (data) {
                        $('#orders-body').css({display: "table-row-group"}).html(data.result);
                        $('#spinner').css({display: "none"});
                        $('#paginationLinksContainer').html(data.links)
                    },
                });
            }

            render("{{route('orders.cancelled.data.table')}}");

            $('#paginationLinksContainer').on('click', 'a.page-link', function (event) {
                event.stopPropagation();
                render($(this).attr('href'));
                return false;
            });

            $('#searchButton').on('click', function (event) {
                event.stopPropagation();
                render("{{route('orders.cancelled.data.table')}}?column=" + $('#searchColumn').val() + '&value=' + $('#searchField').val());
            });

        </script>

    @endpush
@endsection
<!-- end:: Body -->
