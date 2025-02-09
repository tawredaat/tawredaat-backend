@extends('Admin.index')
@section('rfqs-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'User RFQs|View')
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
                    </div>
                    <div class="m-portlet__body">
                        <form method="GET" action="{{ route('admins.rfqs.export') }}" id="filterDataForm">
                            <div class="input-group-append">
                                <button id="exportButton" class="btn btn-primary" type="submit" style="margin:0 5px"
                                    title="export data">
                                    <i class="fa fa-file">Export All Rfqs</i>
                                </button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="rfqs">
                                <thead>
                                    <tr>
                                        <th style="display:none"></th>
                                        <th>RFQ Number </th>
                                        <th>Status </th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>User Phone</th>
                                        <th>Date/Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($records as $record)
                                        <tr>
                                            <td style="display:none">{{ $loop->index + 1 }}</td>
                                            <td>#{{ $record->id }}</td>
                                            <td>
                                                <span
                                                    style="color:{{ $record->statusColor() }}">{{ $record->status}}</span>
                                            </td>
                                            <td>{{ $record->user_name }}</td>
                                            <td>{{ $record->email }}</td>
                                            <td>{{ $record->phone }}</td>
                                            <td>{{ date('M d, Y', strtotime($record->created_at)) . '/' . date('h:i a', strtotime($record->created_at)) }}
                                            </td>
                                            <td>
                                                @if ($record->status === 'Not Responsed')
                                                    <a href="{{ route('admins.rfqs.reject', $record->id) }}"
                                                        class="btn btn-danger reject" title="reject the rfq"
                                                        style="color:#FFF">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                @endif
                                              	@if ($record->status === 'Not Responsed')
                                                    <a href="{{ route('admins.rfqs.approve', $record->id) }}"
                                                       class="btn btn-danger reject" title="Mark the RFQ as responded"
                                                       style="color:#FFF">
                                                       <i class="fa fa-check"></i> <!-- Changed to fa-check for the right icon -->
                                                    </a>
                                                @endif
                                                <a class="btn btn-primary" title="show rfq details"
                                                    href="{{ route('admins.rfqs.show', $record->id) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
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
            $('#rfqs').DataTable({
                "order": [
                    [0, "asc"]
                ],
                "bSort": false

            });
        </script>
    @endpush
@endsection
