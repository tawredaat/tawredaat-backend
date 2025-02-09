@extends('User.partials.index')
@section('page-title', trans('home.send').' '.trans('home.rfq') )
@section('page-image', asset('storage/'.$setting->site_logo))
@section('canonical-link', url()->current())
@if(App::isLocale('en'))
@section('alternate-en-link', url()->current())
@section('alternate-ar-link', url()->current().'/ar')
@else
@section('alternate-ar-link', url()->current())
<?php
$en_link = str_replace("/ar", "",url()->current());
?>
@section('alternate-en-link',$en_link)
@endif
@push('script')
<style>
    .invalid-feedback{
        opacity: 1;
        display: block;
    }
    .rfq-label{
        margin: 10px 0;
        font-size: 15px;
        font-weight: bold;
        padding: 5px 0;
    }
</style>
@endpush
@section('content')
        <!-- start page content -->
        <main class="rfq-wrapper">
          <div class="container">
            <div class="rfq-content-holder">
              <div class="request-form-wrapper">
                <div class="request-form--header">
                  <h2>@lang('home.tellSuppWYN')</h2>
                  <h5>@lang('home.CYRFQ')</h5>
                  <p>@lang('home.TheMoreRFQPara')</p>
                </div>
                <div class="rfq-form">
                <form method="POST" action="{{route('user.send-rfq')}}" novalidate class="form-content needs-validation" enctype="multipart/form-data">
                    @csrf
                    <div class="rfq-item-wrapper">
                    <div class="form-group">
                      <div class="input-holder">
                        <label for="description">@lang('home.description')</label>
                        <input type="text" class="form-control" name="description[]" value="{{old('description.0')}}" id="description" required>
                            @foreach($errors->get('description.*') as $messages)
                                 @foreach ($messages as $message )
                                    <div class="invalid-feedback">{{ $message}}</div>
                                @endforeach
                            @endforeach
                            <br>
                        </div>
                      </div>
                      <div class="qty-input-holder">
                        <div class="form-group">
                          <div class="input-holder mr-3">
                            <label for="Qty">@lang('home.qty')</label>
                            <input type="number" name="quantity[]" value="{{old('quantity.0')}}" min="1" class="form-control" id="Qty" required>
                            @foreach($errors->get('quantity.*') as $messages)
                                @foreach ($messages as $message )
                                    <div class="invalid-feedback">{{ $message}}</div>
                                @endforeach
                            @endforeach
                            <br>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="select-label">@lang('home.catOfPro')</label>
                            <select name="category_id[]" data-live-search="true" id="exampleSelect1" class="selectpicker custom-select" required>
                                @foreach($categories as $cat)
                                    <option
                                    {{old('category_id.0')==$cat->id?'selected':''}}
                                            value="{{$cat->id}}">{{$cat->name}}
                                    </option>
                                @endforeach
                            </select>
                            @foreach($errors->get('category_id.*') as $messages)
                                @foreach ($messages as $message )
                                    <div class="invalid-feedback">{{ $message}}</div>
                                @endforeach
                            @endforeach
                            <br>
                          </div>
                      </div>
                      </div>
                      <div class="action-btn-holder text-center">
                        <button class="primary-fill add-rfq-btn round-btn mb-4">@lang('home.addAnotherRFQItem')</button>
                      </div>
                      <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" {{old('policy')?'checked':''}} name="policy" class="custom-control-input" id="termsCheck" required>
                        <label class="custom-control-label" for="termsCheck"> @lang('home.agreeShareInfo')</label>
                      </div>
                        @error('policy')
                                <div class="invalid-feedback">{{ $message}}</div>
                        @enderror
                     <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" {{old('terms')?'checked':''}} name="terms" class="custom-control-input" id="infoCheck" required>
                        <label class="custom-control-label" for="infoCheck"> @lang('home.readAndUnderstandRFQTerms') <a href="{{route('user.terms.conditions')}}" style="font-weight: bold;" target="_blank" class="primar-link">@lang('home.termsConditions') @lang('home.rfq')</a></label>
                      </div>
                        @error('terms')
                                <div class="invalid-feedback">{{ $message}}</div>
                        @enderror
                      <div class="action-btn-holder text-center">
                        <button class="primary-fill submit-btn round-btn mt-3" type="submit">@lang('home.submitRFQ')</button>
                      </div>
                  </form>
                </div>
              </div>
              <div class="request-banner-wrapper">
                <img style="width: 100%;"  src="{{ asset('storage/'.$setting->rfq_banner) }}" alt="rfq banner">
              </div>
            </div>
          </div>
        </main>
@endsection
@push('script')
<script>
      $(function () {
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
        $('.add-rfq-btn').click(function (e) {
          e.preventDefault();
          $(".rfq-item-wrapper").append(`
          <div><div class="form-group">
           <a href="#" style="font-size:15px;margin:10px;color: #000;" title="Remove this row" class="delete_category"><i class="fa fa-times"></i></a>
            <div class="input-holder">
              <label for="description">@lang('home.description')</label>
              <input type="text" name="description[]" class="form-control" id="description" required>
              </div>
            </div>
            <div class="qty-input-holder">
              <div class="form-group">
                <div class="input-holder mr-3">
                  <label for="Qty">@lang('home.qty')</label>
                  <input type="number" class="form-control" name="quantity[]" min="1" id="Qty" required>
                  </div>
                </div>
                <div class="form-group">
                    <label class="select-label">@lang('home.catOfPro')</label>
                    <select name="category_id[]" data-live-search="true" id="exampleSelect1" class="selectpicker custom-select" required>
                        @foreach($categories as $cat)
                            <option
                                    value="{{$cat->id}}">{{$cat->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            </div>
          `);
        });
      });
</script>
<script>
   $(document).on('click', '.delete_category', function(e) {
    e.preventDefault();
    $(this).parent().parent().fadeIn('slow').remove();
  });
</script>
@endpush
