@extends('Company.index')
@section('areas-active', 'm-menu__item--active m-menu__item--open')
@section('content')
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
				<div class="m-grid__item m-grid__item--fluid m-wrapper">
				<div class="m-content">
					<div class="row">
						<div class="col-lg-12">
							<!--begin::Portlet-->
							<div class="m-portlet">
								<div class="m-portlet__head">
									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<span class="m-portlet__head-icon m--hide">
												<i class="la la-gear"></i>
											</span>
											<h3 class="m-portlet__head-text">
												{{$title}}
											</h3>
										</div>
									</div>
								</div>
								<!--begin::Form-->
								<form method="POST" action="{{route('company.areasOperations.update',$area->id)}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
									@csrf
									@method('put')
									<div class="m-portlet__body">
									<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Name in english:</label>
												<input type="text" value="{{$area->translate('en')->name}}" name="name_en" required="" class="form-control m-input" placeholder=" name in english">
											</div>
											<div class="col-lg-6">
												<label class="">Name in arabic:</label>
												<input type="text" value="{{$area->translate('ar')->name}}" name="name_ar"  required="" class="form-control m-input" placeholder="name in arabic">
											</div>
									</div>

									</div>
									<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
										<div class="m-form__actions m-form__actions--solid">
											<div class="row">
												<div class="col-lg-6">
												</div>
												<div class="col-lg-6 m--align-right">
													<button type="submit" class="btn btn-primary">Save</button>
												</div>
											</div>
										</div>
									</div>
								</form>
								<!--end::Form-->
							</div>
							<!--end::Portlet-->
						</div>
					</div>
				</div>
				</div>
            <!--End::Section-->
          </div>
        </div>
      </div>
 @section('script')
 <script type="text/javascript">
</script>
@endsection
@endsection
 <!-- end:: Body -->

   