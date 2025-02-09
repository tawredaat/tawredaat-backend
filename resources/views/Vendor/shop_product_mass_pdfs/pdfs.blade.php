@extends('Vendor.index')
@section('shop-products-active', 'm-menu__item--active m-menu__item--open')
@section('shop-products-pdfs-active', 'm-menu__item--active')
@section('page-title', 'Shop | Products | upload products PDFs')
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
                                            <h2 class="page-heading">Upload your PDFs files <span id="counter"></span>
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
                                                    id="ProducstPDFs">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>PDF</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
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
            //view images in DT
            $('#ProducstPDFs').DataTable({
                "processing": true,
                "serverSide": true,
                'paging': true,
                'info': true,
                "ajax": "{{ route('vendor.shop-product-mass-pdfs.data') }}",
                "columns": [{
                    "data": "id"
                }, {
                    "mRender": function(data, type, row) {
                        var url = "{{ asset('storage/++++') }}";
                        url = url.replace('++++', row['pdf']);
                        return '<a class="btn btn-default" width="60"  href="' + url +
                            '" target="_blank">' + row['pdf'] + ' <i class="fa fa-download"></i></a>';
                    },
                    sortable: false,
                    searchable: false,
                }, {
                    "mRender": function(data, type, row) {
                        return '<a style="color:#fff" class="btn btn-danger delete" data-content="' + row[
                            'id'] + '"><i class="fa fa-trash"></i></a>';
                    },
                    sortable: false,
                    searchable: false,
                }]
            }).ajax.reload();

            //upload pdfs
            var total_photos_counter = 0;
            Dropzone.options.myDropzone = {
                url: '{{ route('vendor.shop-product-mass-pdfs.upload') }}',
                sending: function(data, xhr, formData) {
                    formData.append('_token', "{{ csrf_token() }}");
                },
                init: function() {
                    var th = this;
                    this.on('queuecomplete', function() {
                        th.removeAllFiles();
                    });
                },
                paramName: "pdfs",
                uploadMultiple: true,
                parallelUploads: 2,
                maxFiles: 50,
                maxFilesize: 50,
                addRemoveLinks: true,
                dictFileTooBig: 'PDF is larger than 50MB',
                timeout: 10000,
                acceptedFiles: ".pdf",
                success: function(file, done) {
                    total_photos_counter++;
                    $("#counter").text("# " + total_photos_counter);
                    $("#ProducstPDFs").DataTable().ajax.reload();
                }
            };
            //delete image
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#ProducstPDFs").on('click', '.delete', function() {
                var content = $(this).data("content");
                var urls = "{{ route('vendor.shop-product-mass-pdfs.delete', 'id') }}";
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
                        $("#ProducstPDFs").DataTable().ajax.reload();
                    },
                    error: function(data) {
                        Swal.fire(
                            'Failed!',
                            "PDF can't deleted.",
                            'error'
                        );
                        $("#ProducstPDFs").DataTable().ajax.reload();
                    }
                });
            });
        </script>
        @endpush @endsection
