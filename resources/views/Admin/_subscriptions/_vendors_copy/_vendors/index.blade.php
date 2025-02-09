@extends('Admin.index')
@section('vendors-active', 'm-menu__item--active m-menu__item--open')
@section('vendors-view-active', 'm-menu__item--active')
@section('page-title', 'Vendor|View')
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
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route('vendors.create') }}"
                                        class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>New Vendor</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="table-responsive">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="vendors">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Company Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>

    @push('script')
        <script type="text/javascript">
            $('#vendors').DataTable({
                "processing": true,
                "serverSide": true,
                'paging': true,
                'info': true,
                "ajax": "{{ route('vendors.data') }}",
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "company_name"
                    },
                    {
                        "mRender": function(data, type, row) {
                            var url = "{{ route('vendors.edit', 'id') }}";
                            url = url.replace('id', row['id']);

                            approve_unapprove = "";

                            if (row['is_approved'] == 0) {
                                approve_unapprove =
                                    ' <a style="color:#fff" class="btn btn-success approve" title="approve vendor" data-content="' +
                                    row['id'] + '"><i class="fa fa-check"></i></a>';
                            }

                            if (row['is_approved'] == 1) {
                                approve_unapprove =
                                    ' <a style="color:#fff" class="btn btn-danger unapprove" title="disapprove vendor" data-content="' +
                                    row['id'] + '"><i class="fa fa-times"></i></a>';
                            }

                            console.log("row[id]=" + row["id"]);
                            var id = row["id"];
                            console.log("id=" + id);
                            return '<a class="btn btn-primary"  href=' + url +
                                '><i class="fa fa-edit"></i></a> <a style="color:#fff" class="btn btn-danger delete" data-content="' +
                                row['id'] +
                                '"><i class="fa fa-trash"></i></a>' +
                                approve_unapprove +
                                ' <a style="color:#fff" class="btn btn-primary products" title="products"  data-content="' +
                                row['id'] + '"' +
                                '><i class="fa fa-product-hunt"></i></a>';
                        },
                        sortable: false,
                        searchable: false,
                    }
                ]
            }).ajax.reload();


            //Delete vendors data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#vendors").on('click', '.delete', function() {
                Swal.fire({
                    title: 'Are you sure to delete this vendor?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");
                        var urls = "{{ route('vendors.destroy', 'id') }}";
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
                                $("#vendors").DataTable().ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'Vendor has been deleted.',
                                    'success'
                                )
                            },
                            error: function(data) {
                                $("#vendors").DataTable().ajax.reload();
                            }

                        });
                    }
                });
            });

            // Approve/unapprove vendor
            $("#vendors").on('click', '.approve', function() {


                Swal.fire({
                    title: 'Are you sure you want to approve this vendor?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");

                        var urls = "{{ route('vendors.approve', 'id') }}";
                        urls = urls.replace('id', content);
                        $.ajax({
                            url: urls,
                            method: 'POST',
                            data: {
                                _token: CSRF_TOKEN,
                                id: content,
                                _method: "post"
                            },
                            dataType: 'JSON',
                            beforeSend: function() {},
                            success: function(data) {

                                $("#vendors").DataTable().ajax.reload();
                                Swal.fire(
                                    'Done!',
                                    'Vendors has been approved.',
                                    'success'
                                )
                            },
                            error: function(data) {
                                $("#vendors").DataTable().ajax.reload();
                            }

                        });
                    }
                });
            });

            $("#vendors").on('click', '.unapprove', function() {
                Swal.fire({
                    title: 'Are you sure you want to disapprove this vendor?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, disapprove it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");

                        var urls = "{{ route('vendors.approve', 'id') }}";
                        urls = urls.replace('id', content);
                        $.ajax({
                            url: urls,
                            method: 'POST',
                            data: {
                                _token: CSRF_TOKEN,
                                id: content,
                                _method: "post"
                            },
                            dataType: 'JSON',
                            beforeSend: function() {},
                            success: function(data) {
                                $("#vendors").DataTable().ajax.reload();
                                Swal.fire(
                                    'Done!',
                                    'Vendors has been disapproved.',
                                    'success'
                                )
                            },
                            error: function(data) {
                                $("#vendors").DataTable().ajax.reload();
                            }

                        });
                    }
                });
            });

            $("#vendors").on('click', '.products', function() {
                var content = $(this).data("content");
                // console.log('products is clicked');
                var url = "{{ route('vendor-shop-products.index', 'id') }}";
                url = url.replace('id', content);
                window.location = url;
            });
        </script>
    @endpush
@endsection
<!-- end:: Body -->
