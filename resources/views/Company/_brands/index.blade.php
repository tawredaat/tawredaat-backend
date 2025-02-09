@extends('Company.index')
@section('brand-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Brands') 
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
      </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
      <div style="display: none;" class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">
        <div class="m-alert__icon">
          <i class="flaticon-exclamation m--font-brand">
          </i>
        </div>
      </div>
      <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h3 class="m-portlet__head-text">
                {{$title}}
              </h3>
            </div>
          </div>
          <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
              <li class="m-portlet__nav-item">
                <a href="{{route('company.assign.brand')}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                  <span>
                    <i class="la la-plus"></i>
                    <span>Assign</span>
                  </span>
                </a>
              </li>
            </ul>
					</div>
        </div>
        <div class="m-portlet__body">
          @foreach($brands as $brand)
          <div class="modal fade" id="brandType-{{$brand->brand->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Update Brand Type
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{route('company.update.type.brands')}}"  id="BrandTy{{$brand->brand->id}}" class="CompanyBrandType" method="POST">@csrf
                    <input type="hidden"  name="id" value="{{$brand->brand->id}}">
                    <div class="col-lg-12">
                      <label for="types">Types
                      </label>

                      <select name="company_type_id[]" multiple="" data-actions-box="true"  data-live-search="true" class="form-control m-input selectpicker"  required>
                        @foreach($companyTypes as $type)
                        <option value="{{ $type->id }}"  {{ in_array( $type->id , $brand->types($brand->brand_id,$brand->company_id)->pluck('company_type_id','company_type_id')->toArray()) || in_array($type->id, old('company_type_id', [])) ? 'selected' : '' }}>{{ $type->name }}
                        </option>
                        @endforeach
                      </select>
                      @if($errors->has('company_type_ids'))
                      <em class="invalid-feedback">
                        {{ $errors->first('company_type_id') }}
                      </em>
                      @endif
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="submit" form="BrandTy{{$brand->brand->id}}" class="btn btn-info">Save
                  </button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                  </button>
                </div>
                </form>
            </div>
          </div>
        </div>
        @endforeach
        <!--begin: Datatable -->
        <table class="fixed-table-body table table-striped- table-bordered table-hover table-checkable" id="brands_datatable">
          <thead>
            <tr>
              <th>Brand</th>
              <th>Brand-Type</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="categories_info">
            @if(count($brands) > 0)
            @foreach ($brands as $brand)
            @if($brand->brand)
            <tr id="tr-{{$brand->brand->id}}">
              <td>{{ $brand->brand?$brand->brand->name:'-'}}</td>
              <td>
                  @if(count($brand::types($brand->brand_id ,$brand->company_id )))
                  @foreach($brand::types($brand->brand_id ,$brand->company_id ) as $type)<span style="padding: 10px;margin: 5px"  class="badge badge-info">{{$type->type->name}}</span>@endforeach
                  @else
                  <span>'Not Selected'</span>
                  @endif
              </td>
              <td>
                @if($brand->approve==0)
                <span style="background-color: yellow;color: #000;padding: 5px;font-weight: bold;border-radius: 20%;">Not Selected
                </span>
                @elseif($brand->approve==1)
                <span style="background-color: blue;color: #fff;padding: 5px;font-weight: bold;border-radius: 20%;">Pending
                </span>
                @elseif($brand->approve==2)
                <span style="background-color: green;color: #fff;padding: 5px;font-weight: bold;border-radius: 20%;">Approved
                </span>
                @elseif($brand->approve==-1)
                <span style="background-color: red;color: #fff;padding: 5px;font-weight: bold;border-radius: 20%;">Rejected
                </span>
                @endif
              </td>
              <td>
                <a title="Update type" style="color:#fff;font-size: 12px;margin: 2px;" class="btn btn-info btn-sm" data-toggle="modal" data-target="#brandType-{{$brand->brand->id}}">
                  <i class="fas fa-edit">
                  </i>
                </a>
                <a title="unassign brand and it's products" style="color:#fff;font-size: 12px;margin:2px;" class="btn btn-danger delete btn-sm" data-content="{{$brand->brand->id}}">
                  <i class="fa fa-trash">
                  </i>
                </a>
              </td>
            </tr>
            @endif
            @endforeach
            @else
            <td colspan="7" class="text-center">There are no brands assigned yet.
            </td>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
</div>
@push('script')
<script type="text/javascript">
  $('#brands_datatable').DataTable({
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'excel',
        filename: 'Brands',
      }
    ]
  });
  //Delete Company data
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $("#brands_datatable").on('click', '.delete', function(){
    Swal.fire({
      title: 'Are you sure to unassign this brand and it\'s products?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, unassign it!'
    }).then((result) => {
      if (result.value) {
        var content = $( this ).data( "content" );
        var urls = "{{ route('company.unassign.brand','id' ) }}";
        urls = urls.replace('id', content);
        $.ajax({
          url: urls, 
          method: 'POST',
          data: {
            _token: CSRF_TOKEN, id: content,_method:"delete"}
          ,
          dataType: 'JSON',
          success: function (data) {
            $("#brands_datatable").DataTable().row($('#tr-' + data['id'])).remove().draw();
            Swal.fire(
              'Unassigned!',
              'Brand has been unassigned successfully!.',
              'success'
            )
          }
          ,error:function(data){
            $("#brands_datatable").DataTable().ajax.reload();
          }
        });
      }
    });
  });
</script>
@endpush
@endsection
<!-- end:: Body -->
