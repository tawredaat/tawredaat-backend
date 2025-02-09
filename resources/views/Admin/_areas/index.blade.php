@extends('Admin.index')
@section('areas-active', 'm-menu__item--active m-menu__item--open')
@section('areas-view-active', 'm-menu__item--active') 
@section('page-title', 'Areas|View')
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
											<a href="{{route('areas.create')}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la la-plus"></i>
													<span>New Area</span>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="m-portlet__body">
            <div class="table-responsive">
								<!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="areas">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
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
  $('#areas').DataTable({
       "processing": true,
       "serverSide": true,
        'paging'      : true,
        'info'        : true,
       "ajax": "{{ route('area.areas') }}",
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
                var url = "{{ route('areas.edit','id' ) }}";
                url = url.replace('id', row['id']);
                return '<a class="btn btn-primary"  href='+url+'><i class="fa fa-edit"></i></a> <a style="color:#fff" class="btn btn-danger delete" data-content="'+ row['id']+'"><i class="fa fa-trash"></i></a>';
              },
               sortable: false,
               searchable: false,
            }
        ]
    }).ajax.reload();

            //Delete area data
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#areas").on('click', '.delete', function(){
           Swal.fire({
             title: 'Are you sure to delete this area data?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                var content = $( this ).data( "content" );
                var urls = "{{ route('areas.destroy','id' ) }}";
                urls = urls.replace('id', content);
                $.ajax({
                    url: urls, 
                    method: 'POST',
                    data: {_token: CSRF_TOKEN, id: content,_method:"delete"},
                    dataType: 'JSON',
                    beforeSend: function(){
                    },
                    success: function (data) { 
                       $("#areas").DataTable().ajax.reload();
                        Swal.fire(
                    'Deleted!',
                    'area has been deleted.',
                    'success'
                    )
                    }
                    ,error:function(data){
                       $("#areas").DataTable().ajax.reload();
                    }

                }); 
              }
            });
        });

 </script>
@endpush
@endsection
 <!-- end:: Body -->

