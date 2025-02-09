@extends('Admin.index')
@section('users-active', 'm-menu__item--active m-menu__item--open')
@section('users-view-active', 'm-menu__item--active')
@section('page-title', 'Users|View')
@section('content')
    <style type="text/css">
        .swal2-confirm {
            background: #3085d6 !important;
            border: 1px solid #3085d6 !important;
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
                            {{ $MainTitle }}
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
                                    {{ $SubTitle }}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route('users.create') }}"
                                        class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>New user</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="m-portlet__nav-item">
                                      <a href="{{ route('users.users.export' , 'company') }}"
                                          class="btn btn-danger m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                          <span>
                                              <i></i>
                                              <span>Export Companies</span>
                                          </span>
                                      </a>
                                  </li>
                                <li class="m-portlet__nav-item">
                                      <a href="{{ route('users.users.export' , 'consumer') }}"
                                          class="btn btn-success m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                          <span>
                                              <i></i>
                                              <span>Export consumers</span>
                                          </span>
                                      </a>
                                  </li>
                              	<li class="m-portlet__nav-item">
                                      <a href="{{ route('users.users.export' , 'technician') }}"
                                          class="btn btn-dark m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                          <span>
                                              <i></i>
                                              <span>Export technician</span>
                                          </span>
                                      </a>
                                  </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin: Datatable -->
                        <div
                            style="display: flex;justify-content: 
                        flex-end;align-items:flex-end;margin-bottom: 20px">

                            <form method="get" action="{{ request()->url() }}">
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

                                        <div class="input-group" style="width: 50%">
                                            <input type="text" name="value" id="searchField" class="form-control"
                                                aria-label="Text input with dropdown button"
                                                value="{{ request()->input('value') }}">
                                            <div class="input-group-append">
                                                <select name="column" id="searchColumn"
                                                    value="{{ request()->input('column') }}" class="form-control"
                                                    data-live-search="true" title="Please select a lunch ...">
                                                    <option value="city">City</option>
                                                </select>
                                            </div>
                                            <div class="input-group-append">
                                                <button id="searchButton" class="btn btn-primary" type="submit"
                                                    title="search data">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </form>
                        </div>

                        {{-- <span>count</span> --}}
                        <div class="table-responsive">
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="users">
                                <thead>
                                    {{-- <tr>
                                        <td>count value=</td>
                                        <td id="counter">count</td>
                                    </tr> --}}
                                    <tr>
                                        {{-- <th>count</th> --}}
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>User Type</th>
                                        <th>Company</th>
                                      	<th>Category</th>
                                        <th>Date of registration</th>
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
            var url = "{!! route('user.users', [
                'start_date' => request()->input('start_date'),
                'end_date' => request()->input('end_date'),
                'column' => request()->input('column'),
                'value' => request()->input('value'),
            ]) !!}";

            loadUsers(url);

            function loadUsers(url) {

                // $('#counter').html('to be loaded');

                var table = $('#users').DataTable({
                    "processing": true,
                    "order": [],
                    "serverSide": true,
                    'paging': true,
                    'info': true,
                    "ajax": url,
                    "columns": [{
                            "data": "id"
                        },
                        {
                            "mRender": function(data, type, row) {
                                var url = "{{ asset('storage/###') }}";
                                url = url.replace('###', row['photo']);
                                if (row['photo'] == null)
                                    return 'No Image uploaded';
                                return '<img width="80" src=' + url + '>';
                            },
                            sortable: false,
                            searchable: true,
                        },
                        {
                            "data": "full_name"
                        },
                        {
                            "data": "email"
                        },
                        {
                            "data": "phone"
                        },
                        {
                            "data": "user_type"
                        },
                        {
                            "data": "company_name"
                        },
                        {
                            "data": "category_name"
                        },
                        {
                            "mRender": function(data, type, row) {
                                return row['created_at'];
                            },
                            sortable: false,
                            searchable: true,
                        },
                        {

                            "mRender": function(data, type, row) {
                                var url = "{{ route('users.edit', 'id') }}";
                                url = url.replace('id', row['id']);
                                return '<a class="btn btn-primary"  href=' + url +
                                    '><i class="fa fa-edit"></i></a> <a style="color:#fff" class="btn btn-danger delete" data-content="' +
                                    row['id'] + '"><i class="fa fa-trash"></i></a>';
                            },
                            sortable: false,
                            searchable: true,
                        }
                    ],
                    'dom': 'lifrtp',
                    'buttons': [{
                        extend: 'excelHtml5',
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            // jQuery selector to add a border
                            $('row c[r*="10"]', sheet).attr('s', '25');
                        }
                    }]
                }).ajax.reload();
            }


            //Delete user data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#users").on('click', '.delete', function() {
                Swal.fire({
                    title: 'Are you sure to delete this user?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");
                        var urls = "{{ route('users.destroy', 'id') }}";
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
                                $("#users").DataTable().ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'user has been deleted.',
                                    'success'
                                )
                            },
                            error: function(data) {
                                $("#users").DataTable().ajax.reload();
                            }

                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
<!-- end:: Body -->
