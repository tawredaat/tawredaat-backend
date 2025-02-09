@foreach($companiesWithSubscrip as $company)
<div class="modal fade" id="subscripModalCenter{{$company->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Make Subscription to company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
        <form method="POST" action="{{route('assign-subscription')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="makeCompanySubscrip{{$company->id}}">
            @csrf
            <div class="form-group m-form__group row">
            	<input type="hidden" name="companyId" value="{{$company->id}}">
                <div class="col-lg-12">
                    <label>Subscriptions</label>
                    <select class="form-control m-input " name="subscriptionId"  required>
                        <option value="" selected>Select Subscription</option>
                        @foreach($subscriptions as $subscription)
                            <option @if(old('subscriptionId') == $subscription->id) selected @endif  value="{{ $subscription->id }}">{{ $subscription->name }} - {{ $subscription->name }}</option>
                        @endforeach
                    </select>
                    <span style="display: none" class="m-form__help">Subscriptions:</span>
                </div>
            </div>
        </form>            	
            </div>
            <div class="modal-footer">
                    <button type="submit" form="makeCompanySubscrip{{$company->id}}" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach