@extends('Company.index')
@section('subscription-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Current Subscription') 
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
            </div>
          </div>
          <!-- END: Subheader -->
        <div class="m-content">
                        <div style="display: none;" class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">
                            <div class="m-alert__icon">
                                <i class="flaticon-exclamation m--font-brand"></i>
                            </div>
                        </div>
                        <div class="m-portlet m-portlet--mobile">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            My Subscription Details
                                        </h3>
                                    </div>
                                </div>
                                @if(isset($subscription))
                                    @if(!$subscription->pending)
                                        @if(\Carbon\Carbon::now()->gt($subscription->end_date))
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                    <li class="m-portlet__nav-item">
                                                        <button data-toggle="modal" data-target="#m_modal_1" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                                            <span>
                                                                <i class="la la-plus"></i>
                                                                <span>Subscripe</span>
                                                            </span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Subscripe</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="m-pricing-table-3 m-pricing-table-3--fixed">
                                                                <div class="m-pricing-table-3__items">
                                                                    <div class="row m-row--no-padding">
                                                                        @foreach($subscriptions as $sub)
                                                                        @if($sub->id == $subscription->subscription_id)
                                                                            <div class="m-pricing-table-3__item m-pricing-table-3__item--focus m--bg-brand col-lg-4">
                                                                                <div class="m-pricing-table-3__wrapper">
                                                                                    <h3 class="m-pricing-table-3__title m--font-light">{{ $sub->translate('en')->name }}</h3>
                                                                                    <span class="m-pricing-table-3__price">
                                                                                        <span class="m-pricing-table-3__label">$</span>
                                                                                        <span class="m-pricing-table-3__number m--font-light">{{ $sub->price }}</span>
                                                                                        <span class="m-pricing-table-3__text">/&nbsp;&nbsp;Per {{ $sub->durationInMonth }} Month</span>
                                                                                    </span>
                                                                                    <br>
                                                                                    <span class="m-pricing-table-3__description">
                                                                                        <span>This subscription provide you {{ $sub->rank_points }}</span><br>
                                                                                        <span>for {{ $sub->durationInMonth }} Month</span><br>
                                                                                    </span>
                                                                                    <div class="m-pricing-table-3__btn">
                                                                                        <form method="post" action="{{ route('company.subscription.new',$sub->id) }}">
                                                                                            @csrf
                                                                                            <button type="submit" class="btn m-btn--pill  btn-light m-btn--label-brand m-btn--wide m-btn--uppercase m-btn--bolder m-btn--lg">Purchase</button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @else

                                                                            <div class="m-pricing-table-3__item col-lg-4">
                                                                                <div class="m-pricing-table-3__wrapper">
                                                                                    <h3 class="m-pricing-table-3__title">{{ $sub->translate('en')->name }}</h3>
                                                                                    <span class="m-pricing-table-3__price">
                                                                                        <span class="m-pricing-table-3__label">$</span>
                                                                                        <span class="m-pricing-table-3__number">{{ $sub->price }}</span>
                                                                                        <span class="m-pricing-table-3__text">/&nbsp;&nbsp;Per {{ $sub->durationInMonth }} Month</span>
                                                                                    </span>
                                                                                    <br>
                                                                                    <span class="m-pricing-table-3__description">
                                                                                        <span>>This subscription provide you {{ $sub->rank_points }}</span><br>
                                                                                        <span></span><br>
                                                                                    </span>
                                                                                    <div class="m-pricing-table-3__btn">
                                                                                        <form method="post" action="{{ route('company.subscription.new',$sub->id) }}">
                                                                                            @csrf
                                                                                            <button type="submit" class="btn m-btn--pill  btn-light m-btn--label-brand m-btn--wide m-btn--uppercase m-btn--bolder m-btn--lg">Purchase</button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        @elseif(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($subscription->end_date)->subMonth()))
                                            <div class="m-portlet__head-tools">
                                                <ul class="m-portlet__nav">
                                                    <li class="m-portlet__nav-item">
                                                        <button class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" data-toggle="modal" data-target="#m_modal_4">
                                                            <span>
                                                                <i class="la la-plus"></i>
                                                                <span>Renew Subscription</span>
                                                            </span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="modal fade" id="m_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">{{ $subscription->subscription->translate('en')->name }} - {{ $subscription->subscription->translate('ar')->name }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" id="subscirpe-form" action="{{ route('company.subscription.renew') }}">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label  class="form-control-label">Duration:</label>
                                                                    <input type="text" class="form-control" readonly value="{{ $subscription->subscription->durationInMonth }} Month">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label  class="form-control-label">Price:</label>
                                                                    <input type="text" class="form-control" readonly value="{{ $subscription->subscription->price }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label  class="form-control-label">Rank points:</label>
                                                                    <input type="text" class="form-control" readonly value="{{ $subscription->subscription->rank_points }}">
                                                                </div>                                                         
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button onclick="document.getElementById('subscirpe-form').submit()" type="button" class="btn btn-primary">Renew</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                             
                                        @endif
                                    @endif
                                @else
                                    <div class="m-portlet__head-tools">
                                        <ul class="m-portlet__nav">
                                            <li class="m-portlet__nav-item">
                                                <button data-toggle="modal" data-target="#m_modal_2" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                                    <span>
                                                        <i class="la la-plus"></i>
                                                        <span>Subscripe</span>
                                                    </span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="modal fade" id="m_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Subscripe</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="m-pricing-table-3 m-pricing-table-3--fixed">
                                                        <div class="m-pricing-table-3__items">
                                                            <div class="row m-row--no-padding">
                                                                @foreach($subscriptions as $sub)
                                                                    <div class="m-pricing-table-3__item col-lg-4">
                                                                        <div class="m-pricing-table-3__wrapper">
                                                                            <h3 class="m-pricing-table-3__title">{{ $sub->translate('en')->name }}</h3>
                                                                            <span class="m-pricing-table-3__price">
                                                                                <span class="m-pricing-table-3__label">$</span>
                                                                                <span class="m-pricing-table-3__number">{{ $sub->price }}</span>
                                                                                <span class="m-pricing-table-3__text">/&nbsp;&nbsp;Per {{ $sub->durationInMonth }} Month</span>
                                                                            </span>
                                                                            <br>
                                                                            <span class="m-pricing-table-3__description">
                                                                                <span>>This subscription provide you {{ $sub->rank_points }}</span><br>
                                                                                <span></span><br>
                                                                            </span>
                                                                            <div class="m-pricing-table-3__btn">
                                                                                <form method="post" action="{{ route('company.subscription.new',$sub->id) }}">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn m-btn--pill  btn-light m-btn--label-brand m-btn--wide m-btn--uppercase m-btn--bolder m-btn--lg">Purchase</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                @endif                             
                            </div>

                            <div class="m-portlet__body">
                                <div class="table-responsive">
                                    
                                <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable">
                                <thead>
                                <tr>
                                    <th>Subscription name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Duration in Months</th>
                                    <th>Price</th>
                                    <th>Rank Points</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody id="categories_info">
                                @if(isset($subscription))
                                        <tr>
                                            <td>{{ $subscription->subscription->translate('en')->name}} - {{ $subscription->subscription->translate('ar')->name }}</td>
                                            <td>{{ $subscription->start_date}}</td>
                                            <td>{{ $subscription->end_date}}</td>
                                            <td>{{ $subscription->durationInMonth}}</td>
                                            <td>{{ $subscription->price}}</td>
                                            <td>{{ $subscription->rank_points}}</td>
                                            @if($subscription->pending)
                                                @if($subscription->pending==1)
                                                    <td style="color:yellow;font-weight: bold">Pending</td>
                                                @else
                                                    <td style="color:blue;font-weight: bold">Renew</td>
                                                @endif
                                            @else
                                                @if(\Carbon\Carbon::now()->gt($subscription->end_date))
                                                    <td style="color:red;font-weight: bold">Expired</td>
                                                @else
                                                    <td style="color:green;font-weight: bold">Active</td>
                                                @endif
                                            @endif
                                        </tr>
                                @else
                                    <td colspan="7" class="text-center">You currently don't have subscription.</td>
                                @endif

                                </tbody>
                            </table>
                                </div>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>
        </div>
      </div>     
@endsection
 <!-- end:: Body -->

   