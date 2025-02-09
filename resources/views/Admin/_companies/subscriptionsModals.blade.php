@foreach($subscriptionsCompany as $subscription)
<div class="modal fade" id="exampleModalCenter{{$subscription->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Company Subscription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
				<form method="POST" action="{{route('current-subscription.update',$subscription->id)}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" enctype="multipart/form-data" id="editCompanySubscription{{$subscription->id}}">
				    @csrf @method('put')
				    <div class="m-portlet__body">
				        <div class="form-group m-form__group row">
				            <div class="col-lg-6">
				                <label>Company</label>
				                <div class="m-input-icon m-input-icon--right">
				                    <input disabled="" name="company" value="{{ $subscription->company->name }}" required type="text" class="form-control m-input" placeholder="Name in english...">

				                </div>
				            </div>
				            <div class="col-lg-6">
				                <label>Subscription</label>
				                <input type="text" disabled="" value="{{ $subscription->subscription->name  }}" name="subscription" required class="form-control m-input" placeholder="Name in arabic...">
				            </div>

				        </div>
				    </div>
				    <div class="m-portlet__body">
				        <div class="form-group m-form__group row">
				            <div class="col-lg-12">
				                <label>End Date</label>
				                <div class="m-input-icon m-input-icon--right">
				                    <input name="end_date" value="{{$subscription->end_date}}" required type="text" class="form-control m-input" placeholder="Duration in Month...">
				                    <span class="m-input-icon__icon m-input-icon__icon--right"></span>
				                </div>

				            </div>


				        </div>
				    </div>
				    <div class="m-portlet__body">
				        <div class="form-group m-form__group row">
				            <div class="col-lg-6">
				                <label>Rank Points</label>
				                <input type="text" name="rank_points" value="{{ $subscription->rank_points }}" required class="form-control m-input" placeholder="Rank Points...">

				            </div>
				            <div class="col-lg-6">
				                <label>Price</label>
				                <input type="text" name="price" value="{{ $subscription->price }}" disabled="" required class="form-control m-input" placeholder="price...">
				            </div>
				        </div>
				    </div>
				    <div style="display: none" class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
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
            </div>
            <div class="modal-footer">
                    <button type="submit" form="editCompanySubscription{{$subscription->id}}" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach