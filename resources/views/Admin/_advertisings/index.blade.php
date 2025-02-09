@extends('Admin.index')
@section('advertisings-active', 'm-menu__item--active m-menu__item--open')
@if(request()->input('type')=='category')
  @section('page-title', 'Ads|Category|View') 
  @section('advertisings-view-category-active', 'm-menu__item--active') 
@elseif(request()->input('type')=='company')
  @section('page-title', 'Ads|Company|View') 
  @section('advertisings-view-company-active', 'm-menu__item--active') 
@elseif(request()->input('type')=='brand')
  @section('page-title', 'Ads|Brand|View') 
  @section('advertisings-view-brand-active', 'm-menu__item--active') 
@elseif(request()->input('type')=='product')
  @section('page-title', 'Ads|Product|View') 
  @section('advertisings-view-product-active', 'm-menu__item--active') 
@endif

@section('content')
<style type="text/css">
  .swal2-confirm{
    background: #3085d6 !important;
    border: 1px solid #3085d6 !important;
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
              @if(request()->input('type')=='category')
                  Categories Ads
              @elseif(request()->input('type')=='company')
                  Companies Ads
              @elseif(request()->input('type')=='brand')
                  Brand Ads
              @elseif(request()->input('type')=='product')
                  Product Ads
              @endif
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
											{{ request()->input('type','company') }} advertisings
										</h3>
									</div>
								</div>
								<div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item">
											<a href="{{route('advertisings.create')}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la la-plus"></i>
													<span>New Advertising</span>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="m-portlet__body">
               <div class="table-responsive">
								<!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="advertisings">
									<thead>
										<tr>
											<th>#</th>
                      <th>Image</th>
                      <th>Alignment</th>
                      <th>URL</th>
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
  $('#advertisings').DataTable({
       "processing"   : true,
       "serverSide"   : true,
        'paging'      : true,
        'info'        : true,
       "ajax": "{{ route('advertising.advertisings').'?type='.request()->input('type','company') }}",
       "columns":[
          { 
              "data": "id"
             },
             {
              "mRender": function ( data, type, row ) 
              {
                var img = "{{ asset('storage/img###') }}";
                img = img.replace('img###', row['image']);
                return '<img width="100" src="'+img+'">';
              },
               sortable: false,
               searchable: false,
            },             
            { 
              "data": "alignment"
             },
              {
                "mRender": function ( data, type, row ) 
                { 
                  return"<a target='_blank' href='"+row['url']+"'>"+row['url']+"</a>"
                }
             },             
            {
              "mRender": function ( data, type, row ) 
              {
                var url = "{{ route('advertisings.edit','id' ).'?type='.request()->input('type','company') }}";
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

