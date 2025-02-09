@extends('Admin.index')
@section('brands-active', 'm-menu__item--active m-menu__item--open')
@section('brands-create-active', 'm-menu__item--active')
@section('page-title', 'Brands|Create')
@section('content')

<style type="text/css">

::-webkit-file-upload-button {
  background-color: #5867dd;
  border: 1px solid #5867dd;
  border-radius: 5px;
  color: #fff;
  padding: 2px;

}
.invalid-feedback{
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
								<form method="POST" action="{{route('brands.store')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
									@csrf
									<div class="m-portlet__body">
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Name in english:</label>
												<input type="text" value="{{ old('name_en') }}" name="name_en" required="" class="form-control m-input" placeholder="Name in english...">
									       	 @error('name_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
											</div>
											<div class="col-lg-6">
												<label class="">Name in arabic:</label>
												<input type="text" value="{{ old('name_ar') }}" name="name_ar"  required="" class="form-control m-input" placeholder="Name in arabic...">
									       	 @error('name_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
											</div>
										</div>

										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Title in english:</label>
												<input type="text" value="{{ old('title_en') }}" class="form-control" name="title_en" placeholder="Title in english...">
											 @error('title_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
											</div>
											<div class="col-lg-6">
												<label>Title in arabic:</label>
												<input type="text" value="{{ old('title_ar') }}" class="form-control" name="title_ar" placeholder="Title in arabic...">
											 @error('title_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
											<label class="">Image:</label>
												<input type="file" name="image"  required="" class="form-control m-input" >
											 @error('image')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
											</div>


                                            <div class="col-lg-6">
                                                <label class="">Mobile Image:</label>
                                                <input type="file" name="mobileimg"  required="" class="form-control m-input" >
                                                @error('mobileimg')
                                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>

											<div class="col-lg-6">
											<label class="">PDF:</label>
												<input type="file" name="pdf" class="form-control m-input" >
											 @error('pdf')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>ALT image in english:</label>
												<input type="text" value="{{ old('alt_en') }}" name="alt_en"  class="form-control m-input" placeholder="Alt image in english...">
											@error('alt_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
											</div>
											<div class="col-lg-6">
												<label class="">Alt image in arabic:</label>
												<input type="text" name="alt_ar" value="{{ old('alt_ar') }}"   class="form-control m-input" placeholder="Alt image in arabic..." >
											@error('alt_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
											</div>
										</div>

										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>English Keywords:</label>
												<input id="keywords_en" data-role="tagsinput" class="form-control" name="keywords_en" placeholder="Keywords in english..." value="{{ old('keywords_en') }}">
											@error('keywords_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
											</div>
											<div class="col-lg-6">
												<label>Arabic Keywords:</label>
												<input id="keywords_ar" data-role="tagsinput" class="form-control" name="keywords_ar" placeholder="Keywords in arabic..." value="{{ old('keywords_ar') }}">
											@error('keywords_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Keywords Meta in english:</label>
												<input id="keywords_meta_en" data-role="tagsinput" class="form-control" name="keywords_meta_en" placeholder="Keywords Meta..." value="{{ old('keywords_meta_en') }}">
												@error('keywords_meta_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Keywords Meta in arabic:</label>
												<input id="keywords_meta_ar" data-role="tagsinput" class="form-control" name="keywords_meta_ar" placeholder="Keywords Meta..." value="{{ old('keywords_meta_ar') }}">
												@error('keywords_meta_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Description in English:</label>
												<textarea id="description_en" class="form-control" name="description_en" placeholder="Description in english...">{{ old('description_en') }}</textarea>
												@error('description_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Description in Arabic:</label>
												<textarea id="description_ar" class="form-control" name="description_ar" placeholder="Description in arabic">{{ old('description_ar') }}</textarea>
												@error('description_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Description Meta in English:</label>
												<textarea class="form-control" name="description_meta_en" placeholder="Description meta in english...">{{ old('description_meta_en') }}</textarea>
												@error('description_meta_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Description Meta in Arabic:</label>
												<textarea class="form-control" name="description_meta_ar" placeholder="Description meta in arabic...">{{ old('description_meta_ar') }}</textarea>
												@error('description_meta_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Country</label>
												<select class="form-control m-input" name="country_id"  required>
													@foreach($countries as $country)
												  		<option @if(old('country_id') == $country->id) selected @endif  value="{{ $country->id }}">{{ $country->name }}</option>
												  	@endforeach
												</select>
												@error('country_id')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                           	 	@enderror
											</div>
											<div class="col-lg-6">
												<label>Categories</label>
												<select class="form-control m-input js-example-basic-multiple" name="categories[]" multiple="multiple" required>
													@foreach($level3Categories as $category)
												  		<option @if(in_array($category->id, old('categories',[]))) selected @endif  value="{{ $category->id }}">{{ $category->name }} </option>
												  	@endforeach
												</select>
                                             @if($errors->has('categories.*'))
                                                     <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('categories.*') }}</strong></span>
                                             @endif
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
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Distributors Page Title  in english:</label>
												<input   class="form-control" name="distributors_title_en" placeholder="Distributors title english..." value="{{ old('distributors_title_en') }}">
												@error('distributors_title_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Distributors Page Title  in arabic:</label>
												<input   class="form-control" name="distributors_title_ar" placeholder="Distributors title arabic..." value="{{ old('distributors_title_ar') }}">
												@error('distributors_title_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Distributors Page Description in English:</label>
												<textarea id="distributors_description_en" class="form-control" name="distributors_description_en" placeholder="Distributors Description in english...">{{ old('distributors_description_en') }}</textarea>
												@error('distributors_description_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Distributors Page Description in Arabic:</label>
												<textarea id="distributors_description_ar" class="form-control" name="distributors_description_ar" placeholder="Distributors Description in arabic...">{{ old('distributors_description_ar') }}</textarea>
												@error('distributors_description_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Distributors Keywords in english:</label>
												<input id="distributors_keywords_en" data-role="tagsinput" class="form-control" name="distributors_keywords_en" placeholder="Distributors keywords english..." value="{{ old('distributors_keywords_en') }}">
												@error('distributors_keywords_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Distributors Keywords in arabc:</label>
												<input id="distributors_keywords_ar" data-role="tagsinput" class="form-control" name="distributors_keywords_ar" placeholder="Distributors keywords arabic..." value="{{ old('distributors_keywords_ar') }}">
												@error('distributors_keywords_ar')
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
    	$('.js-example-basic-multiple').select2();
	  $('#description_en').summernote({
        tabsize: 2,
        height: 150
      });
  	$('#description_ar').summernote({
        tabsize: 2,
        height: 150
      });

	});
     $('#keywords_en, #keywords_ar, #keywords_meta_en,#keywords_meta_ar,#products_keywords_ar,#products_keywords_en,#distributors_keywords_ar,#distributors_keywords_en').tagsinput({
        confirmKeys: [13, 188]
      });

      $('.bootstrap-tagsinput').on('keypress', function(e){
        if (e.keyCode == 13){
          e.keyCode = 188;
          e.preventDefault();
        };
      });
</script>
@endpush
@endsection
 <!-- end:: Body -->

