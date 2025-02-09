@extends('User.partials.index')
@section('page-title', trans('home.productrfq') )
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
                    <li class="breadcrumb-item"><a href="{{ route('user.home') }}">@lang('home.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('home.productrfq')</li>
                </ol>
            </nav>
            <div class="blogs-wrapper" style="text-align: center">
                <table class="table" style="background:#fff">
                    <thead style="font-weight:bold;" class="thead-dark">
                    <tr style="color: #52504c;">
                        <th scope="col">#</th>
                        <th scope="col">@lang('home.response')</th>
                        <th scope="col">@lang('home.companyName')</th>
                        <th scope="col">@lang('home.qty')</th>
                        <th scope="col">@lang('home.notes')</th>
                        <th scope="col">@lang('home.response')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rfqs as $rfq)
                        <tr>
                            <th scope="row">{{$rfq->id}}</th>
                            <td>
                                {{$rfq->companyProduct?($rfq->companyProduct->product?$rfq->companyProduct->product->name:'---'):'---'}}
                            </td>
                            <td>
                                {{$rfq->company?$rfq->company->name:'---'}}
                            </td>
                            <td>
                                {{$rfq->qty}}
                            </td>
                            <td>
                                {{$rfq->notes}}
                            </td>
                            <td>
                                @if($rfq->message == null)
                                    Pending
                                @else
                                    {{$rfq->message}}
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
                data: {_token:_token},
                success:function (data) {
                    $("#rfq_content").append(' <div class="form-group m-form__group row" id="specifications" > '+data+'</div>');
                    //$("#specifications").html('<a href="#" class="fa fa-trash remove"> </a>'+data);
                }
            });
        });
    </script>
@endpush
