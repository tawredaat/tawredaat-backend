@extends('Admin.index')
@section('blogs-active', 'm-menu__item--active m-menu__item--open')
@section('blogs-create-active', 'm-menu__item--active')
@section('page-title', 'Blogs|Create')
@section('content')
<style>
::-webkit-file-upload-button {
  background-color: #5867dd;
  border: 1px solid #5867dd;
  border-radius: 5px;
  color: #fff;
  padding: 2px;

}

.invalid-feedback {
    display: block;
}
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
                                <form method="POST" action="{{route('blogs.store')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
                                    @csrf
                                    <div class="m-portlet__body">
                                        <div class="form-group m-form__group row">
                                           <div class="col-lg-6">
                                                <label>Title in english</label>
                                                <div class="m-input-icon m-input-icon--right">
                                                    <input name="title_en" value="{{ old('title_en') }}" required type="text" class="form-control m-input" placeholder="Title in english...">

                                                </div>
                                            @error('title_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Title in arabic</label>
                                                <input type="text" value="{{ old('title_ar') }}" name="title_ar" required class="form-control m-input" placeholder="Title in arabic...">
                                                @error('title_ar')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label>Description in english:</label>
                                            <textarea id="descri_en" class="form-control" name="descri_en" placeholder="Description in english">{{old('descri_en')}}</textarea>
                                            @error('descri_en')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Description in arabic:</label>
                                            <textarea id="descri_ar" class="form-control" name="descri_ar" placeholder="Description in arabic...">{{old('descri_ar')}}</textarea>
                                            @error('descri_ar')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label>Description Meta in english:</label>
                                            <textarea id="descri_meta_en" class="form-control" name="descri_meta_en" placeholder="Description Meta in english">{{old('descri_meta_en')}}</textarea>
                                            @error('descri_meta_en')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Description Meta in arabic:</label>
                                            <textarea id="descri_meta_ar" class="form-control" name="descri_meta_ar" placeholder="Description Meta in arabic...">{{old('descri_meta_ar')}}</textarea>
                                            @error('descri_meta_ar')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label>Tags in english...:</label>
                                            <input id="tags_en" type="text" name="tags_en" placeholder="Tags in english..." value="{{old('tags_en')}}"  class="form-control">
                                            @error('tags_en')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Tags in arabic:</label>
                                            <input id="tags_ar" type="text" name="tags_ar" placeholder="Tags in arabic..." value="{{old('tags_ar')}}"  class="form-control">
                                            @error('tags_ar')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label>Page Title in english...:</label>
                                            <input  type="text" name="page_title_en" placeholder="Page Title  in english..." value="{{old('page_title_en')}}"  class="form-control">
                                            @error('page_title_en')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Page Title in arabic:</label>
                                            <input  type="text" name="page_title_ar" placeholder="Page Title in arabic..." value="{{old('page_title_ar')}}"  class="form-control">
                                            @error('page_title_ar')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label> Title meta in english...:</label>
                                            <input  type="text" name="title_meta_en" placeholder="Title meta   in english..." value="{{old('title_meta_en')}}"  class="form-control">
                                            @error('title_meta_en')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Title meta in arabic:</label>
                                            <input  type="text" name="title_meta_ar" placeholder="Title meta in arabic..." value="{{old('title_meta_ar')}}"  class="form-control">
                                            @error('title_meta_ar')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label>Tags Meta in english...:</label>
                                            <input id="tags_meta_en" type="text" name="tags_meta_en" placeholder="Tags Meta in english..." value="{{old('tags_meta_en')}}"  class="form-control">
                                            @error('tags_meta_en')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Tags Meta in arabic:</label>
                                            <input id="tags_meta_ar" type="text" name="tags_meta_ar" placeholder="Tags Meta in arabic..." value="{{old('tags_meta_ar')}}"  class="form-control">
                                            @error('tags_meta_ar')
                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="m-portlet__body">
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-4">
                                                <label>Image</label>
                                                <input type="file" name="image" required class="form-control m-input">
                                            @error('image')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                            </div>
                                            <div class="col-lg-4">
                                              <label>Image english alt</label>
                                                <div class="m-input-icon m-input-icon--right">
                                                    <input name="alt_en" value="{{ old('alt_en') }}" required type="text" class="form-control m-input" placeholder="Image alt in english...">
                                            @error('alt_en')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Image arabic alt</label>
                                                <input type="text" name="alt_ar" value="{{ old('alt_ar') }}" required class="form-control m-input" placeholder="Image alt in arabic...">
                                            @error('alt_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                            </div>

                                            <div class="col-lg-4">
                                                <label> English Slug</label>
                                                <input type="text" name="slug_en" value="{{ old('slug_en') }}" required class="form-control m-input" placeholder="English Slug..">
                                                @error('slug_en')
                                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-4">
                                                <label>Arabic Slug</label>
                                                <input type="text" name="slug_ar" value="{{ old('slug_ar') }}" required class="form-control m-input" placeholder="Arabic Slug..">
                                                @error('slug_ar')
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



@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#descri_ar').summernote({
                tabsize: 2,
                height: 150
            });
            $('#descri_en').summernote({
                tabsize: 2,
                height: 150
            });

            $('#tags_en,#tags_ar, #tags_meta_en,#tags_meta_ar').tagsinput({
                confirmKeys: [13, 188]
            });
        });
    </script>
@endpush

@endsection
 <!-- end:: Body -->

