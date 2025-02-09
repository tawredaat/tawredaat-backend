@extends('Admin.index')
@section('rfqs-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'User Rfqs| Responsed')
@section('content')
<style>
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
								<div class="m-portlet__body">
									<section class="content">
										<ul>
											<li>
												<span style="font-weight: bold;">RFQ Number : </span># {{$rfq->id}}
											</li>
											<li>
												<span style="font-weight: bold;">Status : </span>
												<span style="color:{{$rfq->statusColor()}}">{{$rfq->status}}</span>
											</li>
											<li>
												<span style="font-weight: bold;">Date/Time : </span>{{ date('M d, Y',strtotime($rfq->created_at)) . '/' .  date('h:i a',strtotime($rfq->created_at))}}
											</li>
                                          	<li>
												<span style="font-weight: bold;">User Type(Company/Individual): </span>{{$rfq->sender_type}}
											</li>
                                          	<li>
												<span style="font-weight: bold;">User Type: </span>{{$rfq->rfq_type}}
											</li>
                                          	<li>
												<span style="font-weight: bold;">Company Name: </span>{{$rfq->company_name}}
											</li>
											<li>
												<span style="font-weight: bold;">Name : </span>{{$rfq->user_name}}
											</li>
											<li>
												<span style="font-weight: bold;">Email : </span>{{$rfq->email}}
											</li>
											<li>
												<span style="font-weight: bold;">Phone : </span>{{$rfq->phone}}
											</li>
										</ul>
									</section>
								</div>
								<!--begin::Form-->
								<form method="POST" action="{{route('admins.rfqs.respond')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="rfq" value="{{$rfq->id}}">
									<div class="m-portlet__body">
										<div class="form-group m-form__group row">
											<div class="col-lg-12">
												<label>User Quotation:</label>
												<textarea class="form-control m-input" readonly>{{ $rfq->description }}</textarea>
											</div>
											@if($rfq->user_response)
												<div class="col-lg-12">
													<label>User Response:</label>
													<textarea class="form-control m-input" readonly>{{ $rfq->user_response }}</textarea>
												</div>
											@endif
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-12">
												<label>Attachments:</label>
												<table class="table table-striped- table-bordered table-hover table-checkable">
													<thead>
														<tr style="text-align:center">
															<th>User Attachment (Comes From the Front End)</th>
														</tr>
													</thead>
													<tbody>
														@foreach($rfq->attachments as $attachment)
															<tr>
																@if(in_array(strtolower(pathinfo($attachment->attachment, PATHINFO_EXTENSION)), $supported_image))
																<td style="text-align:center">
																	<a href="{{asset('storage/'. $attachment->attachment)}}" target="_blank">
																		<img src="{{asset('storage/'. $attachment->attachment)}}" width="100">
																	</a>
																	<a href="{{asset('storage/'. $attachment->attachment)}}" download width="100" title="View File" target="_blank">
																			<i class="btn btn-success">Download</i>
																	</a>
																</td>
																@else
																	<td>
																		<a href="{{asset('storage/'. $attachment->attachment)}}" download width="100" title="View File" target="_blank">
																			<i class="btn btn-success">Download</i>
																		</a>
																		<a href="{{asset('storage/'. $attachment->attachment)}}" width="100" title="View File" target="_blank">
																			<i class="btn btn-primary">preview</i>
																		</a>
																	</td>
																@endif
															</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-12">
												<label>Your Response:</label>
												<textarea class="form-control m-input" name="response" required>{{ old('response')?old('response'):$rfq->admin_response }}</textarea>
											</div>
										</div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-12">
                                                <label>Admin Attachment(Reply On Rfq):</label>
                                              	@if($rfq->status =='Not Responsed' && $rfq->email !== null)
                                                <input class="form-control m-input" type="file" name="attachment">
                                              	@endif
                                                @if($rfq->attachment !== null)
                                             
                                                <a href="{{ asset('storage/' . $rfq->attachment) }}" download target="_blank">
                                               	   <span class="btn btn-danger">Download Attachment</span>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
									</div>
                                  
									@if ($rfq->status == 'Not Responsed' && $rfq->email !== null)
    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit" style="margin-top: 20px;">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row">
                <div class="col-lg-12 m--align-right">
                    <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-size: 16px;">
                        <i class="fa fa-reply"></i> Respond
                    </button>
                </div>
            </div>
        </div>
    </div>
@else
    <div style="margin-top: 20px; padding: 20px; background-color: #fff3f3; border: 1px solid #ff4d4d; border-radius: 8px; text-align: right; line-height: 1.6;">
        <p style="color: #d9534f; font-weight: bold; margin: 0; font-size: 16px;">
            ⚠️ لا يمكنك الرد على عرض السعر هذا من خلال لوحة التحكم لأن المستخدم لم يدخل بريدًا إلكترونيًا.
            بدلاً من ذلك، يمكنك التواصل معه عبر الواتساب.
        </p>
        <p style="color: #d9534f; font-size: 14px; margin-top: 10px;">
            💡 من فضلك لا تنسَ الضغط على زر "<strong>تم الرد</strong>" في قائمة عروض الأسعار <span style="color: #28a745;">✔</span> لتجنب تكرار الرد من قبل الموظفين الآخرين.
        </p>
    </div>
@endif
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

