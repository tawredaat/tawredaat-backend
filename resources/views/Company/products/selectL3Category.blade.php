@extends('Company.index')
@section('products-new-active', 'm-menu__item--active m-menu__item--open')
@section('products-assign-new-active', 'm-menu__item--active') 
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
								<form action="{{route('company.selectedL3Categories')}}" class="regform" method="get">
									@csrf
								<input type="hidden" name="brand" value="{{request('brand')}}">
								<!-- Progress Bar -->
								<ul id="progressbar">
								<li>Brand</li>
								<li >Level 1</li>
								<li>Level 2</li>
								<li class="active">Level 3</li>
								<li>Products</li>
								</ul>
								<!-- Step 1 -->
								<fieldset id="first" style="width: 100%">
									<h2 class="title">Select category(level three)</h2>
									<p class="subtitle">Step four</p>
									<div class="form-group">
										<select required="" multiple="" style="height: 20px" data-live-search="true" data-actions-box="true"  id="idSelect" name="categories[]" id="" class="form-control selectpicker ">
											@foreach($l2Categories as $L2category)
											<optgroup style="font-weight: bold;" label="{{$L2category->translate('en')->name}}-{{$L2category->translate('ar')->name}}">
												@foreach($l3Categories as $category)
													@if($category && $category->parent == $L2category->id)
														<option value="{{$category->id}}">{{$category->translate('en')->name}}-{{$category->translate('ar')->name}}</option>
													@endif
												@endforeach
										    </optgroup>
										    @endforeach
										</select>
									</div>
									<input class="pre_btn" onclick="window.history.back();" type="button" value="Previous">
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
</script>
@endpush
@endsection
 <!-- end:: Body -->

   