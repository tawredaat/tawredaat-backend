@extends('Company.index')
@section('products-active', 'm-menu__item--active m-menu__item--open')
@section('products-assign-active', 'm-menu__item--active') 
@section('page-title', 'Products|Assign') 
@section('content')
<style>
.main{
width: 700px;
margin-top: 80px;
}

#progressbar{
margin-left: 75px;
padding:0;
font-size:18px;
}
.active{
color:#716aca !important;
}
fieldset{
display:none;
width: 350px;
padding:20px;
margin-top:50px;
margin-left: 85px;
border-radius:5px;
box-shadow: 3px 3px 25px 1px gray;
}
#first{
display:block;
width: 350px;
padding:20px;
margin-top:50px;
border-radius:5px;
margin-left: 85px;
box-shadow: 3px 3px 25px 1px gray;
}
input[type=text],
input[type=password],
select{
width:100%;
margin:10px 0;
height:40px;
padding:5px;
border: 3px solid rgb(236, 176, 220);
border-radius: 4px;
}
textarea{
width:100%;
margin:10px 0;
height:70px;
padding:5px;
border: 3px solid rgb(236, 176, 220);
border-radius: 4px;
}
input[type=submit],
input[type=button]{
width: 120px;
margin:15px 25px;
padding: 5px;
height: 40px;
background-color: #5867dd;
border: none;
border-radius: 4px;
color: white;
}
h2,p{
text-align:center;
}
#progressbar li{
margin-right:52px;
display:inline;
color:#c1c5cc;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444 !important;
    line-height: 6px !important;
    text-align: center !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow{
	top: 12px;
    font-weight: bold;
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
								<div class="content" style="height: 450px">
								<!-- Multistep Form -->
								<div class="main">
								<form action="{{route('company.products.store')}}" class="regform" method="POST">
									@csrf
								<!-- Progress Bar -->
								<ul id="progressbar">
								<li class="active">Brand</li>
								<li>Level 1</li>
								<li>Level 2</li>
								<li>Level 3</li>
								<li>Products</li>
								</ul>
								<!-- Step 1 -->
								<fieldset id="first" style="width: 100%">
									<h2 class="title">Select Brand</h2>
									<p class="subtitle">Step 1</p>
									<div class="form-group">
										<select style="height: 20px" name="brand_id" id="brands" class="form-control options">
											<option value="" style="text-align: center;margin: 10px">--Select an Brand--</option>
											@foreach($brands as $brand)
												<option value="{{$brand->id}}">{{$brand->translate('en')->name}}-{{$brand->translate('ar')->name}}</option>
											@endforeach
										</select>
									</div>
									<input class="next_btn" id="step1" disabled="disabled" name="next" type="button" value="Next">
								</fieldset>
								<fieldset style="width: 100%">
								<h2 class="title">Levels1 Categories</h2>
								<p class="subtitle">Step 2</p>
								<input type="checkbox" id="Check_levels1">Check all
								<hr>
								<div class="form-group" id="levels1">
								</div>
								<input class="pre_btn" name="previous" type="button" value="Previous">
								<input class="next_btn" id="step2" disabled="disabled" name="next" type="button" value="Next">
								</fieldset>
								<fieldset style="width: 100%">
								<h2 class="title">Level2 Categories</h2>
								<p class="subtitle">Step 3</p>
								<input type="checkbox" id="Check_levels2">Check all
								<hr>
									<div class="form-group" id="levels2">
									</div>
								<input class="pre_btn" type="button" value="Previous">
								<input class="next_btn"  id="step3" disabled="disabled"  name="next" type="button" value="Next">

								</fieldset>
								<fieldset style="width: 100%">
								<h2 class="title">Level3 Categories</h2>
								<p class="subtitle">Step 4</p>
								<input type="checkbox" id="Check_levels3">Check all
								<hr>
								<div class="form-group" style="overflow-y: scroll;height: 250px" id="levels3"></div>
								
								<input class="pre_btn" type="button"  value="Previous">
								<input class="next_btn" name="next" id="step4" disabled="disabled" type="button" value="Next">
								</fieldset>
								<fieldset style="width: 100%">
								<h2 class="title">Products</h2>
								<p class="subtitle">Step 5</p>
								<input type="checkbox" id="Check_products">Check all
								<hr>
								<div class="form-group" style="overflow-y: scroll;height: 250px" id="products"></div>
								<input class="pre_btn" type="button" value="Previous">
								<input class="submit_btn" id="step5" type="submit" value="Submit">
								</fieldset>
						
								</form>
								</div>
								</div>
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
 @include('Company._products.script')
@endpush
@endsection
 <!-- end:: Body -->

   