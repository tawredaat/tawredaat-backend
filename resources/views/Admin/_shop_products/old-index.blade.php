@extends('Admin.index')
@section('shop-products-active', 'm-menu__item--active m-menu__item--open')
@section('shop-products-view-active', 'm-menu__item--active')
@section('page-title', 'Shop | Products | View')
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
                                            <a href="{{route('shop.products.create')}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                                <span>
                                                    <i class="la la-plus"></i>
                                                    <span>New product</span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                            <div class="table-responsive">
                                <!--begin: Datatable -->
                                <table class="table table-striped- table-bordered table-hover table-checkable" id="products">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Image</th>
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
  $('#products').DataTable({
       "processing": true,
       "serverSide": true,
        'paging'      : true,
        'info'        : true,
         "order":[[0,"desc"]],
       "ajax": "{{ route('shop.product.products') }}",
       "columns":[
          {
              "data": "id"
             },
             {
              "data": "name"
             },
             {
              "mRender": function ( data, type, row )
              {
                var url = "{{ asset('storage/photo###') }}";
                url = url.replace('photo###', row['image']);
                return '<img width="100" alt="'+row['alt_en']+'" src="'+url+'">';
              },
               sortable: false,
               searchable: false,
            },
            {
              "mRender": function ( data, type, row )
              {
                var url = "{{ route('shop.products.edit','id' ) }}";
                var urlImages= "{{ route('shop.products.images','id') }}";
                url = url.replace('id', row['id']);
                urlImages = urlImages.replace('id', row['id']);
                return '<a class="btn btn-primary"  href='+urlImages+'><i class="far fa-images"></i></a> <a class="btn btn-primary"  href='+url+'><i class="fa fa-edit"></i></a> <a style="color:#fff" class="btn btn-danger delete" data-content="'+ row['id']+'"><i class="fa fa-trash"></i></a>';
              },
               sortable: false,
               searchable: false,
            }
        ]
    }).ajax.reload();

            //Delete product data
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#products").on('click', '.delete', function(){
           Swal.fire({
             title: 'Are you sure to delete this product?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                var content = $( this ).data( "content" );
                var urls = "{{ route('shop.products.destroy','id' ) }}";
                urls = urls.replace('id', content);
                $.ajax({
                    url: urls,
                    method: 'POST',
                    data: {_token: CSRF_TOKEN, id: content,_method:"delete"},
                    dataType: 'JSON',
                    beforeSend: function(){
                    },
                    success: function (data) {
                       $("#products").DataTable().ajax.reload();
                        Swal.fire(
                    'Deleted!',
                    'product data has been deleted.',
                    'success'
                    )
                    }
                    ,error:function(data){
                       $("#products").DataTable().ajax.reload();
                    }

                });
              }
            });
        });

 </script>
@endpush
@endsection
 <!-- end:: Body -->

