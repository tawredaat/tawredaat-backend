@extends('Admin.index')
@section('companies-active', 'm-menu__item--active m-menu__item--open')
@section('companies-requests-active', 'm-menu__item--active') 
@section('page-title', 'Companies|Subscriptions|Requests') 
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
                                    Subscription requests
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{route('subscriptions.requests').'?type=renew'}}" class="btn @if(request()->type=='renew')btn-primary @else btn-light @endif m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-eye"></i>
                                            <span>Renew requests</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="m-portlet__nav-item">
                                    <a href="{{route('subscriptions.requests').'?type=new'}}" class="btn @if(request()->type !=='renew')btn-primary @else btn-light @endif m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-eye"></i>
                                            <span>New requests</span>
                                        </span>
                                    </a>
                                </li>                                      
                            </ul>
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
        $('#subscriptions').DataTable({
            "processing": true,
            "serverSide": true,
            'paging'      : true,
            'info'        : true,
            "ajax": "{{(request()->input('type') == 'renew')? route('subscriptions.renew'): route('subscriptions.new')}}",
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
                ,{

                    "mRender": function ( data, type, row )
                    {
                        return '<a href="#" class="btn btn-sm btn-success accept" data-content="'+ row['id']+'"><i class="fa fa-check"></i></a>';
                    },
                    sortable: false,
                    searchable: false,
                }
            ]
        }).ajax.reload();
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#subscriptions").on('click', '.accept', function(){
           Swal.fire({
             title: 'Are you sure to Accept this request?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Accept it!'
            }).then((result) => {
              if (result.value) {
                var content = $( this ).data( "content" );
                var urls = "{{ route('subscriptions.accept','id' ) }}";
                urls = urls.replace('id', content);
                $.ajax({
                    url: urls, 
                    method: 'POST',
                    data: {_token: CSRF_TOKEN, id: content,_method:"post"},
                    dataType: 'JSON',
                    success: function (data) { 
                       $("#subscriptions").DataTable().ajax.reload();
                      Swal.fire(
                      'Accepted!',
                      'Request has been accepted.',
                      'success'
                      )
                    }
                    ,error:function(data){
                    Swal.fire(
                      'failed!',
                      "cant't accept this request please try again later ",
                      'error'
                    )
                    }

                }); 
              }
            });
        });
    </script>
@endpush
@endsection
<!-- end:: Body -->
