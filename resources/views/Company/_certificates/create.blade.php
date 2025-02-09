@extends('Company.index')
@section('certificates-active', 'm-menu__item--active m-menu__item--open')
@section('certificates-create-active', 'm-menu__item--active') 
@section('page-title', 'Certificates|Create') 
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
								<form method="POST" action="{{route('company.certificate.store')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="company_id" value="{{CompanyID()}}">
									<div class="m-portlet__body">
										<div class="form-group m-form__group row">
												<div class="col-lg-12">
													<input type="file"  value="{{old('filename')}}" name="filename" required="" class="form-control m-input" >
												@error('filename')
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
												<label>Name in english:</label>
												<input type="text" value="{{old('name_en')}}" name="name_en" required="" class="form-control m-input" placeholder="Certificate name in english...">
												@error('name_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-6">
												<label class="">Name in arabic:</label>
												<input type="text" value="{{old('name_ar')}}" name="name_ar"  required="" class="form-control m-input" placeholder="Certificate name in arabic...">
												@error('name_ar')
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
@push('script')
<script type="text/javascript">
	$(document).ready(function() {

      $(".btn-success").click(function(){ 
          var html = $(".clone").html();
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });

    });
</script>
@endpush
@endsection
 <!-- end:: Body -->

   