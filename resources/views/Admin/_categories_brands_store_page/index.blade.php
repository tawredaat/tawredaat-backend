@extends('Admin.index')
@section('categories-brands-store-pages-active', 'm-menu__item--active m-menu__item--open')
@section('categories-brands-store-pages-view-active', 'm-menu__item--active')
@section('page-title', 'Categories brands in the brands store page|View')
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
                                    <a href="{{ route('categories-brands-store-pages.create') }}"
                                        class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>New Categories Brands</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="table-responsive">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable"
                                id="categories-brands-store-pages">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>Category</th>
                                        <th>Brands</th>
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
            $('#categories-brands-store-pages').DataTable({
                "processing": true,
                "serverSide": true,
                'paging': true,
                'info': true,
                "ajax": "{{ route('categories-brands-store-pages.data') }}",
                "columns": [
                    // {
                    //     "data": "id"
                    // },
                    {
                        "data": "category_name"
                    },
                    {
                        "data": "brands_names"
                    },
                    {
                        "mRender": function(data, type, row) {
                            var url = "{{ route('categories-brands-store-pages.edit', 'id') }}";
                            url = url.replace('id', row['id']);
                            console.log("row[id]=" + row["id"]);
                            var id = row["id"];
                            return '<a class="btn btn-primary"  href=' + url +
                                '><i class="fa fa-edit"></i></a> <a style="color:#fff" class="btn btn-danger delete" data-content="' +
                                row['id'] +
                                '"><i class="fa fa-trash"></i></a>';
                        },
                        sortable: false,
                        searchable: false,
                    }
                ]
            }).ajax.reload();


            //Delete categories-brands-store-pages data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#categories-brands-store-pages").on('click', '.delete', function() {
                Swal.fire({
                    title: 'Are you sure to delete this?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");
                        var urls = "{{ route('categories-brands-store-pages.destroy', 'id') }}";
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
                                $("#categories-brands-store-pages").DataTable().ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'Deleted.',
                                    'success'
                                )
                            },
                            error: function(data) {
                                $("#categories-brands-store-pages").DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
<!-- end:: Body -->
