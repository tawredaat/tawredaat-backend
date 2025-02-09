@extends('Company.index')
@section('branches-active', 'm-menu__item--active m-menu__item--open')
@section('branches-create-active', 'm-menu__item--active') 
@section('page-title', 'Branches|Create') 
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
								<form method="POST" action="{{route('company.branches.store')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="company_id" value="{{auth('company')->user()->id}}">
									<div class="m-portlet__body">
									<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Name in english:</label>
												<input type="text" value="{{old('name_en')}}" name="name_en" required="" class="form-control m-input" placeholder="Branch name in english...">
												@error('name_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-6">
												<label class="">Name in arabic:</label>
												<input type="text" value="{{old('name_ar')}}" name="name_ar"  required="" class="form-control m-input" placeholder="Branch name in arabic...">
												@error('name_ar')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
									</div>
									<div class="form-group m-form__group row">
											<div class="col-lg-6">
											<label class="">Address in english:</label>
											<input type="text" name="address_en" value="{{old('address_en')}}" placeholder="Address in english..." required="" class="form-control">
												@error('address_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>	
											<div class="col-lg-6">
												<label class="">Address in arabic:</label>
											<input type="text" name="address_ar" value="{{old('address_ar')}}" placeholder="Address in arabic..." required="" class="form-control">
												@error('address_ar')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
										</div>	
									</div>
									<div class="form-group m-form__group row">
											<div class="col-lg-12">
												<label>Map Location url:</label>
												<input type="text" value="{{old('location')}}" name="location"  required="" class="form-control m-input" placeholder="Map Location url...">
												@error('location')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
									</div>

									<div class="form-group m-form__group row">
										<div class="col-lg-4">
											 <label class="">Image:</label>
												<input type="file" name="image" class="form-control m-input" ><br>
												@error('image')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
										</div>
										<div class="col-lg-4">
												<label>ALT Image in english:</label>
												<input type="text" value="{{old('alt_en')}}" name="alt_en"  class="form-control m-input" placeholder="Alt image in english...">
												@error('alt_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
										</div>
										<div class="col-lg-4">
												<label class="">Alt Image in arabic:</label>
												<input type="text" value="{{old('alt_ar')}}" name="alt_ar"  placeholder="Alt image in arabic..." class="form-control m-input" >
												@error('alt_ar')
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

   