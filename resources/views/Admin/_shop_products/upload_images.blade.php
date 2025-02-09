@extends('Admin.index')
@section('shop-products-active', 'm-menu__item--active m-menu__item--open')
@section('shop-products-images-active', 'm-menu__item--active')
@section('page-title', 'Shop | Products | upload products images')
@push('style')
    <style type="text/css">
        #CustomerTable_wrapper {
            overflow-x: scroll;
        }

        .col-md-3,
        .col-md-2 {
            height: 100px;
        }

        .page-heading {
            margin: 20px 0;
            color: #666;
            -webkit-font-smoothing: antialiased;
            font-family: "Segoe UI Light", "Arial", serif;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        #my-dropzone .message {
            font-family: "Segoe UI Light", "Arial", serif;
            font-weight: 600;
            color: #0087F7;
            font-size: 1.5em;
            letter-spacing: 0.05em;
        }

        .dropzone {
            border: 2px dashed #0087F7;
            background: white;
            border-radius: 5px;
            min-height: 100px;
            padding: 10px 0;
            vertical-align: baseline;
        }
    </style>
@endpush
@section('content')
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
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <div class="m-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::Portlet-->
                                <div class="m-portlet">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>
                                                <h3 class="m-portlet__head-text">{{ $title }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10 offset-sm-1">
                                            <h2 class="page-heading">Upload your Images asd <span id="counter"></span>
                                            </h2>
                                            <form method="post" enctype="multipart/form-data"
                                                class="dropzone m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                                                id="my-dropzone">
                                                @csrf
                                                <div class="dz-message">
                                                    <div class="col-xs-8">
                                                        <div class="message">
                                                            <p>Drop files here or Click to Upload</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <br>
                                            <hr>
                                            <br>
                                            <div class="table-resposive" style="padding: 60px">
                                                <!--end::Form-->
                                                <table
                                                    class="table table-striped- table-bordered table-hover table-checkable"
                                                    id="ProductsImages">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <input type="checkbox" class=" select-all">
                                                            </th>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div style="display: flex;justify-content: flex-start;align-items:flex-start;">
                                                <form method="post" id="deleteForm"
                                                    action="{{ route('shop.products.images.delete.selected') }}"
                                                    style="margin-right: 3px">
                                                    @csrf
                                                    <div class="form-group m-form__group">
                                                        <button class="btn btn-danger" type="submit">
                                                            Delete Selected <span id="deleteCount">0</span> Images
                                                        </button>
                                                    </div>
                                                </form>

                                                <?php
                                                $display = 'none';
                                                if (isset($_GET['start_date'])) {
                                                    $display = 'visible';
                                                }
                                                ?>

                                                <form method="post" id="deleteFilteredForm"
                                                    style="margin-right: 3px;display:{{ $display }}">
                                                    @csrf
                                                    <div class="form-group m-form__group">
                                                        <button class="btn btn-danger" id="deleteFilteredBtn"
                                                            type="button">
                                                            Delete Filtered Products
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
        <script type="text/javascript">
            //view images in DT ProductsImages
            $('#ProductsImages').DataTable({
                "processing": true,
                "serverSide": true,
                'paging': true,
                'info': true,
                "ajax": "{{ route('shop.product.uploaded.images') }}",
                "columns": [{
                        "mRender": function(data, type, row) {
                            return '<input form="deleteForm" type="checkbox" name="images[]" value="' +
                                row['id'] +
                                '">';
                        },
                        sortable: false
                    }, {
                        "data": "id"
                    }, {
                        "data": "image"
                    },
                    {
                        "mRender": function(data, type, row) {
                            var url = "{{ asset('storage/++++') }}";
                            url = url.replace('++++', row['image']);
                            return '<img width="60" alt="' + row['alt_en'] + '" src="' + url + '">';
                        },
                        sortable: false
                    }, {
                        "mRender": function(data, type, row) {
                            return '<a style="color:#fff" class="btn btn-danger delete" data-content="' + row[
                                'id'] + '"><i class="fa fa-trash"></i></a>';
                        },
                        sortable: false,
                    }
                ]
            }).ajax.reload();

            // search
            $('.dataTables_filter input').on('input', function() {
                var searchTerm = $(this).val().trim();
                if (searchTerm != "") {
                    $('#deleteFilteredForm').show();
                }
            });

            $('#deleteFilteredBtn').on('click', function(imagesArray) {
                var searchTerm = $('.dataTables_filter input').val().trim();
                deleteFilteredImages(searchTerm);
            });

            function deleteFilteredImages(searchTerm) {
                var imagesArray = $('input[name="images[]"]').map(function() {
                    return this.value;
                }).get();

                var url = "{{ route('shop.products.images.delete.filtered') }}";
                $.ajax({
                    url: url,
                    method: 'post',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        search_term: searchTerm
                    },
                    dataType: 'JSON',
                    beforeSend: function() {},
                    success: function(found) {
                        Swal.fire(
                            'Deleted!',
                            'All filtered images have been deleted!',
                            'success'
                        );
                        $("#ProductsImages").DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'Cannot delete',
                            'error'
                        );
                    }
                });
            }

            //upload images
            var total_photos_counter = 0;
            Dropzone.options.myDropzone = {
                url: '{{ route('shop.products.upload') }}',
                init: function() {
                    var th = this;
                    this.on('queuecomplete', function() {
                        th.removeAllFiles();
                    });
                },
                sending: function(data, xhr, formData) {
                    formData.append('_token', "{{ csrf_token() }}");
                },
                paramName: "images",
                uploadMultiple: true,
                parallelUploads: 1,
                maxFiles: 25,
                // 20MB in bytes
                maxFilesize: 20 * 1024 * 1024,
                addRemoveLinks: true,
                dictFileTooBig: 'Image is larger than 2MB',
                timeout: 10000,
                acceptedFiles: ".jpeg,.jpg,.png,.gif,.webp",
                success: function(file, done) {
                    total_photos_counter++;
                    $("#counter").text("# " + total_photos_counter);
                    $("#ProductsImages").DataTable().ajax.reload();
                },
                error: function(xmlHttpRequest, textStatus, errorThrown) {
                    var error_string = JSON.parse(errorThrown['response']);
                    var error_messages = error_string['errors'];

                    Swal.fire(
                        error_string['message'],
                        JSON.stringify(error_messages),
                        'error'
                    );
                }
            };

            //delete image
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#ProductsImages").on('click', '.delete', function() {
                var content = $(this).data("content");
                var urls = "{{ route('shop.ProductsImages.delete', 'id') }}";
                urls = urls.replace('id', content);
                $.ajax({
                    url: urls,
                    method: 'POST',
                    async: false,
                    data: {
                        _token: CSRF_TOKEN,
                        id: content,
                        _method: "delete"
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        $("#ProductsImages").DataTable().ajax.reload();
                    },
                    error: function(data) {
                        Swal.fire(
                            'Failed!',
                            "Image can't  deleted.",
                            'error'
                        );
                        $("#ProductsImages").DataTable().ajax.reload();
                    }
                });
            });

            $('table').on('change', 'input[name="images[]"]', function() {
                $('#deleteCount').text($('input[name="images[]"]:checked').length);
            });
        </script>

        <script type="text/javascript" src="{{ asset('javascript/shop_product_images/select-all-checkbox.js') }}"></script>
    @endpush
@endsection
