@extends('Admin.index')
@section('notifications-active', 'm-menu__item--active m-menu__item--open')
@section('notifications-view-active', 'm-menu__item--active')
@section('page-title', 'Notifications|View')
@section('content')
@push('style')

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
@endpush
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
                        <div style="display: none;" class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">
                            <div class="m-alert__icon">
                                <i class="flaticon-exclamation m--font-brand"></i>
                            </div>
                        </div>
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
                                            <a href="{{route('notifications.create')}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                                <span>
                                                    <i class="la la-plus"></i>
                                                    <span>New notification</span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <div class="table-responsive">
                                    <!--begin: Datatable -->
                                    <table class="table table-striped- table-bordered table-hover table-checkable" id="notifications-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Message</th>
                                                <th>Sent to?</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @foreach($notifications as $notification)
                                                <tr id="tr-{{$notification->id}}">
                                                    <td>{{$loop->index+1}}</td>
                                                    <td>{{$notification->message}}</td>
                                                    <td>{{$notification->users?'Specific users':'General'}}</td>
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
    $(document).ready(function() {
        $("#notifications-table").dataTable({
            "order": [[0, "DESC"]],
        });
    });
</script>
@endpush
@endsection
 <!-- end:: Body -->

