@extends('Company.index')
@section('products-new-active', 'm-menu__item--active m-menu__item--open')
@section('products-view-new-active', 'm-menu__item--active') 
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
                    <i class="la la-plus">
                    </i>
                    <span>Assign products
                    </span>
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="m-portlet__body">
          <section class="content">
            <div
                 style="display: flex;justify-content: flex-end;align-items:flex-end;margin-bottom: 20px">
              <div class="input-group" style="width: 500px">
                <input type="text" id="searchField" class="form-control"
                       aria-label="Text input with dropdown button">
                <div class="input-group-append">
                  <select id="searchColumn" class=" form-control" data-live-search="true"
                          title="Please select a lunch ...">
                    <option value="product_name">Product Name</option>
                    <option value="brand">Brand</option>
                    <option value="price">Price</option>
                    <option value="unit">Unit</option>
                    <option value="qty">Qty</option>
                    <option value="disc">Discount</option>
                  </select>
                </div>
                <div class="input-group-append">
                  <button id="searchButton" class="btn btn-primary" type="button">
                    <i
                       class="fa fa-search">
                    </i>
                  </button>
                </div>
              </div>
            </div>
            <div style="overflow-x:auto;">
              <table class="table table-striped- table-bordered table-hover table-checkable"
                     id="products-table">
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
                <tbody id="spinner">
                  <tr>
                    <td style="height: 100px;text-align: center;line-height: 100px;"
                        colspan="18">
                      <i class="fa fa-spinner fa-spin text-primary" style="font-size: 30px"
                         aria-hidden="true">
                      </i>
                    </td>
                  </tr>
                </tbody>
                <tbody id="products-body">
                </tbody>
                <tfoot>
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
                </tfoot>
              </table>
            </div>
            <div id="paginationLinksContainer"
                 style="display: flex;justify-content: center;align-items: center;margin-top: 10px">
              {{--                                    {{$products->links()}}--}}
            </div>
          </section>
        </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
    </div>
  </div>
</div>
@include('Company._products.edit_modals')
@push('script')
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$("#products-table").on('click', '.delete', function(){
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
               $('#tr-'+data['id']).remove();
                Swal.fire(
                'Deleted!',
                'Product has been unassigned.',
                'success'
                )
            }
            ,error:function(data){
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
function render(url) {
    $('#products-body').css({
      display: "none"});
    $('#spinner').css({
      display: "table-row-group"});
    $.ajax({
      url: url,
      method: "get",
      dataType: 'JSON',
      success: function (data) {
        $('#products-body').css({
          display: "table-row-group"}).html(data.result);
        $('#spinner').css({
          display: "none"});
        $('#paginationLinksContainer').html(data.links)
      }
      ,
    });
}
  render("{{route('company.products.new.index')}}");
  $('#paginationLinksContainer').on('click', 'a.page-link', function (event) {
    event.stopPropagation();
    render($(this).attr('href'));
    return false;
  });
  $('#searchButton').on('click', function (event) {
    event.stopPropagation();
    render("{{route('company.products.new.index')}}?column=" + $('#searchColumn').val() + '&value=' + $('#searchField').val());
  });
</script>
@endpush
@endsection
<!-- end:: Body -->
