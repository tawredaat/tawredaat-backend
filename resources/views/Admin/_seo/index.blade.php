@extends('Admin.index')
@section('seo-active', 'm-menu__item--active m-menu__item--open')
@section('seo-view-active', 'm-menu__item--active') 
@section('page-title', 'SEO|View')
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
							</div>
							<div class="m-portlet__body">
            <div class="table-responsive">
								<!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="cities">
									<thead>
										<tr>
											<th>#</th>
											<th>Page Name</th>
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
  $('#cities').DataTable({
       "processing": true,
       "serverSide": true,
        'paging'      : true,
        'info'        : true,
       "ajax": "{{ route('seo.all') }}",
       "columns":[
          { 
              "data": "id"
             },
            { 
              "data": "page_name"
             },
            {
              "mRender": function ( data, type, row ) 
              {
                var url = "{{ route('seo.edit','id' ) }}";
                url = url.replace('id', row['id']);
                return '<a class="btn btn-primary"  href='+url+'><i class="fa fa-edit"></i></a>';
              },
               sortable: false,
               searchable: false,
            }
        ]
    }).ajax.reload();

 </script>
@endpush
@endsection
 <!-- end:: Body -->

