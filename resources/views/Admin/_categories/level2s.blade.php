@extends('Admin.index')
@section('categories-active', 'm-menu__item--active m-menu__item--open')
@section('categories-view-active', 'm-menu__item--active')
@section('page-title', 'Categories|View|Level 2')
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
                                    <a href="{{ route('categories.create') }}"
                                        class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>New Category</span>
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
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($categories as $category)
                                        <tr id="tr-{{ $category->id }}">
                                            <td>{{ $i++ }}</td>
                                            <td><img alt="image-not-found" src="{{ asset('storage/' . $category->image) }}"
                                                    width="80"></td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                <a class="btn btn-default"
                                                    href="{{ route('category-banners.index', ['category_id' => $category->id]) }}">
                                                    <i class="fa fa-flag-o"></i></a>
                                                <a class="btn btn-primary"
                                                    href="{{ route('categories.edit', $category->id) }}"><i
                                                        class="fa fa-edit"></i></a>
                                                <a class="btn btn-default" target="_blank"
                                                    href="{{ route('category.categories.level3s', $category->id) }}"><i
                                                        class="fa fa-child"></i></a>
                                               
                                                @if ($category->featured == 1)
                                                    <a id="featuredA{{ $category->id }}"
                                                        data-content="{{ $category->id }}"
                                                        title="Remove category from featured in home page"
                                                        class="btn btn-primary featured" style="color:red"><i
                                                            class="fas fa-fire"></i></a>
                                                @else
                                                    <a id="featuredA{{ $category->id }}"
                                                        data-content="{{ $category->id }}"
                                                        title="Make category featured in home page"
                                                        class="btn btn-primary featured" style="color:#fff"><i
                                                            class="fas fa-fire"></i></a>
                                                @endif

                                                @if ($category->show == 1)
                                                <a id="showA{{ $category->id }}"
                                                    data-content="{{ $category->id }}"
                                                    title="Hide this category from shop by category section in home page"
                                                    class="btn btn-default show" ><i
                                                        class="fas fa-eye"></i></a>
                                            @else
                                                <a id="showA{{ $category->id }}"
                                                    data-content="{{ $category->id }}"
                                                    title="Show this category at shop by category section in home page"
                                                    class="btn btn-default show"   ><i class="fa fa-eye-slash"></i></a>
                                            @endif

                                            <a style="color:#fff" class="btn btn-danger delete"
                                            data-content="{{ $category->id }}"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
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
            $('#categories').DataTable();

            //Delete category data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#categories").on('click', '.delete', function() {
                Swal.fire({
                    title: 'Are you sure to delete this category?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");
                        var urls = "{{ route('categories.destroy', 'id') }}";
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
                                $("#categories").DataTable().row($('#tr-' + data['id'])).remove()
                                    .draw();
                                Swal.fire(
                                    'Deleted!',
                                    'category has been deleted.',
                                    'success'
                                )
                            },
                            error: function(data) {
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
                    location.reload();

                        var aTag = "#showAID";
                        aTag = aTag.replace('ID', data['id']);
                        if (data['show'] == 1) {
                            $(aTag).attr('title', 'Hide this category from shop by category section in home page');
                        } else if (data['featured'] == 0) {
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

        </script>
    @endpush
@endsection
<!-- end:: Body -->
