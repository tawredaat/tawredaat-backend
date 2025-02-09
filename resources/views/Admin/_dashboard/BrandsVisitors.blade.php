@extends('Admin.index')
@section('dashboard-active', 'm-menu__item--active m-menu__item--open')
@section('brand-visit-active', 'm-menu__item--active') 
@section('page-title', 'brand|Visitors')
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
                   	Brands 
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
										Visitors
										</h3>
									</div>
								</div>
							</div>
							<div class="m-portlet__body">
            					<div class="table-responsive">
										<!--begin: Datatable -->
										<table class="table table-striped- table-bordered table-hover table-checkable" id="brand-table">
											<thead>
												<tr>
													<th>User</th>
													<th>Date</th>
													<th>Time</th>
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
 $(document).ready(function () {
            // Initialize datatable
            $("#brand-table").dataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('get.brand.visitors')!!}',
                columns: [
                    {data: 'user', name: 'user'},
                    {data: 'date_added', name: 'date_added'},
                    {data: 'time_added', name: 'time_added'},
                ]
            });

        });
 </script>
@endpush
@endsection
 <!-- end:: Body -->

