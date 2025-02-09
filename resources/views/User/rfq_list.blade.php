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
        <li class="breadcrumb-item active" aria-current="page">@lang('home.myRFQs')</li>
      </ol>
    </nav>
    <div class="blogs-wrapper" style="text-align: center">
      <table class="table" style="background:#fff">
        <thead style="font-weight:bold;" class="thead-dark" >
          <tr style="color: #52504c;">
            <th scope="col">#</th>
            <th scope="col">@lang('home.myRFQs')</th>
            <th scope="col">@lang('home.response')</th>
          </tr>
        </thead>
        <tbody>
          @foreach($rfqs as $rfq)
          <tr>
            <th scope="row">{{$loop->index+1}}</th>
            <td>
                <table style="display:initial;" class="table">
                    <thead>
                        <tr>
                            <td style="font-weight:bold;">@lang('home.category')</td>
                            <td style="font-weight:bold;">@lang('home.description')</td>
                            <td style="font-weight:bold;">@lang('home.quantity')</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($rfq->rfq_category as $rfq_cat)
                    <tr>
                       <td>{{$rfq_cat->category?$rfq_cat->category->name:'Category deleted'}}</td>
                       <td>{{$rfq_cat->description}}</td>
                       <td>{{$rfq_cat->quantity}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </td>
            <td>
              @if($rfq->status == 1)
              <a  href="{{route('user.rfq.responses',$rfq->id)}}"  title="Show Responses" class="btn btn-primary" style="color:#fff">
                <i class="fas fa-eye"></i>
              </a>
              @elseif($rfq->status == 2)
               <span style="color:red"> @lang('home.rejected')</span>
              @else
                @lang('home.notResponded')
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
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
