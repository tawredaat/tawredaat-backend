@extends('Admin.index')
@section('dynamic-page-active', 'm-menu__item--active m-menu__item--open')
@section('dynamic-page-create-active', 'm-menu__item--active')
@section('page-title', 'Dynamic | Page | Create')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .invalid-feedback {
            display: block;
        }
        .form-control-file {
            margin-top: 0.5rem;
        }
    </style>
@endsection
@section('content')

<style>
    .invalid-feedback {
        display: block;
    }

    .form-control-file {
        margin-top: 0.5rem;
    }
</style>

<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $MainTitle }} - {{ $SubTitle }}</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('dynamic-page.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- URL Field -->
                                <div class="form-group">
                                    <label for="url">URL</label>
                                    <input type="url" id="url" name="url" value="{{ old('url') }}" 
                                        class="form-control" placeholder="Enter URL" disabled>
                                    @error('url')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name_en">Name (English)</label>
                                        <input type="text" id="name_en" name="name_en" value="{{ old('name_en') }}" 
                                            class="form-control" placeholder="Name in English" required>
                                        @error('name_en')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="name_ar">Name (Arabic)</label>
                                        <input type="text" id="alt_ar" name="name_ar" value="{{ old('name_ar') }}" 
                                            class="form-control" placeholder="Name in Arabic" required>
                                        @error('name_ar')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Alt Text Fields -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="alt_en">Alt Text (English)</label>
                                        <input type="text" id="alt_en" name="alt_en" value="{{ old('alt_en') }}" 
                                            class="form-control" placeholder="Alt Text in English" required>
                                        @error('alt_en')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="alt_ar">Alt Text (Arabic)</label>
                                        <input type="text" id="alt_ar" name="alt_ar" value="{{ old('alt_ar') }}" 
                                            class="form-control" placeholder="Alt Text in Arabic" required>
                                        @error('alt_ar')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Page Title Fields -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="page_title_en">Page Title (English)</label>
                                        <input type="text" id="page_title_en" name="page_title_en" value="{{ old('page_title_en') }}" 
                                            class="form-control" placeholder="Page Title in English" required>
                                        @error('page_title_en')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="page_title_ar">Page Title (Arabic)</label>
                                        <input type="text" id="page_title_ar" name="page_title_ar" value="{{ old('page_title_ar') }}" 
                                            class="form-control" placeholder="Page Title in Arabic" required>
                                        @error('page_title_ar')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description Fields -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="description_en">Description (English)</label>
                                        <textarea id="description_en" name="description_en" class="form-control" placeholder="Description in English" required>{{ old('description_en') }}</textarea>
                                        @error('description_en')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="description_ar">Description (Arabic)</label>
                                        <textarea id="description_ar" name="description_ar" class="form-control" placeholder="Description in Arabic" required>{{ old('description_ar') }}</textarea>
                                        @error('description_ar')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Image Upload Fields -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="main_banner_en">Banner Image (English)</label>
                                        <input type="file" id="main_banner_en" name="main_banner_en" class="form-control-file" accept="image/*" required>
                                        @error('main_banner_en')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="main_banner_ar">Banner Image (Arabic)</label>
                                        <input type="file" id="main_banner_ar" name="main_banner_ar" class="form-control-file" accept="image/*" required>
                                        @error('main_banner_ar')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="main_banner_mobile_en">Mobile Image (English)</label>
                                        <input type="file" id="main_banner_mobile_en" name="main_banner_mobile_en" class="form-control-file" accept="image/*" required>
                                        @error('main_banner_mobile_en')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="main_banner_mobile_ar">Mobile Image (Arabic)</label>
                                        <input type="file" id="main_banner_mobile_ar" name="main_banner_mobile_ar" class="form-control-file" accept="image/*" required>
                                        @error('main_banner_mobile_ar')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                               <!-- Multi-Select Shop Products -->
                                <div class="form-group">
                                    <div class="col-lg-6">
                                        <label>Shop Products</label>
                                        <select class="form-control m-input js-example-basic-multiple" name="shopProducts[]" multiple="multiple" required>
                                            @foreach($shopProducts as $product)
                                                <option @if(in_array($product->id, old('shopProducts', []))) selected @endif value="{{ $product->id }}">
                                                    {{ $product->id . '-' . $product->name . '-' . $product->sku_code }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('shopProducts.*'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('shopProducts.*') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Submit Button -->
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 @push('script')
 <script type="text/javascript">
    $(document).ready(function() {
    	$('.js-example-basic-multiple').select2();

	});
     $('#keywords_en, #keywords_ar, #keywords_meta_en,#keywords_meta_ar,#products_keywords_ar,#products_keywords_en,#distributors_keywords_ar,#distributors_keywords_en').tagsinput({
        confirmKeys: [13, 188]
      });

      $('.bootstrap-tagsinput').on('keypress', function(e){
        if (e.keyCode == 13){
          e.keyCode = 188;
          e.preventDefault();
        };
      });
</script>
@endpush
@endsection

