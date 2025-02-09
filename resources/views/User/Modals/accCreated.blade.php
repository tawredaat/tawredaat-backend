<!-- start message modal -->

<div class="modal fade message-Modal" id="accCreated" tabindex="-1" role="dialog" aria-labelledby="messageModal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="complate-content-holder">
        <img src="{{asset('frontend_plugins/web/images/Greencheck.png')}}" alt="checked">
        {{-- <h2>Thank You</h2>
        <h6>your request has been sent</h6> --}}
        <h2>@lang('home.congratulations')</h2>
        <h6>@lang('home.accCreated')</h6>
        </div>
    </div>
    </div>
</div>
</div>
