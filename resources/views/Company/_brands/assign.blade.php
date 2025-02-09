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
                  <form action="{{route('company.update.type.brands')}}"  id="BrandTy" class="" method="POST">@csrf
                   <div class="row">
                    <div class="col-lg-6">
                      <label for="types">Brand</label>
                      <select name="id"  data-actions-box="true"  data-live-search="true" class="form-control m-input selectpicker"  required>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}"  >{{ $brand->name }}
                        </option>
                        @endforeach
                      </select>
                      @if($errors->has('brand'))
                      <em class="invalid-feedback">
                        {{ $errors->first('brand') }}
                      </em>
                      @endif
                    </div>
                    <div class="col-lg-6">
                      <label for="types">Type</label>
                      <select name="company_type_id[]" multiple="" data-actions-box="true"  data-live-search="true" class="form-control m-input selectpicker"  required>
                        @foreach($companyTypes as $type)
                        <option value="{{ $type->id }}"  >{{ $type->name }}
                        </option>
                        @endforeach
                      </select>
                      @if($errors->has('company_type_ids'))
                      <em class="invalid-feedback">
                        {{ $errors->first('company_type_id') }}
                      </em>
                      @endif
                    </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="submit" form="BrandTy" class="btn btn-info">Save
                  </button>
                  <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close -->
                  </button>
                </div>
                </form>
        <!--begin: Datatable -->
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
</div>
@push('script')
<script type="text/javascript">
</script>
@endpush
@endsection
<!-- end:: Body -->
