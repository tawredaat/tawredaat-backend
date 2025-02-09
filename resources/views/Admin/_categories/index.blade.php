@extends('Admin.index')
@section('categories-active', 'm-menu__item--active m-menu__item--open')
@section('categories-view-active', 'm-menu__item--active')
@section('page-title', 'Categories|View|Parents')
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
                                    <a href="{{ route('categories.create-level-1') }}"
                                        class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>New Level 1 Category</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="table-responsive">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="categories">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
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
            $('#categories').DataTable({
                "processing": true,
                "serverSide": true,
                'paging': true,
                'info': true,
                "ajax": "{{ route('category.categories') }}",
                "columns": [{
                        "mRender": function(data, type, row) {
                            var img = "{{ asset('storage/img###') }}";
                            img = img.replace('img###', row['image']);
                            return '<img width="100" src="' + img + '">';
                        },
                        sortable: false,
                        searchable: false,
                    },
                    {
                        "data": "name"
                    },
                    {
                        "mRender": function(data, type, row) {
                            var l2 = "{{ route('category.categories.level2s', 'id') }}";
                            l2 = l2.replace('id', row['id']);
                            var url = "{{ route('categories.edit', 'id') }}";
                            url = url.replace('id', row['id']);
                            var btns = "";
                            btns +=
                                ' <a style="color:#fff" class="btn btn-default banners" title="banners"  data-content="' +
                                row['id'] + '"' +
                                '><i class="fa fa-flag-o"></i></a>';
                            btns += '<a class="btn btn-primary" title="Edit Category Data" href=' +
                                url +
                                '><i class="fa fa-edit"></i></a>';
                            btns +=
                                ' <a title="View childs categories in this category" class="btn btn-default" target="_blank"  href=' +
                                l2 +
                                '><i class="fa fa-child"></i>';

                            //return btns +featured;
                            // btns +=
                            //     '<a title="View childs categories in this category" class="btn btn-default" target="_blank"  href=' +
                            //     l2 + '><i class="fa fa-child"></i></a>';




                            var featured = "";
                            if (row['featured'] == 1) {
                                featured = '<a  id="featuredA' + row['id'] + '" data-content="' + row[
                                        'id'] +
                                    '" title="Remove category from featured in home page" class="btn btn-primary featured" style="color:red"><i class="fas fa-fire"></i></a>';
                            } else {
                                featured = '<a  id="featuredA' + row['id'] + '" data-content="' + row[
                                        'id'] +
                                    '" title="Add category to featured in home page" class="btn btn-primary featured" style="color:white"><i class="fas fa-fire"></i></a>';

                            }

                            btns += featured;


                            var show = "";
                            if (row['show'] == 1) {
                                
                                show = '<a  id="showA' + row['id'] + '" data-content="' + row[
                                        'id'] +
                                    '" title="Hide this category from shop by category section in home page" class=" show btn btn-default" target="_blank"  ><i id="showI' + row['id'] + '" class="fa fa-eye" ></i></a>';
                            } else {
                                show = '<a  id="showA' + row['id'] + '" data-content="' + row[
                                        'id'] +
                                    '" title="Show this category at shop by category section in home page" class=" show btn btn-default" target="_blank"  ><i id="showI' + row['id'] + '" class="fa fa-eye-slash" ></i></a>';

                            }

                            btns += show;

                            btns +=
                                ' <a style="color:#fff" title="Delete Category" class="btn btn-danger delete" data-content="' +
                                row['id'] + '"><i class="fa fa-trash"></i></a> ';

                            btns +=
                            ' <a style="color:#fff" title="Top Brands" class="btn btn-dark topBrands" data-content="' +
                            row['id'] + '"><i class="m-menu__link-icon fa fa-xing"></i></a> ';

                            btns +=
                            ' <a style="color:#fff" title="Top Categories" class="btn btn-info topCategories" data-content="' +
                            row['id'] + '"><i class="m-menu__link-icon fa fa-list-alt"></i></a> ';  
                            
                            return btns;
                        },
                        sortable: false,
                        searchable: false,
                    }
                ]
            }).ajax.reload();

            //Delete admin data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#categories").on('click', '.delete', function() {
                Swal.fire({
                    title: 'Are you sure to delete this admin?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");
                        var urls = "{{ route('categories.destroy-level-1', 'id') }}";
                        urls = urls.replace('id', content);
                        $.ajax({
                            url: urls,
                            method: 'POST',
                            data: {
                                _token: CSRF_TOKEN,
                                id: content
                            },
                            dataType: 'JSON',
                            beforeSend: function() {},
                            success: function(data) {
                                $("#categories").DataTable().ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'category has been deleted.',
                                    'success'
                                )
                            },
                            error: function(data) {
                                console.log('in error, data=' + JSON.stringify(data));
                                Swal.fire(
                                    'failed!',
                                    "cant't delete this category,it's has childrens",
                                    'error'
                                )
                            }

                        });
                    }
                });
            }); 
            $("#categories").on('click', '.featured', function() {
                var content = $(this).data("content");
                var urls = "{{ route('categories.featured', 'id') }}";
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
                            $(aTag).attr('title', 'Remove category from featured in home page');
                        } else if (data['featured'] == 0) {
                            $(aTag).css('color', '#fff');
                            $(aTag).attr('title', 'Make category featured in home page');
                        }
                        var msg = data['success'];
                        toastr.success(msg);
                    },
                    error: function(data) {
                        Swal.fire(
                            'failed!',
                            "cant't make this category featured,try again.",
                            'error'
                        )
                    }

                });
            });

            $("#categories").on('click', '.show', function() {
                var content = $(this).data("content");
                var urls = "{{ route('categories.showCategory', 'id') }}";
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
                            $(aTag).attr('title', 'Hide this category from shop by category section in home page');
                        } else if (data['show'] == 0) {
                            $(iTag).attr('class','fa fa-eye-slash');
                            $(aTag).attr('title', 'Show this category at shop by category section in home page');
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


            $("#categories").on('click', '.banners', function() {
                var content = $(this).data("content");
                var url = "{{ route('category-banners.index', ['category_id' => 'cat_id']) }}";
                url = url.replace('cat_id', content);
                console.log('url=' + url);
                window.location = url;
            });

            $("#categories").on('click', '.topBrands', function() {
                var content = $(this).data("content");
                var url = "{{ route('category.topBrands.create', ['category_id' => 'cat_id']) }}";
                url = url.replace('cat_id', content);
                console.log('url=' + url);
                window.location = url;
            });

            $("#categories").on('click', '.topCategories', function() {
                var content = $(this).data("content");
                var url = "{{ route('category.topCategories.create', ['category_id' => 'cat_id']) }}";
                url = url.replace('cat_id', content);
                console.log('url=' + url);
                window.location = url;
            });

        </script>
    @endpush
@endsection
<!-- end:: Body -->
