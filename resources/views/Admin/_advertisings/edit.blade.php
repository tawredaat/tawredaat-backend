@extends('Admin.index')
@section('advertisings-active', 'm-menu__item--active m-menu__item--open')
@if(request()->input('type')=='category')
	@section('page-title', 'Ads|Category|Edit')
@elseif(request()->input('type')=='company')
	@section('page-title', 'Ads|Company|Edit')
@elseif(request()->input('type')=='brand')
	@section('page-title', 'Ads|Brand|Edit')
@elseif(request()->input('type')=='Product')
	@section('page-title', 'Ads|Product|Edit')
@endif

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
              @if(request()->input('type')=='category')
                  Categories Ads
              @elseif(request()->input('type')=='company')
                  Companies Ads
              @elseif(request()->input('type')=='brand')
                  Brand Ads
              @elseif(request()->input('type')=='product')
                  Product Ads
              @endif
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
												Edit {{ request()->input('type','company') }} advertising
											</h3>
										</div>
									</div>
								</div>
								<!--begin::Form-->
								<form method="POST" action="{{route('advertisings.update',$advertising->id)}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
									@csrf
									@method('put')
									<div class="m-portlet__body">
										<div class="form-group m-form__group row">
											<input type="hidden" name="type" value="{{ request()->input('type','company') }}">
											<div class="col-lg-4">
												<label>Image:</label>
												<input type="file" name="image" class="form-control m-input" placeholder="Upload Image">
	 											<img alt="image-not-found" src="{{ asset('storage/'.$advertising->image) }}" width="80">
												@error('image')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>


                                            <div class="col-lg-4">
                                                <label>Mobile Image:</label>
                                                <input type="file" name="mobileimg" class="form-control m-input" placeholder="Upload Image">
                                                <img alt="image-not-found" src="{{ asset('storage/'.$advertising->mobileimg) }}" width="80">
                                                @error('mobileimg')
                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
                                                @enderror
                                            </div>

											<div class="col-lg-4">
												<label>Alt name in english:</label>
												<input type="text" value="{{old('alt_en')? old('alt_en'): $advertising->translate('en')->alt}}" name="alt_en" required="" class="form-control m-input" placeholder="Alt name in english...">
												@error('alt_en')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-4">
												<label class="">Alt name in arabic:</label>
												<input type="text" value="{{old('alt_ar')? old('alt_ar'): $advertising->translate('ar')->alt}}" name="alt_ar"  required="" class="form-control m-input" placeholder="Alt name in arabic...">
												@error('alt_ar')
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
												<label>Alignment:</label>
												@if(old('alignment'))
												<select name="alignment" required="" class="form-control m-input m-input--square" id="exampleSelect1">
												<option @if(old('alignment')=='horizontal') selected @endif value="horizontal">Horizontal</option>
												<option @if(old('alignment')=='vertical') selected @endif value="vertical">Vertical</option>
												@else

												<select name="alignment" required="" class="form-control m-input m-input--square" id="exampleSelect1">
												<option @if($advertising->alignment=='horizontal') selected @endif value="horizontal">Horizontal</option>
												<option @if($advertising->alignment=='vertical') selected @endif value="vertical">Vertical</option>
											</select>
											@endif
												@error('alignment')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-6">
												<label>URL:</label>
												<input type="text" name="url" value="{{ old('url')? old('url'): $advertising->url }}" required="" class="form-control m-input" placeholder="Advertising url">
												@error('url')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
									</div>
								@if(request()->input('type')=='category')
									<div class="form-group m-form__group row">
											<div class="col-lg-12">
											<label>Category:</label>
									@if(!old('category_id'))
											<select name="category_id" required="" class="form-control">
												<option value="" @if($advertising->category_id==null) selected @endif>--Select Category--</option>
												@foreach($level1Categories as $cat)
													<option @if($advertising->category_id==$cat->id) selected @endif  style="padding-left: 10px; " value="{{$cat->id}}">&nbsp;&nbsp;&nbsp;
														-{{$cat->name}}
													</option>

													@foreach($cat->childs as $level2)
														<option @if($advertising->category_id==$level2->id) selected @endif  style="padding-left: 10px; " value="{{$level2->id}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--{{$level2->name}}</option>
														@foreach($level2->childs as $level3)
															<option @if($advertising->category_id==$level3->id) selected @endif  style="padding-left: 10px; " value="{{$level3->id}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;---{{$level3->name}}</option>
														@endforeach
													@endforeach
												@endforeach
											</select>
										@else
											<select required="" name="category_id" class="form-control">
												<option value="" @if(old('category_id')==null) selected @endif>--Select Category--</option>
												@foreach($level1Categories as $cat)
													<option @if(old('category_id')==$cat->id) selected @endif  style="padding-left: 10px; " value="{{$cat->id}}">&nbsp;&nbsp;&nbsp;
														-{{$cat->name}}
													</option>

													@foreach($cat->childs as $level2)
														<option @if(old('category_id')==$level2->id) selected @endif  style="padding-left: 10px; " value="{{$level2->id}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--{{$level2->name}}</option>
														@foreach($level2->childs as $level3)
															<option @if(old('category_id')==$level3->id) selected @endif  style="padding-left: 10px; " value="{{$level3->id}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;---{{$level3->name}}</option>
														@endforeach
													@endforeach
												@endforeach
											</select>
										@endif
												@error('category_id')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            	@enderror
											</div>
										</div>
							@endif
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

