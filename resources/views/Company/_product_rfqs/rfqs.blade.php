@extends('Company.index')
@section('productrfq-active', 'm-menu__item--active m-menu__item--open')
@section('productrfq-show-active', 'm-menu__item--active')
@section('page-title', 'Rfqs|View')
@section('content')
    <style type="text/css">
        .swal2-confirm{
            background: #3085d6 !important;
        }
        .swal2-cancel{
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

                                </li>
                            </ul>
                        </div>
                    </div>





                    <div class="m-portlet__body">
                        <div class="table-responsive">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="admins">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Product Name</th>
                                    <th>Created at</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($product_rfqs as $productrfq)
                                <tr id="tr-{{$productrfq->id}}">
                                    <td>{{$productrfq->id}}</td>
                                    <td>{{$productrfq->user->name}}</td>
                                    <td>{{$productrfq->companyProduct->product->name}}</td>
                                    <td>{{$productrfq->created_at}}</td>
                                    <td>
                                        @if($productrfq->message == null)
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal-{{$productrfq->id}}">
                                                Respond
                                            </button>
                                        @else
                                            Responded
                                        @endif

                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal-{{$productrfq->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{route('company.product.respondrfqs',$productrfq->id)}}">
                                                    @csrf

                                                    <div class="form-group">
                                                        <label for="exampleFormControlTextarea1">Response</label>
                                                        <textarea name="response" class="form-control" id="exampleFormControlTextarea1" rows="4"></textarea>
                                                    </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

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
            $('#admins').DataTable({
                "order": [[ 0, "desc" ]], //or asc 
            });
            //Delete admin data
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#admins").on('click', '.delete', function(){
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
                        var content = $( this ).data( "content" );
                        var urls = "{{ route('company.admins.destroy','id' ) }}";
                        urls = urls.replace('id', content);
                        $.ajax({
                            url: urls,
                            method: 'POST',
                            data: {_token: CSRF_TOKEN, id: content,_method:"delete"},
                            dataType: 'JSON',
                            beforeSend: function(){
                            },
                            success: function (data) {
                                $("#admins").DataTable().ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'admin has been deleted.',
                                    'success'
                                )
                            }
                            ,error:function(data){
                                $("#admins").DataTable().ajax.reload();
                            }

                        });
                    }
                });
            });

        </script>
    @endpush
@endsection
<!-- end:: Body -->

