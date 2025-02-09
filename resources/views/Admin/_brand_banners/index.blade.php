@extends('Admin.index')
@section('brands-active', 'm-menu__item--active m-menu__item--open')
@section('brands-view-active', 'm-menu__item--active')
@section('page-title', 'Banners|View')
@section('content')
    <style type="text/css">
        .swal2-confirm {
            background: #3085d6 !important;
            border: #3085d6 !important;
        }

        .swal2-cancel {
            background: #f12143 !important;
            color: #fff !important;
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
                                    {{ $sub_title }}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route('brand-banners.create', ['brand_id' => $brand_id]) }}"
                                        class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>New Banner</span>
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
                                id="brand-banners">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Banner</th>
                                        <th>Mobile Banner</th>
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
            $('#brand-banners').DataTable({
                "processing": true,
                "serverSide": true,
                'paging': true,
                'info': true,
                "ajax": "{{ route('brand-banners-view', $brand_id) }}",
                "columns": [{
                        "data": "id"
                    },
                    {
                        "mRender": function(data, type, row) {
                            var image = "{{ asset('storage/img###') }}";
                            image = image.replace('img###', row['image']);
                            return '<img width="100" src="' + image + '">';
                        },
                        sortable: false,
                        searchable: false,
                    },

                    {
                        "mRender": function(data, type, row) {
                            var mobile_image = "{{ asset('storage/img###') }}";
                            mobile_image = mobile_image.replace('img###', row['mobile_image']);
                            return '<img width="100" src="' + mobile_image + '">';
                        },
                        sortable: false,
                        searchable: false,
                    },

                    {
                        "mRender": function(data, type, row) {
                            var url = "{{ route('brand-banners.edit', 'id') }}";
                            url = url.replace('id', row['id']);
                            return '<a class="btn btn-primary"  href=' + url +
                                '><i class="fa fa-edit"></i></a> <a style="color:#fff" class="btn btn-danger delete" data-content="' +
                                row['id'] + '"><i class="fa fa-trash"></i></a>';
                        },
                        sortable: false,
                        searchable: false,
                    }
                ],
                error() {
                    // console.log('error!');
                }
            }).ajax.reload();

            //Delete banner data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#brand-banners").on('click', '.delete', function() {
                Swal.fire({
                    title: 'Are you sure to delete this banner data?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");
                        var urls = "{{ route('brand-banners.destroy', 'id') }}";
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
                                if (data['error']) {
                                    Swal.fire(
                                        'Cannot delete!',
                                        'Error.',
                                        'error'
                                    )
                                } else {
                                    $("#brand-banners").DataTable().ajax.reload();
                                    Swal.fire(
                                        'Deleted!',
                                        'Banner has been deleted.',
                                        'success'
                                    )
                                }
                            },
                            error: function(data) {
                                // $("#brand-banners").DataTable().ajax.reload();
                            }

                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
<!-- end:: Body -->
