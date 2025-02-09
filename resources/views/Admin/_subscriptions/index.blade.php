@extends('Admin.index')
@section('subscriptions-active', 'm-menu__item--active m-menu__item--open')
@section('subscriptions-view-active', 'm-menu__item--active') 
@section('page-title', 'Subscriptions|View') 
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
                                    <a href="{{route('subscriptions.create')}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                                <span>
                                                    <i class="la la-plus"></i>
                                                    <span>New Subscription</span>
                                                </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="subscriptions">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Duration in Month</th>
                                <th>Price</th>
                                <th>Rank Points</th>
                                {{--<th>visibility</th>--}}
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
            "ajax": "{{ route('subscriptions.subscriptions') }}",
            "columns":[
                {
                    "data": "id"
                },
                {
                    "data": "name"
                },
                {
                    "data": "durationInMonth"
                },
                {
                    "data": "price"
                },
                {
                    "data": "rank_points"
                },
                {
                    "mRender": function ( data, type, row )
                    {
                        var url = "{{ route('subscriptions.edit','id' ) }}";
                        url = url.replace('id', row['id']);
                        return '<a class="btn btn-primary"  href='+url+'><i class="fa fa-edit"></i></a> <a style="color:#fff" class="btn btn-danger delete" data-content="'+ row['id']+'"><i class="fa fa-trash"></i></a>';
                    },
                    sortable: false,
                    searchable: false,
                }
            ]
        }).ajax.reload();


        //Delete Subscription data
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#subscriptions").on('click', '.delete', function(){
            Swal.fire({
                title: 'Are you sure to delete this subscription?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var content = $( this ).data( "content" );
                    var urls = "{{ route('subscriptions.destroy','id' ) }}";
                    urls = urls.replace('id', content);
                    $.ajax({
                        url: urls,
                        method: 'POST',
                        data: {_token: CSRF_TOKEN, id: content,_method:"delete"},
                        dataType: 'JSON',
                        beforeSend: function(){
                        },
                        success: function (data) {
                            $("#subscriptions").DataTable().ajax.reload();
                            Swal.fire(
                                'Deleted!',
                                'type of subscription has been deleted.',
                                'success'
                            )
                        }
                        ,error:function(data){
                            $("#subscriptions").DataTable().ajax.reload();
                        }

                    });
                }
            });
        });

    </script>
@endpush
@endsection
<!-- end:: Body -->
