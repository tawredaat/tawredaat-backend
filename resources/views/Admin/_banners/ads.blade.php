@extends('Admin.index')
@section('banners-active', 'm-menu__item--active m-menu__item--open')
@section('banners-ads-active', 'm-menu__item--active')
@section('page-title', 'Banners|Control|Ads')
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
								<form method="POST" action="{{route('ads.banner.store')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
									@csrf
								<div class="m-portlet__body">
									<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>First advertising image in english :</label>
												<input type="file"   name="firstImage_en" required="" class="form-control m-input">
												@error('firstImage_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>

                                        <div class="col-lg-6">
                                            <label>First Mobile advertising image in english :</label>
                                            <input type="file"   name="mobileFirstImage_en" required="" class="form-control m-input">
                                            @error('mobileFirstImage_en')
                                            <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
                                            @enderror
                                        </div>
											<div class="col-lg-6">
												<label>First advertising image alt in english :</label>
												<input type="text" value="{{old('firstImageAlt_en')}}"  name="firstImageAlt_en" required="" class="form-control m-input" placeholder="First ALt image in english...">
												@error('firstImageAlt_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
									</div>
								<div class="m-portlet__body">
									<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>First advertising image in arabic :</label>
												<input type="file"   name="firstImage_ar" required="" class="form-control m-input">
												@error('firstImage_ar')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>

                                        <div class="col-lg-6">
                                            <label>First Mobile advertising image in arabic :</label>
                                            <input type="file"   name="mobileFirstImage_ar" required="" class="form-control m-input">
                                            @error('mobileFirstImage_ar')
                                            <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
                                            @enderror
                                        </div>

											<div class="col-lg-6">
												<label>First advertising image alt in arabic :</label>
												<input type="text" value="{{old('firstImageAlt_ar')}}"  name="firstImageAlt_ar" required="" class="form-control m-input" placeholder="First ALt image in arabic...">
												@error('firstImageAlt_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
									</div>
								<div class="m-portlet__body">
									<div class="form-group m-form__group row">
											<div class="col-lg-12">
												<label>First advertising url :</label>
												<input type="text" value="{{old('firstURL')}}"  name="firstURL" required="" class="form-control m-input">
												@error('firstURL')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
									</div>
									<hr>
							<div class="m-portlet__body">
									<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Second Mobile advertising image in english :</label>
												<input type="file"   name="mobileSecondImage_en" required="" class="form-control m-input">
												@error('mobileSecondImage_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-6">
												<label>Second advertising image alt in english :</label>
												<input type="text" value="{{old('secondImageAlt_en')}}"  name="secondImageAlt_en" required="" class="form-control m-input" placeholder="Second ALt image in english...">
												@error('secondImageAlt_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
									</div>
								<div class="m-portlet__body">
									<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Second Mobile advertising image in arabic :</label>
												<input type="file"   name="mobileSecondImage_ar" required="" class="form-control m-input">
												@error('mobileSecondImage_ar')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-6">
												<label>Second advertising image alt in arabic :</label>
												<input type="text" value="{{old('secondImageAlt_ar')}}"  name="secondImageAlt_ar" required="" class="form-control m-input" placeholder="Second ALt image in arabic...">
												@error('secondImageAlt_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
									</div>
								<div class="m-portlet__body">
									<div class="form-group m-form__group row">
											<div class="col-lg-12">
												<label>Second advertising url :</label>
												<input type="text" value="{{old('secondURL')}}"  name="secondURL" required="" class="form-control m-input">
												@error('secondURL')
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

