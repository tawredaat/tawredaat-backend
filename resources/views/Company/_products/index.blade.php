@extends('Company.index')
@section('products-active', 'm-menu__item--active m-menu__item--open')
@section('products-view-active', 'm-menu__item--active') 
@section('page-title', 'Products|View') 
@section('content')
<style type="text/css">
  .swal2-confirm{
    background: #3085d6 !important;
  }
  .swal2-cancel{
    background: #f12143 !important;
    color: #fff;
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
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
											{{$SubTitle}}
										</h3>
									</div>
								</div>
								<div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item">
											<a href="{{route('company.products.create')}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la la-plus"></i>
													<span>Assign products</span>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="m-portlet__body">
                <div class="table-responsive">
                  
								<!--begin: Datatable -->
								<table class="table table-striped- table-bordered table-hover table-checkable" id="products">
									<thead>
										<tr>
                      <th>Product Image</th>
                      <th>Product Name</th>
										  <th>Brand</th>
                       <th>Price</th>
                       <th>Unit</th>
                       <th>Qty</th>
                       <th>Discount</th>
										  <th>Actions</th>
										</tr>
									</thead>
                 <tbody>
                    @if(count($products))
                    @foreach($products as $pro)
                    @if($pro->product)
                      <tr id="pro{{$pro->id}}">
                        <td><img alt="image-not-found" src="{{ asset('storage/'.$pro->product->image) }}" width="80"></td>
                        <td>{{$pro->product->name}} </td>
                        <td>{{$pro->brand->name}}</td>
                        <td id="ProductPrice{{$pro->id}}">{{$pro->price}}</td>
                        <td id="ProductUnit{{$pro->id}}">{{(isset($pro->unit->name)?$pro->unit->name:'-')}}</td>
                        <td id="ProductQty{{$pro->id}}">{{$pro->qty}}</td>
                        <td id="ProductDiscount{{$pro->id}}">{{$pro->discount}}</td>

                        <td>
                          <a style="color:#fff;font-size: 12px;margin:2px;" class="btn btn-danger delete btn-sm" data-content="{{$pro->id}}"><i class="fa fa-trash"></i></a><a style="color:#fff;font-size: 12px;margin: 2px;" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModalCenter{{$pro->id}}"><i class="fa fa-edit"></i></a><br>
                        </td>
                      </tr>
                    @endif
                    @endforeach
                    @else
                    <tr>
                      <td colspan="">There are no products assigned to your caompany</td>
                    </tr>
                    @endif
                  </tbody>
									<tbody>
									</tbody>
								</table>
                </div>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
        </div>
      </div>
@include('Company._products.edit_modals')
 @push('script')
 <script type="text/javascript">
  $('#products').DataTable();
   //Delete Product data
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#products").on('click', '.delete', function(){
           Swal.fire({
             title: 'Are you sure to unassign this Product?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, unassign it!'
            }).then((result) => {
              if (result.value) {
                var content = $( this ).data( "content" );
                var urls = "{{ route('company.products.destroy','id' ) }}";
                urls = urls.replace('id', content);
                $.ajax({
                    url: urls, 
                    method: 'POST',
                    data: {_token: CSRF_TOKEN, id: content,_method:"delete"},
                    dataType: 'JSON',
                    success: function (data) { 
                       // $("#products").DataTable().ajax.reload();
                       // $('#pro'+data['id']).remove();
                        $('#products').DataTable().row($('#pro'+data['id'])).remove().draw();

                        Swal.fire(
                        'Deleted!',
                        'Product has been unassigned.',
                        'success'
                        )
                    }
                    ,error:function(data){
                       $("#products").DataTable().ajax.reload();
                    }

                }); 
              }
            });
        });

       $(document).ready(function(){
        $(".edit_company_products").submit(function(event) {
           event.preventDefault()
            var id = $("input[name='id']",this).val();
            _route = "{{route('company.products.update','ID') }}"
            _route = _route.replace('ID', id);
             $.ajax({
              url:_route,
              method:"POST",
              data: new FormData(this),
              contentType: false,
              cache:false,
              processData: false,
              dataType:"json",
              success: function(data){
                Swal.fire('saved!','Product has been updated.','success')
                var model = "#exampleModalCenterID";
                model = model.replace('ID', data['id']);
                    $(model).modal('toggle');
                     $("#ProductPrice"+data['id']).html(data['data']['price']);
                     $("#ProductUnit"+data['id']).html(data['unit']);
                     $("#ProductQty"+data['id']).html(data['data']['qty']);
                     $("#ProductDiscount"+data['id']).html(data['data']['discount']);
              },
              error: function(data){
                  swal("failed!", "error,Can't save data!", "error");
              }
             });
          });
  });
 </script>
@endpush
@endsection
 <!-- end:: Body -->

   