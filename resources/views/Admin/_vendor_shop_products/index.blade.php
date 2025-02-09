@extends('Admin.index')
@section('shop-products-active', 'm-menu__item--active m-menu__item--open')
@section('shop-products-view-active', 'm-menu__item--active')
@section('page-title', 'Shop | Products | View')
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
                            {{ $main_title }}
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
                                    {{ $sub_title }}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">

                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <section class="content">
                            <div style="display: flex;justify-content: flex-end;align-items:flex-end;margin-bottom: 20px">
                                <form method="get" action="{{ request()->url() }}" class="col-6">
                                    <div class="form-group m-form__group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="">From</span>
                                            </div>
                                            <input type="date" name="start_date"
                                                value="{{ request()->input('start_date') }}" class="form-control">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="">To</span>
                                            </div>
                                            <input type="date" name="end_date" value="{{ request()->input('end_date') }}"
                                                class="form-control">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-filter">
                                                    </i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                                <div class="form-group m-form__group col-6">
                                    <div class="input-group" style="width: 450px">
                                        @if ($shop_count >= 500)
                                            <label style="padding: 10px;">View 500 Product :</label>
                                        @endif
                                        <input type="checkbox" id="pagination" class="form-control"
                                            aria-label="Text input with dropdown button">

                                        <input type="text" id="searchField" class="form-control"
                                            aria-label="Text input with dropdown button">


                                        <div class="input-group-append">
                                            <select id="searchColumn" class=" form-control" data-live-search="true"
                                                title="Please select a lunch ...">
                                                <option value="name">Product Name</option>
                                                <option value="brand">Brand</option>
                                                <option value="category">Category</option>
                                                <option value="category">Is approved?</option>
                                            </select>
                                        </div>
                                        <div class="input-group-append">
                                            <button id="searchButton" class="btn btn-primary" type="button">
                                                <i class="fa fa-search">
                                                </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="overflow-x:auto;">
                                <table class="table table-striped- table-bordered table-hover table-checkable"
                                    id="products-table">
                                    {{-- <input type="hidden" id="vendor_id" name="vendor_id" value="{{ $vendor_id }}" /> --}}
                                    <thead>
                                        <tr>
                                            {{-- <a style="color:yellow;" class="btn btn-success approve" title="approve product"
                                                data-content="1" id="approve-product-1"><i class="fa fa-check"></i></a> --}}

                                            <th></th>
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>Is Approved?</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="spinner">
                                        <tr>
                                            <td style="height: 100px;text-align: center;line-height: 100px;" colspan="18">
                                                <i class="fa fa-spinner fa-spin text-primary" style="font-size: 30px"
                                                    aria-hidden="true">
                                                </i>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody id="products-body">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>Is Approved?</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @if ($shop_count)
                                <div style="display: flex;justify-content: flex-start;align-items:flex-start;">
                                    <form method="post" id="approveForm"
                                        action="{{ route('vendor-shop-products.approve-selected') }}"
                                        style="margin-right: 3px">
                                        @csrf
                                        <input type="hidden" id="vendor_id" name="vendor_id" value="{{ $vendor_id }}" />

                                        <div class="form-group m-form__group">

                                            <button class="btn btn-success" type="submit">
                                                Approve/Disapprove Selected <span id="approveCount">0</span> Product
                                            </button>
                                        </div>
                                    </form>
                                    <form method="post" id="approveAll"
                                        action="{{ route('vendor-shop-products.approve-all') }}">
                                        @csrf
                                        <input type="hidden" id="vendor_id" name="vendor_id" value="{{ $vendor_id }}" />

                                        <div class="form-group m-form__group">

                                            <button class="btn btn-success" onclick="return approveAllSure(event)"
                                                type="submit">
                                                Approve/Disapprove All Product
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
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
        <script type="text/javascript">
            // approve product data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            function render(url) {
                $('#approveCount').text(0);
                $('#products-body').css({
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
                        $('#products-body').css({
                            display: "table-row-group"
                        }).html(data.result);
                        $('#spinner').css({
                            display: "none"
                        });
                        $('#paginationLinksContainer').html(data.links)
                    },
                });
            }

            render("{!! route('vendor-shop-products.data', [
                'l3' => request()->input('l3'),
                'start_date' => request()->input('start_date'),
                'end_date' => request()->input('end_date'),
                'vendor_id' => $vendor_id,
            ]) !!}");

            $('#paginationLinksContainer').on('click', 'a.page-link', function(event) {
                event.stopPropagation();
                render($(this).attr('href'));
                return false;
            });

            $('table').on('change', 'input[name="products[]"]', function() {
                $('#approveCount').text($('input[name="products[]"]:checked').length);
            });

            $('#searchButton').on('click', function(event) {
                event.stopPropagation();
                render("{{ route('vendor-shop-products.data') }}?column=" +
                    $('#searchColumn').val() + '&value=' + $('#searchField').val() +
                    '&pagination=' + $('#pagination').is(':checked') +
                    "&l3={{ request()->input('l3') }}&start_date={{ request()->input('start_date') }}&end_date={{ request()->input('end_date') }}&vendor_id={{ request()->input('vendor_id') }}"
                );
            });


            $("#products-table").on('click', '.approve', function() {
                var content = $(this).data("content");

                var urls = "{{ route('vendor-shop-products.approve', 'id') }}";
                urls = urls.replace('id', content);
                $.ajax({
                    url: urls,
                    method: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        id: content,
                        vendor_id: $("#vendor_id").val(),
                    },
                    dataType: 'JSON',

                    success: function(data) {
                        var aTag = "#approve-product-ID";

                        aTag = aTag.replace('ID', data['id']);

                        if (data['is_approved'] == 1) {
                            $(aTag).attr('title', 'Disapprove this product?');

                            $("i", aTag).toggleClass("fa fa-check fa fa-times");

                            $(aTag).toggleClass("btn-danger btn-success");

                        } else if (data['is_approved'] == 0) {
                            $(aTag).attr('title', 'Approve this product?');
                            // btn-danger btn-success

                            $(aTag).toggleClass("btn-danger btn-success");

                            $("i", aTag).toggleClass("fa fa-check fa fa-times");
                        }

                        var msg = data['success'];

                        toastr.success(msg);
                    },
                    error: function(data) {
                        Swal.fire(
                            'failed!',
                            "error occured, try again later !.",
                            'error'
                        );
                    }
                });
            });
        </script>
    @endpush
@endsection
<!-- end:: Body -->
