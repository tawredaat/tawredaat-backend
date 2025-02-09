@extends('Admin.index')
@section('admins-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Admins|Edit') 

@section('content')
<style>
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
								<form method="POST" action="{{route('admins.update',$admin->id)}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
									@method('put')
									@csrf
                                    <input type="hidden" name="adminId" value="{{$admin->id}}">
									<div class="m-portlet__body">
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Full Name:</label>
												<input type="text" required="" name="name" value="{{old('name')?old('name'):$admin->name}}" class="form-control m-input" placeholder="Enter full name">
												@error('name')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
											<div class="col-lg-6">
												<label class="">Email:</label>
												<input type="email" required="" name="email" value="{{old('email')?old('email'):$admin->email}}" class="form-control m-input" placeholder="Enter email">
												@error('email')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label>Password:</label>
												<div class="m-input-icon m-input-icon--right">
													<input name="password" type="password" class="form-control m-input" placeholder="Enter your password">
												@error('password')
	                                                <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
	                                            @enderror
												</div>
											</div>

											<div class="col-lg-6">
											<label>Privilege:</label>
											@if(old('privilege'))
											<select name="privilege" required="" class="form-control m-input m-input--square" id="exampleSelect1">
											<option @if(old('privilege')=='super') selected @endif value="super">Super admin</option>
											<option @if(old('privilege')=='manager') selected @endif value="manager">Manager</option>
											<option @if(old('privilege')=='cs') selected @endif value="cs">Customer Services</option>
											</select>											
											@else

											<select name="privilege" required="" class="form-control m-input m-input--square" id="exampleSelect1">
											<option @if($admin->privilege=='super') selected @endif value="super">Super admin</option>
											<option @if($admin->privilege=='manager') selected @endif value="manager">Manager</option>
											<option @if($admin->privilege=='cs') selected @endif value="cs">Customer Services</option>
										</select>
										@endif
											@error('privilege')
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

