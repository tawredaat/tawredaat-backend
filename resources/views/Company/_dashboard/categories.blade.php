@extends('Company.index')
@section('dashboard-active', 'm-menu__item--active m-menu__item--open')
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
											{{$title}}
										</h3>
									</div>
								</div>
							</div>
							<div class="m-portlet__body">

								<!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="categories">
									<thead>
										<tr>
										  <th>Category </th>
										</tr>
									</thead>
									<tbody>
                    @foreach($categories as $category)
                      <tr>
                      <th>{{$category->name}}</th>
                      </tr>
                      @endforeach
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
        </div>
      </div>
 @section('script')
 <script type="text/javascript">
  $('#categories').DataTable();
 </script>
@endsection
@endsection
 <!-- end:: Body -->

   