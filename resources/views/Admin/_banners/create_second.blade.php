@extends('Admin.index')
@section('banners-active', 'm-menu__item--active m-menu__item--open')
@section('banners-create-active', 'm-menu__item--active')
@section('page-title', 'Banners|Create')
@section('content')
<style>
::-webkit-file-upload-button {
  background-color: #5867dd;
  border: 1px solid #5867dd;
  border-radius: 5px;
  color: #fff;
  padding: 2px;

}
    .invalid-feedback {
        display: block;
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
												 {{$SubTitle}}
											</h3>
										</div>
									</div>
								</div>
								<!--begin::Form-->
								<form method="POST" action="{{route('banners.second.store')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
									@csrf
									<div class="m-portlet__body">
										<div class="form-group m-form__group row">
											<div class="col-lg-4">
												<label>Image Ar:</label>
												<input type="file" value="{{old('imgAr')}}"  name="imgAr" required="" class="form-control m-input">
												@error('imgAr')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>

											<div class="col-lg-4">
												<label>Image En:</label>
												<input type="file" value="{{old('imgEn')}}"  name="imgEn" required="" class="form-control m-input">
												@error('imgEn')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>

											<div class="col-lg-4">
												<label>Mobile Image Ar:</label>
												<input type="file" value="{{old('mobileimgAr')}}"  name="mobileimgAr" required="" class="form-control m-input">
												@error('mobileimgAr')
												<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
												@enderror
											</div>

											<div class="col-lg-4">
												<label>Mobile Image En:</label>
												<input type="file" value="{{old('mobileimgEn')}}"  name="mobileimgEn" required="" class="form-control m-input">
												@error('mobileimgEn')
												<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
												@enderror
											</div>

											<div class="col-lg-4">
												<label>ALt image in english:</label>
												<input type="text" value="{{old('altEN')}}"  name="altEN" required="" class="form-control m-input" placeholder="ALt image in english...">
												@error('altEN')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-4">
												<label class="">ALt text in arabic:</label>
												<input type="text" value="{{old('altAR')}}" name="altAR"  required="" class="form-control m-input"  placeholder="ALt image in arabic...">
												@error('altAR')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-12">
												<label class="">URL:</label>
												<input type="text" value="{{old('url')}}" name="url"  required="" class="form-control m-input" placeholder="URL...">
												@error('url')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
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
@endsection
 <!-- end:: Body -->

