@extends('Admin.index')
@section('brands-active', 'm-menu__item--active m-menu__item--open')
@section('brands-companies-view-active', 'm-menu__item--active')
@section('page-title', 'Brands|Companies|Requests') 
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
											{{$MainTitle}}
										</h3>
									</div>
								</div>
							</div>
							<div class="m-portlet__body">

								<!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="brands_datatable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Company</th>
                                    <th>Brand</th>
                                    <th>Brand-Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody id="categories_info">
                                @if(count($brands) > 0)
                                    @foreach ($brands as $brand)
                                      @if($brand->brand)
                                          <tr id="tr-{{$brand->brand->id}}">
                                              <td>{{ $loop->index+1 }}</td>
                                              <td>{{ $brand->company?$brand->company->name:'-'}}</td>
                                              <td>{{ $brand->brand?$brand->brand->name:'-'}}</td>
                                              <td>
                                                @if(count($brand::types($brand->brand_id ,$brand->company_id )))
                                                @foreach($brand::types($brand->brand_id ,$brand->company_id ) as $type)<span style="padding: 10px;margin: 5px"  class="badge badge-info">{{$type->type->name}}</span>@endforeach
                                                @else
                                                <span>'Not Selected'</span>
                                                @endif
                                              </td>
                                              <td id="status-{{$brand->id}}">
                                                @if($brand->approve==0)
                                                <span style="background-color: yellow;color: #000;padding: 5px;font-weight: bold;border-radius: 20%;">Not Selected
                                                </span>
                                                @elseif($brand->approve==1)
                                                <span style="background-color: blue;color: #fff;padding: 5px;font-weight: bold;border-radius: 20%;">Pending
                                                </span>
                                                @elseif($brand->approve==2)
                                                <span style="background-color: green;color: #fff;padding: 5px;font-weight: bold;border-radius: 20%;">Approved
                                                </span>
                                                @elseif($brand->approve==-1)
                                                <span style="background-color: red;color: #fff;padding: 5px;font-weight: bold;border-radius: 20%;">Rejected
                                                </span>
                                                @endif
                                              </td>
                                              <td id="actions-{{$brand->id}}">
                                              	@if($brand->approve == 1)
                                                <a title="Approve this request" style="color:#fff;font-size: 12px;margin:2px;" class="btn btn-success approve btn-sm" data-company="{{$brand->company_id}}" data-type="{{$brand->id}}" data-brand="{{$brand->brand_id}}"><i class="fa fa-check"></i></a>
                                                <a title="Reject this request" style="color:#fff;font-size: 12px;margin:2px;" class="btn btn-danger reject btn-sm" data-company="{{$brand->company_id}}" data-type="{{$brand->id}}" data-brand="{{$brand->brand_id}}"><i class="fa fa-times"></i></a>
                                                @elseif($brand->approve==2)
                                                    <span style="background-color: green;color: #fff;padding: 5px;font-weight: bold;border-radius: 20%;">Approved</span>
                                                @elseif($brand->approve==-1)
                                              	<span style="background-color: red;color: #fff;padding: 5px;font-weight: bold;border-radius: 20%;">Rejected</span>
                                                @endif
                                              </td>
                                          </tr>
                                      @endif
                                    @endforeach
                                @else
                                    <td colspan="7" class="text-center">There are no requests yet.</td>
                                @endif

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
    $('#brands_datatable').DataTable({"order": [[ 0, "desc" ]]});
        //approve brand company type
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //approve brand company type
        $("#brands_datatable").on('click', '.approve', function(){
           Swal.fire({
             title: 'Are you sure to approve this brand type?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
              if (result.value) {
                var brand_id = $( this ).data("brand");
                var company_id = $( this ).data("company");
                var type_id = $( this ).data("type");
                var urls = "{{ route('brand.approve.companyBrand') }}";
                $.ajax({
                    url: urls, 
                    method: 'POST',
                    data: {_token: CSRF_TOKEN, brand_id: brand_id,company_id: company_id,type_id:type_id,_method:"POST"},
                    dataType: 'JSON',
                    success: function (data) { 
                        Swal.fire(
                        'Approved!',
                        'Brand has been approved successfully!.',
                        'success'
                        );
                        $('#actions-'+data['type']).empty();
                        $('#actions-'+data['type']).html('<span style="background-color: green;color: #fff;padding: 5px;font-weight: bold;border-radius: 20%;">Approved</span>');
                        $('#status-'+data['type']).html('<span style="background-color: green;color: #fff;padding: 5px;font-weight: bold;border-radius: 20%;">Approved</span>');
                    }
                    ,error:function(data){
                    }

                }); 
              }
            });
        });
        //reject brand company type
        $("#brands_datatable").on('click', '.reject', function(){
           Swal.fire({
             title: 'Are you sure to reject this brand type?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reject it!'
            }).then((result) => {
              if (result.value) {
                var brand_id = $( this ).data("brand");
                var company_id = $( this ).data("company");
                var type_id = $( this ).data("type");
                var urls = "{{ route('brand.reject.companyBrand') }}";
                $.ajax({
                    url: urls, 
                    method: 'POST',
                    data: {_token: CSRF_TOKEN, brand_id: brand_id,company_id: company_id,type_id:type_id,_method:"POST"},
                    dataType: 'JSON',
                    success: function (data) { 
                        Swal.fire(
                        'Rejected!',
                        'Brand has been rejected successfully!.',
                        'success'
                        );
                        $('#actions-'+data['type']).empty();
                        $('#actions-'+data['type']).html('<span style="background-color: red;color: #fff;padding: 5px;font-weight: bold;border-radius: 20%;">Rejected</span>');
                        $('#status-'+data['type']).html('<span style="background-color: red;color: #fff;padding: 5px;font-weight: bold;border-radius: 20%;">Rejected</span>');
                    }
                    ,error:function(data){
                    }

                }); 
              }
            });
        });
 </script>
@endpush
@endsection
 <!-- end:: Body -->

   