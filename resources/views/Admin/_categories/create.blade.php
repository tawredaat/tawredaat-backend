@extends('Admin.index')
@section('categories-active', 'm-menu__item--active m-menu__item--open')
@section('categories-create-active', 'm-menu__item--active') 
@section('page-title', 'Categories|Create') 
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
								<form method="POST" action="{{route('categories.store')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
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
												<input type="text" value="{{old('name_ar')}}" name="name_ar"  required="" class="form-control m-input" placeholder="Name in arabic...">
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
												<input type="text" value="{{old('title_en')}}" class="form-control" name="title_en" placeholder="Title in english..">
												@error('title_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Title in arabic:</label>
												<input type="text" value="{{old('title_ar')}}" class="form-control" name="title_ar" placeholder="Title in arabic..">
												@error('title_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>	
										</div>	
										<div class="form-group m-form__group row">
											<div class="col-lg-12">
											<label>Parent:</label>
											<select name="parent" class="form-control">
												{{--<option value="" @if(old('parent')==null) selected @endif>Parent</option>--}}
												@foreach($level1 as $cat)
													<option @if(old('parent')==$cat->id) selected @endif  style="padding-left: 10px; " value="{{$cat->id}}">&nbsp;&nbsp;&nbsp;
														{{$cat->name}}
													</option>
													
													@foreach($cat->childs as $level2)
														<option @if(old('parent')==$level2->id) selected @endif  style="padding-left: 10px; " value="{{$level2->id}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$level2->name}}</option>
													@endforeach
												@endforeach
											</select>
												@error('Parent')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>								
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-4">
											<label class="">Image:</label>
												<input type="file" name="image"  required="" class="form-control m-input" >
												@error('image')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-4">
												<label>ALT image in english:</label>
												<input type="text" name="alt_en" required="" value="{{old('alt_en')}}" class="form-control m-input" placeholder="ALT image in english...">
													@error('alt_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-4">
												<label class="">Alt image in arabic:</label>
												<input type="text" name="alt_ar"  required="" value="{{old('alt_ar')}}"  class="form-control m-input" placeholder="ALT image in arabic...">
													@error('alt_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
									</div>
									<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Keywords in english...:</label>
												<input id="keywords_en" type="text" name="keywords_en" placeholder="keywords in english..." value="{{old('keywords_en')}}"  class="form-control">
												@error('keywords_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Keywords in arabic:</label>
												<input id="keywords_ar" type="text" name="keywords_ar" placeholder="keywords in arabic..." value="{{old('keywords_ar')}}"  class="form-control">
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
												<input id="keywords_meta_en" type="text" name="keywords_meta_en" placeholder="keywords Meta in english..." value="{{old('keywords_meta_en')}}"  class="form-control">
												@error('keywords_meta_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Keywords Meta in arabic:</label>
												<input id="keywords_meta_ar" type="text" name="keywords_meta_ar" placeholder="keywords Meta in arabic..." value="{{old('keywords_meta_ar')}}"  class="form-control">
												@error('keywords_meta_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
										</div>

									<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Description in english:</label>
												<textarea id="descri_en" class="form-control" name="descri_en" placeholder="Description in english">{{old('descri_en')}}</textarea>
												@error('descri_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Description in arabic:</label>
												<textarea id="descri_ar" class="form-control" name="descri_ar" placeholder="Description in arabic...">{{old('descri_ar')}}</textarea>
												@error('descri_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
										</div>
									<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Meta description in english:</label>
												<textarea class="form-control" name="descri_meta_en" placeholder="Meta description in english..">{{old('descri_meta_en')}}</textarea>
												@error('descri_meta_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
											<div class="col-lg-6">
												<label>Meta description  in arabic:</label>
												<textarea class="form-control" name="descri_meta_ar" placeholder="Meta description in arabic..">{{old('descri_meta_ar')}}</textarea>
												@error('descri_meta_ar')
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

  	 $('#keywords_en,#keywords_ar, #keywords_meta_en,#keywords_meta_ar').tagsinput({
        confirmKeys: [13, 188]
      });
	});
</script>
@endpush
@endsection
 <!-- end:: Body -->

