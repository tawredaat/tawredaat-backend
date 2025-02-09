@extends('Admin.index')
@section('search-active', 'm-menu__item--active m-menu__item--open')
@section('search-product-active', 'm-menu__item--active') 
@section('page-title', 'Search Store|Products')
@section('content')
<style type="text/css">
  .swal2-confirm{
    background: #3085d6 !important;
    border: #3085d6 !important;
  }
  .swal2-cancel{
    background: #f12143 !important;
    color: #fff !important;
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
            Search Store
          </h3>
        </div>
      </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
      <div class="row">
        <form method="get" id="Excel" action="{{route('products.search.file')}}"
              class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
          @csrf
          <input type="hidden" name="filter" id="filter-input" value="0">
          <div class="m-portlet__body row">
            <div class="form-group m-form__group col-9">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">From
                  </span>
                </div>
                <input type="date" name="start_date" value="{{request()->input('start_date')}}" class="form-control">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">To
                  </span>
                </div>
                <input type="date" name="end_date" value="{{request()->input('end_date')}}" class="form-control">
              </div>
              @if($errors->has('start_date'))
              <span class="invalid-feedback" style="display:block;" role="alert">
                <strong>{{ $errors->first('start_date') }}
                </strong>
              </span>
              @endif
              @if($errors->has('end_date'))
              <span class="invalid-feedback" style="display:block;" role="alert">
                <strong>{{ $errors->first('end_date') }}
                </strong>
              </span>
              @endif
            </div>
            <div class="form-group m-form__group col-3">
              <div class="col-lg-12 m--align-right" style="display: inline-flex;">
                <button type="submit" form="Excel" id="filter-btn" style="margin: 0 5px" class="btn btn-primary">
                  <i class="fas fa-filter">
                  </i> Filter
                </button>
                <button type="submit" form="Excel" class="btn btn-primary">Export Excel
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h3 class="m-portlet__head-text">
                Products
              </h3>
            </div>
          </div>
        </div>
        <div class="m-portlet__body">
          <div class="table-responsive">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="products-search-table">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Date</th>
                  <th>Time</th>
                </tr>
              </thead>
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
@push('script')
<script type="text/javascript">
    function render(url) {
       $("#products-search-table").dataTable({
          "order": [[ 1, "desc" ]],
          processing: true,
          serverSide: true,
          ajax: url,
          columns: [
          {data: 'search_value', name: 'search_value'},
          {data: 'date_added', name: 'date_added'},
          {data: 'time_added', name: 'time_added'},
          ]});
    }
    $(document).ready(function () {
      $("#filter-btn").click(function() {
        document.querySelector("#filter-input").value = 1;
      });
    });
    @if(request()->has('start_date') && request()->has('end_date'))
      render("{!! route('search.store.products').'?start_date='.request()->input('start_date').'&end_date='.request()->input('end_date')!!}");
    @else
      render("{!! route('search.store.products')!!}");
    @endif
</script>
@endpush
@endsection
<!-- end:: Body -->
