@extends('Admin.index')
@section('offer-packages-active', 'm-menu__item--active m-menu__item--open')
@section('offer-packages-create-active', 'm-menu__item--active')
@section('page-title', 'Offer Packages | Create')
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
                                <form method="POST" action="{{route('shop.offerPackages.store')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                                    @csrf
                                    <div class="m-portlet__body">
                                        <div class="form-group m-form__group row">
                                        <div class="col-lg-12">
                                           <div class="row">
                                                <div class="col-lg-4">
                                                    <label>Shop Product</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                    <select  name="shop_product_id" class="form-control m-input" required>
                                                        @foreach ($shopProducts as $shopProduct )
                                                            <option @if($shopProduct->id ==old('shop_product_id')) selected @endif value="{{$shopProduct->id}}">{{$shopProduct->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                    @error('shop_product_id')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Shop Product Qty</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input type="number"  name="shop_product_qty" value="{{ old('shop_product_qty') }}" required class="form-control m-input" placeholder="Enter qty...">
                                                    </div>
                                                    @error('shop_product_qty')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Shop Product Qty Type</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <select required name="shop_product_qty_type"  class="form-control m-input" >
                                                            @foreach ($quantityTypes as $qty_type)
                                                                <option @if(old('shop_product_qty_type')==$qty_type->id) selected @endif value="{{$qty_type->id}}">{{$qty_type->name .' | '. $qty_type->translate('ar')->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('shop_product_qty_type')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-lg-12">
                                           <div class="row">
                                                <div class="col-lg-4">
                                                    <label><span style="color:red">Gift</span> Product</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                    <select name="gift_products[]" class="form-control m-input" required>
                                                        @foreach ($shopProducts as $shopProduct )
                                                            <option @if(in_array($shopProduct->id, old('gift_products',[$loop->index]))) selected @endif value="{{$shopProduct->id}}">{{$shopProduct->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                    @if($errors->has('gift_products.*'))
                                                         <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('gift_products.*') }}</strong></span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-4">
                                                    <label><span style="color:red">Gift</span> Product Qty</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input type="number" name="gift_qtys[]" value="{{ old('gift_qtys.0') }}" required  class="form-control m-input" placeholder="Enter gift qty...">
                                                    </div>
                                                    @if($errors->has('gift_qtys.*'))
                                                         <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('gift_qtys.*') }}</strong></span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-4">
                                                    <label><span style="color:red">Gift</span> Product Qty Type</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <select required name="gift_qty_types[]"  class="form-control m-input" >
                                                            @foreach ($quantityTypes as $qty_type)
                                                                <option @if(old('gift_qty_types.0')==$qty_type->id) selected @endif value="{{$qty_type->id}}">{{$qty_type->name .' | '. $qty_type->translate('ar')->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @if($errors->has('gift_qty_types.*'))
                                                         <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('gift_qty_types.*') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="col-lg-12">
                                            <label>Price</label>
                                            <div class="m-input-icon m-input-icon--right">
                                                <input type="text" name="price" value="{{ old('price') }}" required  class="form-control m-input" placeholder="Enter Price...">
                                            </div>
                                            @error('price')
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

