        <div class="modal fade" id="RequestQuotationModal" tabindex="-1" role="dialog"
             aria-labelledby="RequestQuotationModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">@lang('home.requestGeneralQuotaion')
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
                        </button>
                    </div>
                    <form id="requestQuotationForm" action="{{route('user.request-general-quotaion')}}" method="post">
                        <input type="hidden" name="companyID" value="{{$company->id}}">
                        <div class="modal-body">
                            <div class="form-group">
                                <textarea rows="6" class="form-control" name="msg" id="msgQuotationBox"
                                          placeholder="@lang('home.msgQuotation')"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('home.close')
                            </button>
                            <button type="submit" class="btn btn-primary">@lang('home.request')
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
