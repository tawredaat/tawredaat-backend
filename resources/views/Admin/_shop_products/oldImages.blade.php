@extends('Admin.index')
@section('shop-products-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Shop | Products | Images')
@push('style')
<style type="text/css">
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
  .swal2-confirm{
    background: #3085d6 !important;
  }
  .swal2-cancel{
    background: #f12143 !important;
    color: #fff;
  }
</style>
@endpush
@section('content')
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
										  	{{$SubTitle}} {{ $product->name }}
											</h3>
										</div>
									</div>
								</div>
								<div class="m-portlet__body">

              <!--begin::Form-->
                <form method="POST" action="{{route('shop.products.uploadImages',$product->id)}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
                  @csrf
                  <hr style="margin:0">
                  <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--solid">
                      <div class="row">
                        <div class="col-lg-6">
                          <label class="">Upload Images:</label>
                          <input type="file" name="images[]" multiple required="" class="form-control m-input" >
                             @if($errors->has('images.*'))
                                   <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('images.*') }}</strong></span>
                           @endif
                        </div>
                        <div class="col-lg-6 m--align-right">
                          <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
                <!--end::Form-->
                 <div class="table-responsive">
                                <!--begin: Datatable -->
                                <table class="table table-striped- table-bordered table-hover table-checkable" id="products--mages">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <?php $i= 0; ?>
                                      @foreach($images as $img)
                                      <tr>
                                        <td>{{$i++}}</td>
                                        <td>  <img width="100" src="{{ asset('products/images/'.$img) }}" ></td>
                                        <td>
                                            <button id='{{ $product->id }}'  class="btn btn-danger deleteImage" data-id="{{ $product->id }}" data-image='{{ $img }}'><i class="fa fa-trash"></i></button>
                                        </td>
                                      </tr>
                                      @endforeach
                                </table>
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
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(".deleteImage").on('click', function(event){
           Swal.fire({
             title: 'Are you sure to delete this Image?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                var id = $( this ).data( "id" );
                var image = $( this ).data( "image" );
                var urls = "{{ route('shop.products.deleteImage',['id'=>'id','image'=>'photo']) }}";
                urls = urls.replace('id', id);
                urls = urls.replace('photo',image);
                $.ajax({
                    url: urls,
                    method: 'get',
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (data) {
                       $('#'+id).closest('div.row').remove();
                        Swal.fire(
                    'Deleted!',
                    'Image Deleted Successfully',
                    'success'
                    )
                    },
                    error: function (data){
	                    Swal.fire(
	                    'Ops!',
	                    'Failed to delete Image Please try again',
	                    'fail'
	                    	)
                	}

                });
              }
            });
        });

</script>
@endpush
@endsection
 <!-- end:: Body -->

