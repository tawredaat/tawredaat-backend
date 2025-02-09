@extends('Admin.index')
@section('brands-active', 'm-menu__item--active m-menu__item--open')
@section('brands-view-active', 'm-menu__item--active')
@section('page-title', 'Brands|View')
@section('content')
    <style type="text/css">
        3 .swal2-confirm {
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
                                    {{ $SubTitle }}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route('brands.create') }}"
                                        class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>New Brand</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div style="display: flex;justify-content: flex-end;align-items:flex-end;margin-bottom: 20px">
                            <form method="get" action="{{ request()->url() }}" class="col-6">
                                <div class="form-group m-form__group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="">From</span>
                                        </div>
                                        <input type="date" name="start_date" value="{{ request()->input('start_date') }}"
                                            class="form-control">
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
                        </div>
                        <div class="table-responsive">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="brands">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Rank</th>
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
    @include('Admin._brands.modals')
    @push('script')
        <script type="text/javascript">
            $('#brands').DataTable({
                "processing": true,
                "serverSide": true,
                'paging': true,
                'info': true,
                "ajax": "{!! route('brand.brands', [
                    'start_date' => request()->input('start_date'),
                    'end_date' => request()->input('end_date'),
                ]) !!}",
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "mRender": function(data, type, row) {
                            var url = "{{ asset('storage/photo###') }}";
                            url = url.replace('photo###', row['image']);
                            return '<img width="100" alt="' + row['alt_en'] + '" src="' + url + '">';
                        },
                        sortable: false,
                        searchable: false,
                    },
                    {
                        "data": "rank"
                    },
                    {
                        "mRender": function(data, type, row) {
                            var url = "{{ route('brands.edit', 'id') }}";
                            url = url.replace('id', row['id']);
                            var btns = '<a class="btn btn-primary"  href=' + url +
                                '><i class="fa fa-edit"></i></a> <a style="color:#fff" class="btn btn-danger delete" data-content="' +
                                row['id'] +
                                '"><i class="fa fa-trash"></i></a> <a title="Add rank points to company" style="color:#fff;" class="btn btn-info" data-toggle="modal" data-target="#rankPoints' +
                                row['id'] + '"><i class="fas fa-trophy"></i></a>' +
                                ' <a style="color:#fff" class="btn btn-primary banners" title="banners"  data-content="' +
                                row['id'] + '"' +
                                '><i class="fa fa-flag-o"></i></a>';;
                            var featured = ' <a id="featuredA' + row['id'] + '"  data-content="' + row['id'] +
                                '" title="Make brand featured in home page" class="btn btn-primary featured" style="color:#fff;font-size: 12px;margin:2px"><i class="fas fa-fire"></i></a>';
                            if (row['featured'] == 1) {
                                var featured = ' <a  id="featuredA' + row['id'] + '" data-content="' + row[
                                        'id'] +
                                    '" title="Remove brand from featured in home page" class="btn btn-primary featured" style="color:red;font-size: 12px;margin:2px"><i class="fas fa-fire"></i></a>';
                            }
                            btns + featured;

                            var show = ' <a id="showA' + row['id'] + '"  data-content="' + row['id'] +
                                '" title="Show brand in website" class="btn btn-primary show" style="color:#fff;font-size: 12px;margin:2px"><i id="showI' + row['id'] + '" class="fas fa-eye-slash"></i></a>';
                            if (row['show'] == 1) {
                                var show = ' <a  id="showA' + row['id'] + '" data-content="' + row[
                                        'id'] +
                                    '" title="Hide brand from website" class="btn btn-primary show" style="color:#fff;font-size: 12px;margin:2px"><i id="showI' + row['id'] + '" class="fas fa-eye"></i></a>';
                            }
                            btns += show;
                            var exportBtn = ' <button id="exportA' + row['id'] + '"  data-content="' + row['id'] +
                                '"  title="Export product brand " class="btn btn-success exportBtn" ><i class="fa fa-file"></i></button>';
                            btns += exportBtn;
                            var importBtn = ' <button id="importA' + row['id'] + '"  data-content="' + row['id'] +
                                '"  title="import product brand " class="btn btn-primary importBtn" ><i class="fa fa-file-excel-o"></i></button>';
                            btns += importBtn;
                            return btns ;
                        },
                        sortable: false,
                        searchable: false,
                    }
                ]
            }).ajax.reload();

            $("#brands").on('click', '.banners', function() {
                var content = $(this).data("content");
                var url = "{{ route('brand-banners.index', ['brand_id' => 'brandId']) }}";
                url = url.replace('brandId', content);
                console.log('url=' + url);
                window.location = url;
            });

            //Delete brand data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#brands").on('click', '.delete', function() {
                Swal.fire({
                    title: 'Are you sure to delete this Brand?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");
                        var urls = "{{ route('brands.destroy', 'id') }}";
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
                                $("#brands").DataTable().ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'brand data has been deleted.',
                                    'success'
                                )
                            },
                            error: function(data) {
                                $("#brands").DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });
            //make brands featured
            $("#brands").on('click', '.featured', function() {
                var content = $(this).data("content");
                var urls = "{{ route('brands.featured', 'id') }}";
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
                        var aTag = "#featuredAID";
                        aTag = aTag.replace('ID', data['id']);
                        if (data['featured'] == 1) {
                            $(aTag).css('color', 'red');
                            $(aTag).attr('title', 'Remove brand from featured in home page');
                        } else if (data['featured'] == 0) {
                            $(aTag).css('color', '#fff');
                            $(aTag).attr('title', 'Make brand featured in home page');
                        }
                        var msg = data['success'];
                        toastr.success(msg);
                    },
                    error: function(data) {
                        Swal.fire(
                            'failed!',
                            "cant't make this brand featured,try again.",
                            'error'
                        )
                    }

                });
            });

            $("#brands").on('click', '.show', function() {
                var content = $(this).data("content");
                var urls = "{{ route('brands.show', 'id') }}";
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
                     var iTag = "#showIID";
                        iTag = iTag.replace('ID', data['id']);

                        var aTag = "#showAID";
                        aTag = aTag.replace('ID', data['id']);
                        if (data['show'] == 1) {
                            $(iTag).attr('class','fa fa-eye');
                            $(aTag).attr('title', 'Hide this brand from website');
                        } else if (data['show'] == 0) {
                            $(iTag).attr('class','fa fa-eye-slash');
                            $(aTag).attr('title', 'Show this brand at website');
                        }
                        var msg = data['success'];
                        toastr.success(msg);
                    },
                    error: function(data) {
                        Swal.fire(
                            'failed!',
                            "Please try again later.",
                            'error'
                        )
                    }

                });
            });

            // export excel
            $("#brands").on('click', '.exportBtn', function() {
    var content = $(this).data("content");
    $.ajax({
        url: "{{ route('exportProductBrand') }}",
        method: "GET",
        data: {
            id: content
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            // Prepare CSV content with proper encoding and meta tag
            var csvContent = "<head><meta charset='UTF-8'></head>" + response;
            
            // Create a Blob object from the response
            var blob = new Blob([csvContent], { type: 'text/csv' });

            // Create a temporary link element
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = content + '.csv'; // Set filename
            link.click();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

            //end export

            //import excel file
            // JavaScript to handle file upload
            $(document).ready(function() {
                $('#brands').on('click', '.importBtn', function() {
                    // Create a hidden file input element
                    var fileInput = $('<input type="file" style="display:none">');

                    // Append the file input to the body and trigger click event
                    $('body').append(fileInput);
                    fileInput.trigger('click');

                    // Handle file selection change
                    fileInput.on('change', function(event) {
                        var file = event.target.files[0];

                        // Proceed with file upload
                        uploadFile(file);

                        // Remove the file input from the body
                        fileInput.remove();
                    });
                });

                // Function to handle file upload
                function uploadFile(file) {
                    var formData = new FormData();
                    formData.append('excelFile', file);

                    // Include CSRF token in the headers
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: "{{ route('importProductBrand') }}",
                        method: "POST", // Change method to POST
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            console.log(response);
                            // Handle success response
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            // Handle error response
                        }
                    });
                }
            });
            //end import
        </script>
    @endpush
@endsection
<!-- end:: Body -->
