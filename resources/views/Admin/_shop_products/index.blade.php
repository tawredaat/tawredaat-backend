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
                            {{ $MainTitle }}
                        </h3>
                        <a href="{{ route('exportAllProducts', ['type' => 'xlsl']) }}" class="btn btn-success ms-auto">
                                  Export All Products As Excel Sheet
                        </a>
                    </div>
                </div>
            </div>
            <!-- END: Subheader -->
            <div class="m-content">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption d-flex align-items-center">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    {{ $SubTitle }}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            {{-- <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{route('company.products.create')}}"
                                       class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                  <span>
                    <i class="la la-plus">
                    </i>
                    <span>Assign products
                    </span>
                  </span>
                                    </a>
                                </li>
                            </ul> --}}
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <section class="content">
                            <div style="display: flex;justify-content: flex-end;align-items:flex-end;margin-bottom: 20px">
                                <form id="filter-form" method="get" action="{{ request()->url() }}" class="col-6">
                                    <div class="form-group m-form__group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="">From</span>
                                            </div>
                                            <input type="date" name="start_date" id="start_date"
                                                value="{{ request()->input('start_date') }}" class="form-control">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="">To</span>
                                            </div>
                                            <input type="date" name="end_date" id="end_date"
                                                value="{{ request()->input('end_date') }}" class="form-control">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" id="filter-btn" type="submit">
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
                                        <input type="checkbox" class="form-control"
                                            aria-label="Text input with dropdown button">

                                        <input type="text" id="searchField" class="form-control"
                                            aria-label="Text input with dropdown button">


                                        <div class="input-group-append">
                                            <select id="searchColumn" class=" form-control" data-live-search="true"
                                                title="Please select a lunch ...">
                                                <option value="name">Product Name</option>
                                                <option value="brand">Brand</option>
                                                <option value="category">Category</option>
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
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" class="form-control select-all"
                                                    aria-label="Text input with dropdown button">
                                            </th>
                                          
                                            <th>Id</th>
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Brand</th>
                                            <th>Category</th>
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
                                            <th>
                                                <input type="checkbox" class="form-control select-all"
                                                    aria-label="Text input with dropdown button">
                                            </th>
                                           
                                            <th>Id</th>
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @if ($shop_count)
                                <div style="display: flex;justify-content: flex-start;align-items:flex-start;">
                                    <div class="form-group m-form__group" style="margin-right: 3px">
                                        <button class="btn btn-info hideSelectedButton" type="button">
                                            Hide Selected <span id="hideCount">0</span> Product
                                        </button>
                                    </div>

                                    <div class="form-group m-form__group" style="margin-right: 3px">
                                        <button class="btn btn-success showSelectedButton" type="button">
                                            Show Selected <span id="showCount">0</span> Product
                                        </button>
                                    </div>
                                    <form method="post" id="deleteForm"
                                        action="{{ route('shop.products.delete.selected') }}" style="margin-right: 3px">
                                        @csrf
                                        <div class="form-group m-form__group">
                                            <button class="btn btn-danger" type="submit">
                                                Delete Selected <span id="deleteCount">0</span> Product
                                            </button>
                                        </div>
                                    </form>

                                    <?php
                                    $display = 'none';
                                    if (isset($_GET['start_date'])) {
                                        $display = 'visible';
                                    }
                                    ?>

                                    <form method="post" id="deleteFilteredForm" {{-- action="{{ route('shop.products.delete.selected') }}" --}}
                                        style="margin-right: 3px;display:{{ $display }}">
                                        @csrf
                                        <div class="form-group m-form__group">
                                            <button class="btn btn-danger" id="deleteFilteredBtn" type="button">
                                                Delete Filtered Products
                                            </button>
                                        </div>
                                    </form>

                                    <form method="post" id="deleteAll" action="{{ route('shop.products.delete.all') }}">
                                        @csrf
                                        <div class="form-group m-form__group">

                                            <button class="btn btn-danger" route={{ route('admin.valid-super-password') }}
                                                onclick="return deleteAllSure(event)" type="submit">
                                                Delete All Product
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            <div id="paginationLinksContainer"
                                style="display: flex;justify-content: center;align-items: center;margin-top: 10px">
                                {{--                                    {{$products->links()}} --}}
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
            //Delete product data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#products-table").on('click', '.delete', function() {
                Swal.fire({
                    title: 'Are you sure to delete this product?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");
                        var urls = "{{ route('shop.products.destroy', 'id') }}";
                        urls = urls.replace('id', content);
                        $.ajax({
                            url: urls,
                            method: 'POST',
                            data: {
                                _token: CSRF_TOKEN,
                                id: content,
                                _method: "delete"
                            },
                            dataType: 'JSON',
                            beforeSend: function() {},
                            success: function(data) {
                                $('#tr-' + data['id']).remove();
                                Swal.fire(
                                    'Deleted!',
                                    'product data has been deleted !',
                                    'success'
                                )
                            },
                            error: function(data) {
                                // $("#products").DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });

            $("#products-table").on('click', '.featured', function() {
                var content = $(this).data("content");
                var urls = "{{ route('shop.products.featured', 'id') }}";
                urls = urls.replace('id', content);
                $.ajax({
                    url: urls,
                    method: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        id: content
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        var aTag = "#shop-product-ID";
                        aTag = aTag.replace('ID', data['id']);
                        if (data['featured'] == 1) {
                            $(aTag).css('color', 'red');
                            $(aTag).attr('title', 'Remove this product from featured in home page');
                        } else if (data['featured'] == 0) {
                            $(aTag).css('color', '#fff');
                            $(aTag).attr('title', 'Make this product featured in home page');
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

            $("#products-table").on('click', '.toggleShow', function() {
                var content = $(this).data("content");
                var urls = "{{ route('shop.products.show', 'id') }}";
                urls = urls.replace('id', content);
                $.ajax({
                    url: urls,
                    method: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        id: content
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        var aTag = "#shop-product-ID";
                        aTag = aTag.replace('ID', data['id']);

                        var iTag = "#i-shop-product-ID";
                        iTag = iTag.replace('ID', data['id']);

                        if (data['show'] == 1) {
                            $(iTag).attr('class','fa fa-eye');
                            $(aTag).attr('title', 'Hide this product from website');
                        } else if (data['show'] == 0) {
                            $(iTag).attr('class', 'fa fa-eye-slash');
                            $(aTag).attr('title', 'Show this product in website');
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

            function render(url) {
                $('#deleteCount').text(0);
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

            render("{!! route('shop.products.new.index', [
                'l3' => request()->input('l3'),
                'start_date' => request()->input('start_date'),
                'end_date' => request()->input('end_date'),
            ]) !!}");

            //hide selected
            $(document).ready(function () {
                $('.select-all').click(function () {

                    var checkedProductsCount = $('input[name="products[]"]:checked').length;
                    // Update the count
                    $('#hideCount').text(checkedProductsCount);
                });
                
                $('.hideSelectedButton').click(function () {
                    var checkedProductIds = [];

                    $('input[name="products[]"]:checked').each(function () {
                        var productId = $(this).val();
                        checkedProductIds.push(productId);
                    });

                    console.log('Checked Product IDs:', checkedProductIds);

                    $('#hideCount').text(0);
                    $('#products-body').css({ display: "none" });
                    $('#spinner').css({ display: "table-row-group" });

                    $.ajax({
                        url: "{{ route('hideSelected') }}",
                        method: "GET",
                        data: {
                            id: checkedProductIds
                        },
                        headers: {
                            token: "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            $('#products-body').css({ display: "table-row-group" }).html(data.result);
                            $('#spinner').css({ display: "none" });
                            $('#paginationLinksContainer').html(data.links);

                            // Uncheck the checkboxes after successful hide action
                            $('input[name="products[]"]:checked').prop('checked', false);
                            location.reload();
                        }
                    });
                });
            });
            //end hide selected
//show selected
            $(document).ready(function () {

                $('.select-all').click(function () {

                    var checkedProductsCount = $('input[name="products[]"]:checked').length;
                    // Update the count
                    $('#showCount').text(checkedProductsCount);
                });
                $('.showSelectedButton').click(function () {
                    var checkedProductIds = [];

                    $('input[name="products[]"]:checked').each(function () {
                        var productId = $(this).val();
                        checkedProductIds.push(productId);
                    });

                    console.log('Checked Product IDs:', checkedProductIds);

                    $('#showCount').text(0);
                    $('#products-body').css({ display: "none" });
                    $('#spinner').css({ display: "table-row-group" });

                    $.ajax({
                        url: "{{ route('showSelected') }}",
                        method: "GET",
                        data: {
                            id: checkedProductIds
                        },
                        headers: {
                            token: "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            $('#products-body').css({ display: "table-row-group" }).html(data.result);
                            $('#spinner').css({ display: "none" });
                            $('#paginationLinksContainer').html(data.links);

                            // Uncheck the checkboxes after successful show action
                            $('input[name="products[]"]:checked').prop('checked', false);
                            location.reload();
                        }

                    });
                });
            });
            //end show selected
            $('#paginationLinksContainer').on('click', 'a.page-link', function(event) {
                event.stopPropagation();
                render($(this).attr('href'));
                return false;
            });

            // here
            $('#searchButton').on('click', function(event) {
                event.stopPropagation();
                render("{{ route('shop.products.new.index') }}?column=" +
                    $('#searchColumn').val() + '&value=' + $('#searchField').val() +
                    '&pagination=' + $('#pagination').is(':checked') +
                    "&l3={{ request()->input('l3') }}&start_date=" +
                    $('#start_date').val() + "&end_date=" + $('#end_date').val());

                $('#deleteFilteredForm').show();
            });

            $('table').on('change', 'input[name="products[]"]', function() {
                $('#deleteCount').text($('input[name="products[]"]:checked').length);
            });
            $('table').on('change', 'input[name="products[]"]', function() {
                $('#hideCount').text($('input[name="products[]"]:checked').length);
            });
            $('table').on('change', 'input[name="products[]"]', function() {
                $('#showCount').text($('input[name="products[]"]:checked').length);
            });


            $('#deleteFilteredBtn').on('click', function() {
                var url = "{{ route('shop.products.delete.filtered') }}";
                console.log('url=' + url);
                $.ajax({
                    url: url,
                    method: 'post',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        column: $('#searchColumn').val(),
                        value: $('#searchField').val(),
                        // l3: {{ request()->input('l3') }},
                        start_date: $('#start_date').val(),
                        end_date: $('#end_date').val(),
                    },
                    dataType: 'JSON',
                    beforeSend: function() {},
                    success: function(found) {
                        Swal.fire(
                            'Deleted!',
                            'All filtered products have been deleted!',
                            'success'
                        );

                        render("{!! route('shop.products.new.index', [
                            'l3' => request()->input('l3'),
                            'start_date' => request()->input('start_date'),
                            'end_date' => request()->input('end_date'),
                        ]) !!}");
                        // $("#products").DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        // Request failed
                        Swal.fire(
                            'Error!',
                            'error'
                        );
                    }
                });
            });


            async function deleteAllSure(e) {
                e.preventDefault();
                return Swal.fire({
                    title: 'Are you sure to delete all product?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete'
                }).then(async (result) => {
                    // get password
                    const {
                        value: password
                    } = await Swal.fire({
                        title: 'Are you sure to delete all shop products?',
                        text: "You won't be able to revert this! ",
                        input: 'password',
                        inputLabel: 'Enter super admin password',
                        inputPlaceholder: 'Enter super admin\'s password',
                        showCancelButton: true,
                        confirmButtonColor: '#000',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete them!'
                    });

                    // check if the password if a super admin password
                    if (password) {
                        var url = "{{ route('admin.valid-super-password') }}";
                        $.ajax({
                            url: url,
                            method: 'post',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                password: `${password}`
                            },
                            dataType: 'JSON',
                            beforeSend: function() {},
                            success: function(found) {
                                Swal.fire(
                                    'Deleted!',
                                    'All products have been deleted!',
                                    'success'
                                );
                                // deleting all sumbit
                                if (result.value) {
                                    $('#deleteAll').submit();
                                }
                                $("#products").DataTable().ajax.reload();
                            },
                            error: function(data) {
                                Swal.fire(
                                    'Error!',
                                    'Invalid password',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        </script>

        <script type="text/javascript" src="{{ asset('javascript/shop_products/select-all-checkbox.js') }}"></script>
    @endpush
@endsection
<!-- end:: Body -->
