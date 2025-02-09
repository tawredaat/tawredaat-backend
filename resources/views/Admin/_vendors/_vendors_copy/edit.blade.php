@extends('Admin.index')
@section('vendors-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Vendors |Edit')
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
                            {{ $main_title }}
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
                                                    {{ $sub_title }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Form-->
                                    <form method="POST" action="{{ route('vendors.update', $vendor->id) }}"
                                        enctype="multipart/form-data"
                                        class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                                        @method('put')
                                        @csrf
                                        <input name="id" value="{{ $vendor->id }}" type="hidden" />
                                        <div class="m-portlet__body">
                                            <div class="m-portlet__body">

                                                <div class="form-group m-form__group row">
                                                    <div class="col-lg-6">
                                                        <label>Company Name</label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <input name="company_name"
                                                                value="{{ old('company_name', $vendor->company_name) }}"
                                                                required type="text" class="form-control m-input">
                                                        </div>
                                                        @error('company_name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Logo</label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <input type="file" name="logo"
                                                                class="form-control m-input" accept=".png,.jpg,.pdf">
                                                        </div>
                                                        <a href="{{ asset('storage/' . $vendor->logo) }}"
                                                            class="btn btn-primary">
                                                            <i class="fa fa-download"></i>Logo</a>

                                                        @error('logo')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>


                                                </div>


                                                <div class="form-group m-form__group row">
                                                    <div class="col-lg-4">
                                                        <label>Responsible Person Name</label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <input name="responsible_person_name"
                                                                value="{{ old('responsible_person_name', $vendor->responsible_person_name) }}"
                                                                required type="text" class="form-control m-input">
                                                        </div>
                                                        @error('responsible_person_name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Responsible Person Mobile Number</label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <input name="responsible_person_mobile_number"
                                                                value="{{ old('responsible_person_mobile_number', $vendor->responsible_person_mobile_number) }}"
                                                                required type="text" maxlength="15"
                                                                class="form-control m-input">
                                                        </div>
                                                        @error('responsible_person_mobile_number')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <label>Responsible Person Email</label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <input name="responsible_person_email"
                                                                value="{{ old('responsible_person_email', $vendor->responsible_person_email) }}"
                                                                required type="email" class="form-control m-input">
                                                        </div>
                                                        @error('responsible_person_email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <div class="col-lg-6">
                                                        <label>Commercial License</label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <input type="file" name="commercial_license"
                                                                class="form-control m-input" accept=".png,.jpg,.pdf">
                                                        </div>

                                                        <a href="{{ asset('storage/' . $vendor->commercial_license) }}"
                                                            class="btn btn-primary">
                                                            <i class="fa fa-download"></i>Commercial License</a>

                                                        @error('commercial_license')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <label>Tax Number Certificate</label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <input type="file" name="tax_number_certificate"
                                                                class="form-control m-input" accept=".png,.jpg,.pdf">
                                                        </div>
                                                        <a href="{{ asset('storage/' . $vendor->tax_number_certificate) }}"
                                                            class="btn btn-primary">
                                                            <i class="fa fa-download"></i>Tax Number Certificate</a>
                                                        @error('tax_number_certificate')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <div class="col-lg-6">
                                                        <label>Added Value Certificate</label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <input type="file" name="added_value_certificate"
                                                                class="form-control m-input" accept=".png,.jpg,.pdf">
                                                        </div>
                                                        @if ($vendor->added_value_certificate)
                                                            <a href="{{ asset('storage/' . $vendor->added_value_certificate) }}"
                                                                class="btn btn-primary">
                                                                <i class="fa fa-download"></i>Added Value Certificate</a>
                                                        @endif

                                                        @error('added_value_certificate')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <label>Contractors Association Certificate</label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <input type="file"
                                                                name="contractors_association_certificate"
                                                                class="form-control m-input" accept=".png,.jpg,.pdf">
                                                        </div>
                                                        @if ($vendor->contractors_association_certificate)
                                                            <a href="{{ asset('storage/' . $vendor->contractors_association_certificate) }}"
                                                                class="btn btn-primary">
                                                                <i class="fa fa-download"></i>Contractors Association
                                                                Certificate</a>
                                                        @endif

                                                        @error('contractors_association_certificate')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <div class="col-lg-6">
                                                        <label>Company Type</label>
                                                        <select name="company_type" required
                                                            class="form-control m-input m-input--square">

                                                            <option @if (old('privilege') == 'contractor' || $vendor->company_type == 'contractor') selected @endif
                                                                value="contractor">
                                                                Contractor</option>

                                                            <option @if (old('privilege') == 'seller' || $vendor->company_type == 'seller') selected @endif
                                                                value="seller">
                                                                Seller
                                                            </option>

                                                            <option @if (old('privilege') == 'electrician' || $vendor->company_type == 'electrician') selected @endif
                                                                value="electrician">
                                                                Electrician
                                                            </option>
                                                        </select>
                                                        @error('company_type')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-6">

                                                        <label class="" for="check">Is Approved</label>
                                                        <input type="checkbox" id="check" name="is_approved"
                                                            value="1" {{ $vendor->is_approved ? 'checked' : '' }}
                                                            class="form-control m-input">
                                                        @error('is_approved')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

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
