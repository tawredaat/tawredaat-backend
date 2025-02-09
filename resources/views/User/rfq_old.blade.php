@extends('User.partials.index')
@section('page-title', trans('home.rfq') )
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
<main class="blog-holder">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb px-0">
        <li class="breadcrumb-item">
          <a href="{{ route('user.home') }}">@lang('home.home')
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">@lang('home.rfq')
        </li>
      </ol>
    </nav>
    <div class="blogs-wrapper form-wrapper">
      {{--
      <h1>Coming Soon--}}
        {{--
      </h1>--}}
      {{--
      <h2>Page Under Construction--}}
        {{--
      </h2>--}}
      <form method="POST" action="{{route('user.send-rfq')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
        @csrf
        <div id="rfq_content">
          <div class="form-group m-form__group row">
            <div class="col-lg-6">
              <label class="rfq-label">@lang('home.selectCategory')</label>
              <select name="category_id[]"  required="" class="form-control m-input m-input--square selectpicker" data-live-search="true" id="exampleSelect1">
                @foreach($categories as $cat)
                <option
                        value="{{$cat->id}}">{{$cat->name}}
                </option>
                @endforeach
              </select>
            </div>
            <div class="col-lg-6">
              <label class="rfq-label">@lang('home.description')</label>
              <br>
              <textarea  name="description[]" style="background:#fff !important;" required="" class="form-control m-input" placeholder="@lang('home.descriptionRFQ')"></textarea>
            </div>
          </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-12">
                <a href="#" style="background: #2e2e2e;border: 1px solid #2e2e2e;width: 50px;" title="Add Category" id="clone_category" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus" style="color: #fff"></i>
                </a>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-12" style="text-align:center">
                    <button type="submit" style="background: #23408D;border: 1px solid #23408D;margin: 20px;" class="primary-fill submit-btn btn btn-primary">@lang('home.send')</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</main>
<input type="hidden" id="token" value="{{csrf_token()}}" />
@endsection
@push('script')
<script>
  $("#clone_category").on('click',function (e){
    e.preventDefault();
    var _token = $("#token").val();
    $.ajax({
      url: "{{route('user.clone-categories')}}",
      method: "post",
      data: {
        _token:_token}
      ,
      success:function (data) {
        console.log(data);
        $("#rfq_content").append(' <div class="form-group m-form__group row"> '+data+'</div>').hide().fadeIn('slow');
        //$("#specifications").html('<a href="#" class="fa fa-trash remove"> </a>'+data);
      }
    });
  });
   $(document).on('click', '.delete_category', function(e) {
    e.preventDefault();
    $(this).parent().parent().parent().fadeIn('slow').remove();
  });
</script>
@endpush
