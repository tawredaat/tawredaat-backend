@extends('Admin.index')
@section('companies-active', 'm-menu__item--active m-menu__item--open')
@section('companies-view-active', 'm-menu__item--active')
@section('page-title', 'Companies|View')
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
                            {{$MainTitle}}
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
                                    {{$SubTitle}}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{route('companies.create')}}"
                                       class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la la-plus"></i>
													<span>New Company </span>
												</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div
                            style="display: flex;justify-content: flex-end;align-items:flex-end;margin-bottom: 20px">
                            <form method="get" action="{{request()->url()}}" class="col-6">
                                <div class="form-group m-form__group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="">From</span>
                                        </div>
                                        <input type="date" name="start_date"
                                               value="{{request()->input('start_date')}}" class="form-control"
                                        >
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="">To</span>
                                        </div>
                                        <input type="date" name="end_date" value="{{request()->input('end_date')}}"
                                               class="form-control"

                                        >
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i
                                                    class="fa fa-filter">
                                                </i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable"
                                   id="companies">
                                <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Pri. Name</th>
                                    <th>Pri. Phone</th>
                                    <th>Pri. Email</th>
                                    <th>Sub. date</th>
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
    @include('Admin._companies.modals')
    @include('Admin._companies.CompanySubscriptionModals')
    @push('script')
        <script type="text/javascript">
            //View Company Data in Datatable
            $('#companies').DataTable({
                "processing": true,
                "serverSide": true,
                'paging': true,
                "order": [],
                'info': true,
                "ajax": "{!!  route('company.companies',['start_date'=> request()->input('start_date'),'end_date'=> request()->input('end_date')])  !!}",
                "columns": [
                    {
                        "mRender": function (data, type, row) {
                            var img = "{{ asset('storage/img###') }}";
                            img = img.replace('img###', row['logo']);
                            return '<img width="100" src="' + img + '">';
                        },
                        sortable: false,
                        searchable: false,
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "title"
                    },
                    {
                        "data": "pri_contact_name"
                    },
                    {
                        "data": "pri_contact_phone"
                    },
                    {
                        "data": "pri_contact_email"
                    },
                    {
                        "data": "date"
                    },

                    {
                        "data": "rank"
                    },
                    {
                        "mRender": function (data, type, row) {
                            var url = "{{ route('companies.edit','id' ) }}";
                            url = url.replace('id', row['id']);
                            var edit = '<a title="edit company data" class="btn btn-primary btn-sm" style="font-size: 12px;margin:2px" href=' + url + '><i class="fa fa-edit"></i></a>';

                            var del = '<a title="Delete company" style="color:#fff;font-size: 12px;margin:2px;" class="btn btn-danger delete btn-sm" data-content="' + row['id'] + '"><i class="fa fa-trash"></i></a>';

                            var rank = '<a title="Add rank points to company" style="color:#fff;font-size: 12px;margin: 2px;" class="btn btn-info btn-sm" data-toggle="modal" data-target="#rankPoints' + row['id'] + '"><i class="fas fa-trophy"></i></a>';

                            var loginURL = "{{ route('company.admin.login','id' ) }}";
                            loginURL = loginURL.replace('id', row['id']);
                            var login = '<a title="Go to company portal" class="btn btn-info btn-sm" target="_blank" style="font-size: 12px;margin:2px" href=' + loginURL + '><i class="fa fa-sign-in "></i></a>';
                            var pass = '<a title="Change company password" style="color:#fff;font-size: 12px;margin: 2px;" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModalCenter' + row['id'] + '"><i class="fa fa-key"></i></a>';

                            var show = '<a title="Hide company" id="Aicon' + row['id'] + '" class="btn btn-danger ShowOrHide btn-sm" style="font-size: 12px;margin: 2px;color:#fff"  data-content="' + row['id'] + '"><i id="icon' + row['id'] + '" class="fa fa-eye"></i></a>';
                            if (!row['hidden']) {
                                var show = '<a title="Show company" id="Aicon' + row['id'] + '" class="btn btn-danger ShowOrHide btn-sm" style="font-size: 12px;margin: 2px;color:#fff"  data-content="' + row['id'] + '"><i id="icon' + row['id'] + '" class="fa fa-eye-slash"></i></a>';
                            }

                            var gold = '<a title="Make company gold" id="Agold' + row['id'] + '" style="color:#fff;font-size: 12px;margin:2px" data-content="' + row['id'] + '" class="btn btn-warning gold btn-sm" ><i id="gold' + row['id'] + '" class="fa fa-arrow-down"></i></a>';
                            if (!row['gold_sup']) {
                                var gold = '<a title="Remove gold from company" id="Agold' + row['id'] + '" style="color:#fff;font-size: 12px;margin:2px" data-content="' + row['id'] + '" class="btn btn-warning gold btn-sm" ><i id="gold' + row['id'] + '" class="fa fa-arrow-up"></i></a>';
                            }
                            var sub = '';
                            if (row['subscriptions'] == null) {
                                sub = '<a title="Assign subscription to company" style="color:#fff;font-size: 12px;margin: 2px;" class="btn btn-info btn-sm" data-toggle="modal" data-target="#subscripModalCenter' + row['id'] + '"><i class="fa fa-envelope"></i></a>';
                            }
                            var featured = ' <a id="featuredA' + row['id'] + '"  data-content="' + row['id'] + '" title="Make company featured in home page" class="btn btn-primary btn-sm featured" style="color:#fff;font-size: 12px;margin:2px"><i class="fas fa-fire"></i></a>';
                            if (row['feature'] == 1) {
                                var featured = ' <a  id="featuredA' + row['id'] + '" data-content="' + row['id'] + '" title="Remove company from featured in home page" class="btn btn-primary btn-sm featured" style="color:red;font-size: 12px;margin:2px"><i class="fas fa-fire"></i></a>';
                            }
                            return edit + del + rank + login + pass + show + gold + sub + featured;
                        },
                        sortable: false,
                        searchable: false,
                    },
                ]
            }).ajax.reload();

            //Delete Company data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#companies").on('click', '.delete', function () {
                Swal.fire({
                    title: 'Are you sure to delete this Company?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        var content = $(this).data("content");
                        var urls = "{{ route('companies.destroy','id' ) }}";
                        urls = urls.replace('id', content);
                        $.ajax({
                            url: urls,
                            method: 'POST',
                            data: {_token: CSRF_TOKEN, id: content, _method: "delete"},
                            dataType: 'JSON',
                            success: function (data) {
                                $("#companies").DataTable().ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'company has been deleted.',
                                    'success'
                                )
                            }
                            , error: function (data) {
                                $("#companies").DataTable().ajax.reload();
                            }

                        });
                    }
                });
            });
            //Change  Company data from gold or not
            var CSRF_TOKENs = $('meta[name="csrf-token"]').attr('content');
            $("#companies").on('click', '.gold', function () {
                var content = $(this).data("content");
                var urls = "{{ route('company.gold','idConten' ) }}";
                urls = urls.replace('idConten', content);
                $.ajax({
                    url: urls,
                    method: 'POST',
                    data: {_token: CSRF_TOKENs, id: content, _method: "post"},
                    dataType: 'JSON',
                    success: function (data) {
                        var msg = data['success'];
                        toastr.success(msg);
                        var icon = "#goldID";
                        icon = icon.replace('ID', data['id']);
                        var aTag = "#AgoldID";
                        aTag = aTag.replace('ID', data['id']);
                        if (!data['gold_sup']) {
                            $(aTag).attr('title', 'Remove gold from company');
                            $(icon).addClass('fa-arrow-up').removeClass('fa-arrow-down');
                        } else {
                            $(aTag).attr('title', 'Make company gold');

                            $(icon).addClass('fa-arrow-down').removeClass('fa-arrow-up');
                        }
                    }
                    , error: function (data) {
                    }

                });

            });
            //Show Or Hide Company
            var CSRF_TOKENg = $('meta[name="csrf-token"]').attr('content');
            $("#companies").on('click', '.ShowOrHide', function () {
                var content = $(this).data("content");
                var urls = "{{ route('company.show.hide','idConten' ) }}";
                urls = urls.replace('idConten', content);
                $.ajax({
                    url: urls,
                    method: 'POST',
                    data: {_token: CSRF_TOKENg, id: content, _method: "post"},
                    dataType: 'JSON',
                    beforeSend: function () {
                    },
                    success: function (data) {
                        var msg = data['success'];
                        toastr.success(msg);
                        var icon = "#iconID";
                        icon = icon.replace('ID', data['id']);
                        var aTag = "#AiconID";
                        aTag = aTag.replace('ID', data['id']);
                        if (!data['hidden']) {
                            $(aTag).attr('title', 'Show company');
                            $(icon).addClass('fa-eye-slash').removeClass('fa-eye');
                        } else {
                            $(aTag).attr('title', 'Hide company');
                            $(icon).addClass('fa-eye').removeClass('fa-eye-slash');
                        }
                    }
                    , error: function (data) {
                    }

                });

            });
            //Change Company Password
            $(document).ready(function () {
                $(".changeCompanyPass").submit(function (event) {
                    event.preventDefault()
                    $.ajax({
                        url: "{!! route('company.update.password') !!}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            toastr.success(data['success']);
                            var modal = "#exampleModalCenterID";
                            modal = modal.replace('ID', data['id']);
                            $(modal).modal('toggle');

                            var form = "#changeCompanyPassID";
                            form = form.replace('ID', data['id']);
                            form[0].reset();

                        },
                        error: function (data) {
                            swal("failed!", "error,Can't save data!", "error");
                        }
                    });
                });
            });
            $("#companies").on('click', '.featured', function () {
                var content = $(this).data("content");
                var urls = "{{ route('companies.featured','id' ) }}";
                urls = urls.replace('id', content);
                $.ajax({
                    url: urls,
                    method: 'POST',
                    data: {_token: CSRF_TOKEN, id: content},
                    dataType: 'JSON',
                    success: function (data) {
                        var aTag = "#featuredAID";
                        aTag = aTag.replace('ID', data['id']);
                        if (data['featured'] == 1) {
                            $(aTag).css('color', 'red');
                            $(aTag).attr('title', 'Remove company from featured in home page');
                        } else if (data['featured'] == 0) {
                            $(aTag).css('color', '#fff');
                            $(aTag).attr('title', 'Make company featured in home page');
                        }
                        var msg = data['success'];
                        toastr.success(msg);
                    }
                    , error: function (data) {
                        Swal.fire(
                            'failed!',
                            "cant't make this company featured,try again.",
                            'error'
                        )
                    }

                });
            });
        </script>
    @endpush
@endsection
<!-- end:: Body -->

