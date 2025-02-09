@extends('Admin.index')
@section('companies-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Companies|Edit')
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

    .tag {
        background: #888;
        padding: 2px;
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
                                <form method="POST" action="{{route('companies.update',$company->id)}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
                                    @method('put') @csrf
                                    <div class="m-portlet__body">
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Name in english:</label>
                                                <input type="text" value="{{ old('name_en')? old('name_en'):$company->translate('en')->name }}" name="name_en" required="" class="form-control m-input" placeholder="Enter Name in english"> @error('name_en')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span> @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="">Name in arabic:</label>
                                                <input type="text" value="{{ old('name_ar')? old('name_ar'):$company->translate('ar')->name }}" name="name_ar" required="" class="form-control m-input" placeholder="name in arabic"> @error('name_ar')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span> @enderror
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                        <div class="col-lg-3">
                                            <label class="">Cover:</label>
                                                <input type="file" value="{{old('cover')}}" name="cover"  class="form-control m-input" >
                                                 @if($company->cover)
                                                <img alt="image-not-found" src="{{ asset('storage/'.$company->cover) }}" width="100">
                                                @endif
                                                @error('cover')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                        </div>


                                            <div class="col-lg-3">
                                                <label class="">Mobile Cover:</label>
                                                <input type="file" value="{{old('mobilecover')}}" name="mobilecover"  class="form-control m-input" >
                                                @if($company->mobileCover)
                                                    <img alt="image-not-found" src="{{ asset('storage/'.$company->mobileCover) }}" width="100">
                                                @endif
                                                @error('mobilecover')
                                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="">Logo:</label>
                                                <input type="file" name="logo" class="form-control m-input">
                                                <br>
                                                @if($company->logo)
                                                <img alt="image-not-found" src="{{ asset('storage/'.$company->logo) }}" width="80">
                                                @endif
                                                @error('logo')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span> @enderror
                                            </div>
                                            <div class="col-lg-3">
                                                <label>ALT logo in english:</label>
                                                <input type="text" value="{{ old('alt_en')? old('alt_en'):$company->translate('en')->alt }}" name="alt_en" class="form-control m-input" placeholder="alt log in english"> @error('alt_en')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span> @enderror
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="">Alt logo in arabic:</label>
                                                <input type="text" value="{{ old('alt_ar')? old('alt_ar'):$company->translate('ar')->alt}}" name="alt_ar" placeholder="alt log in arabic" class="form-control m-input"> @error('alt_ar')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-4">
                                                <label>Establish date:</label>
                                                <input type="date" name="date" value="{{ old('date')? old('date'):$company->date }}" class="form-control m-input" placeholder="Establish date"> @error('date')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Title in english:</label>
                                                <input type="text" value="{{ old('title_en')? old('title_en'):$company->translate('en')->title }}" class="form-control" name="title_en" placeholder="Title in english"> @error('title_en')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Title in arabic:</label>
                                                <input type="text" class="form-control" value="{{ old('title_ar')? old('title_ar'):$company->translate('ar')->title}}" name="title_ar" placeholder="Title in arabic"> @error('title_ar')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-3">
                                                <label>Phone number:</label>
                                                <input type="text" value="{{ old('company_phone')? old('company_phone'):$company->company_phone }}" name="company_phone" placeholder="company phone number" class="form-control m-input"> @error('company_phone')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Email:</label>
                                                <input type="email" value="{{ old('company_email')? old('company_email'):$company->company_email }}" name="company_email" placeholder="company email" class="form-control m-input"> @error('company_email')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Address in englis:</label>
                                                <input type="text" value="{{ old('company_address_en')? old('company_address_en'):$company->translate('en')->address }}" class="form-control" name="company_address_en" placeholder="company address en"> @error('company_address_en')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Address in arabic:</label>
                                                <input type="text" value="{{ old('company_address_ar')? old('company_address_ar'):$company->translate('ar')->address }}" class="form-control" name="company_address_ar" placeholder="company address ar"> @error('company_address_ar')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                                <div class="col-lg-4">
                                                    <label>Primary Phone:</label>
                                                    <input type="text" name="pri_contact_phone" placeholder="Primary contact phone" value="{{ old('pri_contact_phone')? old('pri_contact_phone'):$company->pri_contact_phone }}" class="form-control m-input"> @error('pri_contact_phone')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Primary Email:</label>
                                                    <input type="email" value="{{ old('pri_contact_email')? old('pri_contact_email'):$company->pri_contact_email }}" required="" name="pri_contact_email" placeholder="primary contact email" class="form-control m-input"> @error('pri_contact_email')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Primary Name:</label>
                                                    <input type="text" value="{{ old('pri_contact_name')? old('pri_contact_name'):$company->pri_contact_name }}" name="pri_contact_name" placeholder="primary contact name" class="form-control m-input"> @error('pri_contact_name')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                            </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-4">
                                                <label>Sales mobile number:</label>
                                                <input type="text" value="{{ old('sales_mobile')? old('sales_mobile'):$company->sales_mobile }}" class="form-control" name="sales_mobile" placeholder="Sales mobile number"> @error('sales_mobile')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Brochure PDF:</label>
                                                <input type="file" name="brochure" class="form-control m-input"> @error('brochure')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror<br>
                                                @if($company->brochure)
                                                <a href="{{ asset('storage/'.$company->brochure) }}" class="btn btn-primary"><i class="fa fa-download"></i>Brochure PDF</a> @endif
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Price Lists PDF:</label>
                                                <input type="file" class="form-control" name="price_lists"> @error('price_lists')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror<br>
                                                @if($company->price_lists)
                                                <a href="{{ asset('storage/'.$company->price_lists) }}" class="btn btn-primary"><i class="fa fa-download"></i>Price lists PDF</a> @endif
                                            </div>
                                        </div>

                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Description in English:</label>
                                                    <textarea id="descri_en" class="form-control" name="descri_en" placeholder="Description English">{{ old('descri_en')? old('descri_en'):$company->translate('en')->description }}</textarea>
                                                    @error('descri_en')
                                                    <span class="invalid-feedback" role="alert">
		                                                        <strong>{{ $message }}</strong>
		                                                </span> @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Description in Arabic:</label>
                                                    <textarea id="descri_ar" class="form-control" name="descri_ar" placeholder="Description Arabic">{{ old('descri_ar')? old('descri_ar'):$company->translate('ar')->description }}</textarea>
                                                    @error('descri_ar')
                                                    <span class="invalid-feedback" role="alert">
		                                                        <strong>{{ $message }}</strong>
		                                                </span> @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Description Meta in English:</label>
                                                    <textarea class="form-control" name="descri_meta_en" placeholder="Description Meta English">{{ old('descri_meta_en')? old('descri_meta_en'):$company->translate('en')->description_meta }}</textarea>
                                                    @error('descri_meta_en')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Description Meta in Arabic:</label>
                                                    <textarea class="form-control" name="descri_meta_ar" placeholder="Description Meta Arabic">{{ old('descri_meta_ar')? old('descri_meta_ar'):$company->translate('ar')->description_meta }}</textarea>
                                                    @error('descri_meta_ar')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Keywords Meta in english:</label>
                                                    <input type="text" name="keyword_meta_en"  id="keyword_meta_en" placeholder="Keywords Meta in english" value="{{ old('keyword_meta_en')? old('keyword_meta_en'):$company->translate('en')->keywords_meta }}">
                                                    @error('keyword_meta_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                    </span> @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Keywords Meta in arabic:</label>
                                                    <input type="text" name="keyword_meta_ar"  id="keyword_meta_ar" placeholder="Keywords Meta" value="{{ old('keyword_meta_ar')? old('keyword_meta_ar'):$company->translate('ar')->keywords_meta }}">
                                                    @error('keyword_meta_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                    </span> @enderror
                                                </div>
                                        </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Keywords english:</label>
                                                     <input type="text" name="keyword_en"  id="keyword_en" placeholder="Keywords Meta" value="{{ old('keyword_en')? old('keyword_en'):$company->translate('en')->keywords }}">
                                                    @error('keyword_en')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Keywords arabic:</label>
                                                     <input type="text" name="keyword_ar"  id="keyword_ar" placeholder="Keywords Meta" value="{{ old('keyword_ar')? old('keyword_ar'):$company->translate('ar')->keywords }}">
                                                    @error('keyword_ar')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4">
                                                    <label>Map link:</label>
                                                    <input type="text" value="{{ old('map')? old('map'):$company->map }}" name="map" placeholder="map link" class="form-control m-input"> @error('map')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Facebook link:</label>
                                                    <input type="text" name="facebook" value="{{ old('facebook')? old('facebook'):$company->facebook }}" placeholder="facebook link" class="form-control m-input"> @error('facebook')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Instgram link:</label>
                                                    <input type="text" value="{{ old('insta')? old('insta'):$company->insta }}" name="insta" placeholder="instgram link" class="form-control m-input"> @error('insta')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4">
                                                    <label>Twitter link:</label>
                                                    <input type="text" name="twitter" value="{{ old('twitter')? old('twitter'):$company->twitter }}" placeholder="twitter link" class="form-control m-input"> @error('twitter')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Youtube link:</label>
                                                    <input type="text" name="youtube" placeholder="youtube  link" value="{{ old('youtube')? old('youtube'):$company->youtube }}" class="form-control m-input"> @error('youtube')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Linkedin link:</label>
                                                    <input type="text" value="{{ old('linkedin')? old('linkedin'):$company->linkedin }}" name="linkedin" placeholder="linkedin  link" class="form-control m-input"> @error('linkedin')
                                                    <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                </span> @enderror
                                                </div>
                                            </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-6">
                                                <label>Products Page Title  in english:</label>
                                                <input   class="form-control" name="products_title_en" placeholder="Products title english..." value="{{ old('products_title_en')? old('products_title_en'):$company->translate('en')->products_title }}">
                                                @error('products_title_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Products Page Title  in arabic:</label>
                                                <input   class="form-control" name="products_title_ar" placeholder="Products title arabic..." value="{{ old('products_title_ar')? old('products_title_ar'):$company->translate('ar')->products_title }}">
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
                                                <textarea id="products_description_en" class="form-control" name="products_description_en" placeholder="Products Description in english...">{{ old('products_description_en')? old('products_description_en'):$company->translate('en')->products_description }}</textarea>
                                                @error('products_description_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Products Page Description in Arabic:</label>
                                                <textarea id="products_description_ar" class="form-control" name="products_description_ar" placeholder="Products Description in arabic...">{{ old('products_description_ar')? old('products_description_ar'):$company->translate('ar')->products_description }}</textarea>
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
                                                <input id="products_keywords_en" data-role="tagsinput" class="form-control" name="products_keywords_en" placeholder="Products keywords english..." value="{{ old('products_keywords_en')? old('products_keywords_en'):$company->translate('en')->products_keywords }}">
                                                @error('products_keywords_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Products Keywords in arabic:</label>
                                                <input id="products_keywords_ar" data-role="tagsinput" class="form-control" name="products_keywords_ar" placeholder="Products keywords arabic..." value="{{ old('products_keywords_ar')? old('products_keywords_ar'):$company->translate('ar')->products_keywords }}">
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
