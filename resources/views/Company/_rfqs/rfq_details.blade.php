@extends('Company.index')
@section('rfq-active', 'm-menu__item--active m-menu__item--open')
@if(! auth('company')->user()->rfq_isResponded($rfq_categories[0]->rfq_id))
@section('rfq-show-active', 'm-menu__item--active')
@else
    @section('members-show-responded-active', 'm-menu__item--active')
    @endif
@section('page-title', 'Rfqs|View')
@section('content')
    <style type="text/css">
        .swal2-confirm{
            background: #3085d6 !important;
        }
        .swal2-cancel{
            background: #f12143 !important;
            color: #fff;
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
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    {{$SubTitle}}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">

                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="table-responsive">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="rfq-details-table">
                                <thead >
                                <tr >
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Quantity</th>
                                    <th>Description</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rfq_categories as $rfq_category)
                                    <tr id="tr-{{$rfq_category->id}}">
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$rfq_category->category->name}}</td>
                                        <td>{{$rfq_category->quantity}}</td>
                                        <td>{{$rfq_category->description}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <br><br>
                            <form method="POST" action="{{route('company.rfq.response',$rfq_categories[0]->rfq_id)}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                                @csrf
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label>Response:</label>
                                            <textarea  name="response" @if(auth('company')->user()->rfq_isResponded($rfq_categories[0]->rfq_id)) readonly @endif required="" class="form-control m-input" cols="6">@if(auth('company')->user()->rfq_isResponded($rfq_categories[0]->rfq_id)){{auth('company')->user()->getRfqResponse($rfq_categories[0]->rfq_id)}}@endif</textarea>
                                            @error('response')
                                            <span class="invalid-feedback" role="alert">
	                                                        <strong>{{ $message }}</strong>
	                                                    </span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                @if(! auth('company')->user()->rfq_isResponded($rfq_categories[0]->rfq_id))
                                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                                    <div class="m-form__actions m-form__actions--solid">
                                        <div class="row">
                                            <div class="col-lg-6">
                                            </div>
                                            <div class="col-lg-6 m--align-right">
                                                <button type="submit" class="btn btn-primary">Send Response</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @else
                                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                                        <div class="m-form__actions m-form__actions--solid">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                </div>
                                                <div class="col-lg-6 m--align-right">

                                    @if(auth('company')->user()->rfqResponseStatus($rfq_categories[0]->rfq_id) == 1)
                                       <h3>This RFQ is accepted by {{ $rfq_categories[0]->rfq->user->name }}</h3>
                                    @elseif(auth('company')->user()->rfqResponseStatus($rfq_categories[0]->rfq_id) == 2)
                                       <h3>This RFQ is refused by {{ $rfq_categories[0]->rfq->user->name }}</h3>

                                    @elseif(auth('company')->user()->rfqResponseStatus($rfq_categories[0]->rfq_id) == null)
                                     <h3>Not Responded Yet</h3>
                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </form>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>




    @push('script')
        <script type="text/javascript">
            $(document).ready(function() {
                $("#rfq-details-table").dataTable({
                    "order": [[ 0, "desc" ]], //or asc 
                });
            });
        </script>
    @endpush
@endsection
<!-- end:: Body -->

