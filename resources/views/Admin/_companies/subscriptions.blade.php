@extends('Admin.index')
@section('companies-active', 'm-menu__item--active m-menu__item--open')

@if(request()->input('type')=='expire')
   @section('companies-expired-active', 'm-menu__item--active') 
   @section('page-title', 'Companies|Subscriptions|Expired')
@elseif(request()->input('type')=='active')
    @section('companies-subscriped-active', 'm-menu__item--active') 
   @section('page-title', 'Companies|Subscriptions|Subscribed')
@endif
@section('content')
    <style type="text/css">
        .swal2-confirm{
            background: #3085d6 !important;
            border: #3085d6 !important;
        }
        .swal2-cancel{
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
                                    @if(request()->input('type')=='expire')
                                       Expired Companies
                                    @else
                                     Subscribed Companies
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
  <div class="table-responsive">
                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="subscriptions">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Company</th>
                                <th>Subscription</th>
                                <th>End Date</th>
                                <th>Price</th>
                                <th>Rank Points</th>
                                  @if((request()->input('type') != 'expire'))
                                <th>Actions</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
@include('Admin._companies.subscriptionsModals')
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>

@push('script')
    <script type="text/javascript">
        $('#subscriptions').DataTable({
            "processing": true,
            "serverSide": true,
            'paging'      : true,
            'info'        : true,
            "ajax": "{{(request()->input('type') == 'expire')? route('subscriptions.expire'): route('subscriptions.active')}}",
            "columns":[
                {
                    "data": "id"
                },
                {
                    "mRender": function ( data, type, row )
                    {
                        return row['company']['name']
                    }
                },
                {
                    "mRender": function ( data, type, row )
                    {
                        return row['subscription']['name']
                    }
                },
                {
                    "mRender": function ( data, type, row )
                    {
                        return row['end_date']
                    }
                },
                {
                    "data": "price"
                },
                {
                    "data": "rank_points"
                }
                @if((request()->input('type') != 'expire'))
                ,{

                    "mRender": function ( data, type, row )
                    {
                        // var url = "{{ route('subscriptions.edit','id' ) }}";
                        // url = url.replace('id', row['id']);
                      
                        return '<a style="color:#fff;font-size: 12px;margin: 2px;" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter'+row['id']+'"><i class="fa fa-edit"></i></a>';
                    },
                    sortable: false,
                    searchable: false,
                }
                @endif
            ]
        }).ajax.reload();

    </script>
@endpush
@endsection
<!-- end:: Body -->
