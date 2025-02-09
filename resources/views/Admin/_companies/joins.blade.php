@extends('Admin.index')
@section('companies-active', 'm-menu__item--active m-menu__item--open')
@section('companies-join-active', 'm-menu__item--active')
@section('page-title', 'Companies|Join requests')
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
                    </div>
                    <div class="m-portlet__body">
                        <div class="table-responsive">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable"
                                   id="companies">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Phone</th>
                                    <th>Company Type</th>
                                    <th>Website</th>
                                    <th>Facebook</th>
                                    <th>Date - Time</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($requests as $request)
                                    <tr>
                                        <td>{{$request->name}}</td>
                                        <td>{{$request->company_name}}</td>
                                        <td>{{$request->email}}</td>
                                        <td>{{$request->mobile}}</td>
                                        <td>{{$request->phone}}</td>
                                        <td>{{$request->company_type}}</td>
                                        <td><a target="_blank" href="{{$request->website}}">{{$request->website}}</a></td>
                                        <td><a target="_blank" href="{{$request->facebook}}">{{$request->facebook}}</a></td>
                                        <td>{{$request->created_at}}</td>
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
            //View Company Data in Datatable
            $('#companies').DataTable({
                "order": [[ 8, "desc" ]]
            });
        </script>
    @endpush
@endsection
<!-- end:: Body -->

