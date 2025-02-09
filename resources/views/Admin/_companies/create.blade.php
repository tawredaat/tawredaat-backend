@extends('Admin.index')
@section('companies-active', 'm-menu__item--active m-menu__item--open')
@section('companies-create-active', 'm-menu__item--active')
@section('page-title', 'Companies|Create')
@section('content')

<style type="text/css">
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
.bootstrap-tagsinput {
    background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    display: block;
    padding: 4px 6px;
    color: #555;
    vertical-align: middle;
    border-radius: 4px;
    max-width: 100%;
    line-height: 22px;
    cursor: text;
}
.bootstrap-tagsinput input {
    border: none;
    box-shadow: none;
    outline: none;
    background-color: transparent;
    padding: 0 6px;
    margin: 0;
    width: auto;
    max-width: inherit;
}
.tag{
    background: #888;
    padding:2px;
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
								<form method="POST" action="{{route('companies.store')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
									@csrf
									<div class="m-portlet__body">
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Name in english:</label>
												<input type="text" value="{{old('name_en')}}" name="name_en" required="" class="form-control m-input" placeholder="Name in english...">
												@error('name_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-6">
												<label class="">Name in arabic:</label>
												<input type="text" value="{{old('name_ar')}}" name="name_ar"  required="" class="form-control m-input" placeholder="name in arabic...">
												@error('name_ar')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
									<div class="form-group m-form__group row">
										<div class="col-lg-3">
											<label class="">Cover:</label>
												<input type="file" value="{{old('cover')}}" name="cover"  required="" class="form-control m-input" >
												@error('cover')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
										</div>

                                        <div class="col-lg-3">
                                            <label class="">Mobile Cover:</label>
                                            <input type="file" value="{{old('mobilecover')}}" name="mobilecover"  required="" class="form-control m-input" >
                                            @error('mobilecover')
                                            <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
                                            @enderror
                                        </div>

										<div class="col-lg-3">
											<label class="">Logo:</label>
												<input type="file" value="{{old('logo')}}" name="logo"  required="" class="form-control m-input" >
												@error('logo')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
										</div>
										<div class="col-lg-3">
												<label>ALT logo in english:</label>
												<input type="text" value="{{old('alt_en')}}" name="alt_en"  class="form-control m-input" placeholder="alt log in english...">
												@error('alt_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
										</div>
										<div class="col-lg-3">
												<label class="">Alt logo in arabic:</label>
												<input type="text" value="{{old('alt_ar')}}" name="alt_ar"  placeholder="alt log in arabic..." class="form-control m-input" >
												@error('alt_ar')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
										</div>
									 </div>
											<div class="form-group m-form__group row">
											<div class="col-lg-4">
												<label>Establish date:</label>
												<input type="date" value="{{old('date')}}" name="date" class="form-control m-input" placeholder="Establish date">
												@error('date')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-4">
												<label>Title in english:</label>
												<input type="text" value="{{old('title_en')}}" class="form-control" name="title_en" placeholder="Title in english">
												@error('title_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-4">
												<label>Title in arabic:</label>
												<input type="text" value="{{old('title_ar')}}" class="form-control" name="title_ar" placeholder="Title in arabic">
												@error('title_ar')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-3">
												<label>Phone number:</label>
												<input type="text" value="{{old('company_phone')}}" name="company_phone" placeholder="Company phone number..." class="form-control m-input">
												@error('company_phone')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-3">
												<label>Email:</label>
												<input type="email" required name="company_email" value="{{old('company_email')}}" placeholder="Company email..."  class="form-control m-input">
												@error('company_email')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-3">
												<label>Address in english:</label>
												<input type="text" value="{{old('company_address_en')}}" class="form-control" name="company_address_en" placeholder="Address in english...">
												@error('company_address_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-3">
												<label>Address in arabic:</label>
												<input type="text" value="{{old('company_address_ar')}}" class="form-control" name="company_address_ar" placeholder="company address ar">
												@error('company_address_ar')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-4">
												<label>Primary Phone:</label>
												<input type="text" value="{{old('pri_contact_phone')}}" name="pri_contact_phone"  placeholder="Primary contact phone" class="form-control m-input">
												@error('pri_contact_phone')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-4">
												<label>Primary Email:</label>
												<input type="email" value="{{old('pri_contact_email')}}" required="" name="pri_contact_email"  placeholder="primary contact email" class="form-control m-input">
												@error('pri_contact_email')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
												<div class="col-lg-4">
												<label>Primary name:</label>
												<input type="text" value="{{ old('pri_contact_name') }}" name="pri_contact_name"  placeholder="primary contact name" class="form-control m-input">
											@error('pri_contact_name')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-4">
												<label>Sales mobile number:</label>
												<input type="text" value="{{old('sales_mobile')}}" class="form-control" name="sales_mobile" placeholder="Sales mobile number">
											@error('sales_mobile')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-4">
												<label>Brochure PDF:</label>
												<input type="file" value="{{old('brochure')}}" name="brochure"  class="form-control m-input">
											@error('brochure')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-4">
												<label>Price Lists PDF:</label>
												<input type="file" value="{{old('price_lists')}}" class="form-control" name="price_lists">
											@error('price_lists')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
									<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Description in English:</label>
												<textarea id="descri_en" class="form-control" name="descri_en" placeholder="Description in english...">{{old('descri_en')}}</textarea>
												@error('descri_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-6">
												<label>Description in Arabic:</label>
												<textarea id="descri_ar" class="form-control" name="descri_ar" placeholder="Description in arabic">{{old('descri_ar')}}</textarea>
												@error('descri_ar')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
									</div>
									<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Description Meta in English:</label>
												<textarea class="form-control" name="descri_meta_en" placeholder="Description Meta English">{{old('descri_meta_en')}}</textarea>
												@error('descri_meta_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-6">
												<label>Description Meta in Arabic:</label>
												<textarea class="form-control" name="descri_meta_ar" placeholder="Description Meta Arabic">{{old('descri_meta_ar')}}</textarea>
												@error('descri_meta_ar')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
									</div>
									<div class="form-group m-form__group row">
										<div class="col-lg-6">
											<label>Keywords Meta in english:</label>
		 							 	 <input type="text" name="keyword_meta_en"  id="keyword_meta_en" placeholder="Keywords Meta in English" value="{{ old('keyword_meta_en') }}">
											@error('keyword_meta_en')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
										</div>
										<div class="col-lg-6">
											<label>Keywords Meta in arabic:</label>
		 							 	 <input type="text" name="keyword_meta_ar"  id="keyword_meta_ar" placeholder="Keywords Meta in arabic" value="{{ old('keyword_meta_ar') }}">
											@error('keyword_meta_ar')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
										</div>
									</div>
									<div class="form-group m-form__group row">

											<div class="col-lg-6">
												<label>Keywords in english:</label>
											 	<input type="text" name="keyword_en"  id="keyword_en" placeholder="Keywords English" value="{{ old('keyword_en') }}">
												@error('keyword_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-6">
												<label>Keywords in arabic:</label>
												<input type="text" name="keyword_ar"  id="keyword_ar" placeholder="Keywords English" value="{{ old('keyword_ar') }}">
												@error('keyword_ar')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
									</div>

											<div class="form-group m-form__group row"><div class="col-lg-4">
												<label>Map link:</label>
												<input type="text" value="{{old('map')}}" name="map"  placeholder="Map link..." class="form-control m-input">
												@error('map')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-4">
												<label>Facebook link:</label>
												<input type="text" value="{{old('link')}}" name="facebook"  placeholder="Facebook link..." class="form-control m-input">
												@error('facebook')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
												<div class="col-lg-4">
												<label>Instgram link:</label>
												<input type="text" value="{{old('insta')}}" name="insta"  placeholder="instgram link" class="form-control m-input">
												@error('insta')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-4">
												<label>Twitter link:</label>
												<input type="text" value="{{old('twitter')}}" name="twitter"  placeholder="twitter link" class="form-control m-input">
												@error('twitter')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-4">
												<label>Youtube link:</label>
												<input type="text" value="{{old('youtube')}}" name="youtube" placeholder="youtube  link" class="form-control m-input">
												@error('youtube')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
												<div class="col-lg-4">
												<label>Linkedin link:</label>
												<input type="text" value="{{old('linkedin')}}" name="linkedin" placeholder="linkedin  link" class="form-control m-input">
												@error('linkedin')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
																				<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Products Page Title  in english:</label>
												<input   class="form-control" name="products_title_en" placeholder="Products title english..." value="{{ old('products_title_en') }}">
												@error('products_title_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Products Page Title  in arabic:</label>
												<input   class="form-control" name="products_title_ar" placeholder="Products title arabic..." value="{{ old('products_title_ar') }}">
												@error('products_title_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Products Page Description in English:</label>
												<textarea id="products_description_en" class="form-control" name="products_description_en" placeholder="Products Description in english...">{{ old('products_description_en') }}</textarea>
												@error('products_description_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Products Page Description in Arabic:</label>
												<textarea id="products_description_ar" class="form-control" name="products_description_ar" placeholder="Products Description in arabic...">{{ old('products_description_ar') }}</textarea>
												@error('products_description_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Products Keywords in english:</label>
												<input id="products_keywords_en" data-role="tagsinput" class="form-control" name="products_keywords_en" placeholder="Products keywords english..." value="{{ old('products_keywords_en') }}">
												@error('products_keywords_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Products Keywords in arabc:</label>
												<input id="products_keywords_ar" data-role="tagsinput" class="form-control" name="products_keywords_ar" placeholder="Products keywords arabic..." value="{{ old('products_keywords_ar') }}">
												@error('products_keywords_ar')
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
	  $('#descri_ar').summernote({
        tabsize: 2,
        height: 150
      });
  	$('#descri_en').summernote({
        tabsize: 2,
        height: 150
      });
  	$('#keyword_meta_en,#keyword_meta_ar, #keyword_en,#products_keywords_ar,#products_keywords_en').tagsinput({
        confirmKeys: [13, 188]
      });
  	$('#keyword_ar').tagsinput({
        confirmKeys: [13, 188]
      });
	});
</script>
@endpush
@endsection
 <!-- end:: Body -->

