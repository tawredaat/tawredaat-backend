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
        <li class="breadcrumb-item active" aria-current="page">@lang('home.myRFQs')
        </li>
      </ol>
    </nav>
    <div class="blogs-wrapper" style="text-align: center">
      @if($accept == null)
      <table class="table" style="background:#fff">
        <thead style="background-color: #f4c536;" class="thead-dark">
          <tr style="color: #52504c;">
            <th scope="col">#</th>
            <th scope="col">@lang('home.company')
            </th>
            <th scope="col">@lang('home.description')
            </th>
            <th scope="col">@lang('home.response')
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($rfq_responses as $response)
          <tr>
            <th scope="row">{{$response->id}}
            </th>
            <td>
              {{$response->company->name}}
            </td>
            <td>
              {{$response->responseDescription}}
            </td>
            <td>
              <a  href="{{route('user.rfq.response.accept',$response->id)}}"  title="Accept" class="btn btn-primary" style="color:#fff">
                <i class="fas fa-check">
                </i>
              </a>
              <a  href="{{route('user.rfq.response.refuse',$response->id)}}"  title="Refuse" class="btn btn-primary" style="color:#fff">
                <i class="fas fa-times">
                </i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <h3 style="text-align: left;margin: 10px;font-weight: bold;">@lang('home.acceptedResponse')</h3>
        <table style="background:#fff" class="table">
            <thead>
                <tr>
                    <td style="font-weight:bold;">@lang('home.company')</td>
                    <td style="font-weight:bold;">@lang('home.response')</td>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$accept->company->name}}</td>
                <td>{{$accept->responseDescription}}</td>
            </tr>
            </tbody>
        </table>
      @endif
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
        $("#rfq_content").append(' <div class="form-group m-form__group row" id="specifications" > '+data+'</div>');
        //$("#specifications").html('<a href="#" class="fa fa-trash remove"> </a>'+data);
      }
    });
  });
</script>
@endpush
