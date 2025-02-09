@extends('Admin.index')
@section('users-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Users|Edit')
@section('content')
    <style>
        ::-webkit-file-upload-button {
            background-color: #5867dd;
            border: 1px solid #5867dd;
            border-radius: 5px;
            color: #fff;
            padding: 5px;

        }

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
                            {{ $MainTitle }}
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
                                                    {{ $SubTitle }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Form-->
                                    <form method="POST" action="{{ route('users.update', $user->id) }}"
                                        class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>First Name:</label>
                                                    <input type="text" name="name"
                                                        value="{{ old('name') ? old('name') : $user->name }}" required=""
                                                        class="form-control m-input" placeholder="Enter first name">
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Last Name:</label>
                                                    <input type="text" name="last_name"
                                                        value="{{ old('last_name') ? old('last_name') : $user->last_name }}"
                                                        required="" class="form-control m-input"
                                                        placeholder="Enter last name">
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label class="">Email:</label>
                                                    <input type="email" name="email"
                                                        value="{{ old('email') ? old('email') : $user->email }}"
                                                        required="" class="form-control m-input"
                                                        placeholder="Enter email">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Password:</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="password" type="password" class="form-control m-input"
                                                            placeholder="Enter your password">
                                                        <span class="m-input-icon__icon m-input-icon__icon--right"></span>
                                                    </div>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">


                                                <div class="col-lg-6">
                                                    <label>Title:</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="title" type="text"
                                                            value="{{ old('title') ? old('title') : $user->title }}"
                                                            class="form-control m-input" placeholder="Enter your title">
                                                        <span class="m-input-icon__icon m-input-icon__icon--right"></span>
                                                    </div>
                                                    @error('title')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-6">
                                                    <label>Company name:</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="company_name" required=""
                                                            value="{{ old('company_name') ? old('company_name') : $user->company_name }}"
                                                            type="text" class="form-control m-input"
                                                            placeholder="Enter your Company name">
                                                        <span class="m-input-icon__icon m-input-icon__icon--right"></span>
                                                    </div>
                                                    @error('company_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Phone:</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="phone" required=""
                                                            value="{{ old('phone') ? old('phone') : $user->phone }}"
                                                            type="text" class="form-control m-input"
                                                            placeholder="Enter your Company name">
                                                        <span class="m-input-icon__icon m-input-icon__icon--right"></span>
                                                    </div>
                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-12">
                                                    <label>Photo:</label>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input name="photo" type="file" class="form-control m-input"
                                                            placeholder="Enter your Photo">
                                                        <span class="m-input-icon__icon m-input-icon__icon--right"></span>
                                                    </div>
                                                    <br>
                                                    <img alt="image-not-found"
                                                        src="{{ asset('storage/' . $user->photo) }}" width="80">
                                                    @error('photo')
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
