@extends('Company.index')
@section('products-new-active', 'm-menu__item--active m-menu__item--open')
@section('products-assign-new-active', 'm-menu__item--active') 
@section('page-title', 'Products|Assign') 
@section('content')
@push('style')
<style type="text/css">
	.offset{
     margin-top:-500px;
    }
</style>
@endpush
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
								<form action="{{route('company.selectedBrands')}}" class="regform" method="get">
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
										<select required="" style="height: 20px" data-live-search="true"  name="brand_id" id="" class="form-control selectpicker ">
											<option  selected hidden value=""  style="text-align: center;margin: 10px">--Select an Brand--</option>
											@foreach($brands as $brand)
												<option value="{{$brand->id}}">{{$brand->translate('en')->name}}-{{$brand->translate('ar')->name}}</option>
											@endforeach
										</select>
									</div>
									<input class="next_btn"  type="submit" value="Next">
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
<script type="text/javascript">
// $(function() {
// 	window.scroll({
// 	  top: 120,
// 	  behavior: 'smooth'
// 	});
// });
</script>
@endpush
@endsection
 <!-- end:: Body -->

   