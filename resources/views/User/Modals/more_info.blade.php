<div class="modal fade" id="InfoModalCenter" tabindex="-1" role="dialog"
     aria-labelledby="RequestQuotationModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="InfoModalLongTitle">@lang('home.companyInformationMore')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;
          </span>
        </button>
      </div>
      <div class="modal-body row">
        @if($company->company_phone)
        <div style="margin: 10px 0;" class="col-md-12">
          <span style="font-weight: bold;">@lang('home.PhoneNumber'):
          </span>{{$company->company_phone}}
        </div>
        @endif
        @if($company->company_email)
        <div style="margin: 10px 0;" class="col-md-12">
          <span style="font-weight: bold;">@lang('home.Email'):
          </span>{{$company->company_email}}
        </div>
        @endif
        @if($company->address)
        <div style="margin: 10px 0;" class="col-md-12">
          <span style="font-weight: bold;">@lang('home.Address'):
          </span>{{$company->address}}
        </div>
        @endif
        @if($company->pri_contact_name)
        <div style="margin: 10px 0;" class="col-md-12">
          <span style="font-weight: bold;">@lang('home.PrimaryName'):
          </span>{{$company->pri_contact_name}}
        </div>
        @endif
        @if($company->pri_contact_phone)
        <div style="margin: 10px 0;" class="col-md-12">
          <span style="font-weight: bold;">@lang('home.PrimaryPhone'):
          </span>{{$company->pri_contact_phone}}
        </div>
        @endif
        @if($company->pri_contact_email)
        <div style="margin: 10px 0;" class="col-md-12">
          <span style="font-weight: bold;">@lang('home.PrimaryEmail'):
          </span>{{$company->pri_contact_email}}
        </div>
        @endif
        @if($company->sales_mobile)
        <div style="margin: 10px 0;" class="col-md-12">
          <span style="font-weight: bold;">@lang('home.SalesMobile'):
          </span>{{$company->sales_mobile}}
        </div>
        @endif
        @if($company->map)
        <br>
        <div class="col-md-12" style="margin: 10px 0;">
          <span style="font-weight: bold;">@lang('home.MapLink'):
          </span>
          <br>
          <iframe id="iframeid"
                  width="450"
                  height="250"
                  style="border:0;margin: 10px 0;"
                  src="{!! $company->map !!}"
                  >
          </iframe>
        </div>
        @endif
        @if($company->facebook OR $company->linkedin OR $company->insta OR $company->youtube)
        <div
             style="width: 100%;text-align: center;background: #2e2e2e;margin: 13px 0;padding: 10px;"
             class="social-wrapper">
          @if($company->facebook)
          <a style="margin: 0 5px" target="_blank" href="{{$company->facebook}}">
            <img width="30"
                 src="{{ asset('frontend_plugins/web/images/facebook-app-symbol.svg') }}"
                 alt="facebook-icon"/>
          </a>
          @endif
          @if($company->insta)
          <a style="margin: 0 5px" target="_blank" href="{{$company->insta}}">
            <img width="30" src="{{ asset('frontend_plugins/web/images/instagram.svg')}}"
                 alt="instagram-icon"/>
          </a>
          @endif
          @if($company->linkedin)
          <a style="margin: 0 5px" target="_blank" href="{{$company->linkedin}}">
            <img width="30" src="{{ asset('frontend_plugins/web/images/linkedin.svg')}}"
                 alt="linkedin-icon"/>
          </a>
          @endif
          @if($company->youtube)
          <a style="margin: 0 5px" target="_blank" href="{{$company->youtube}}">
            <img width="30"
                 src="{{ asset('frontend_plugins/web/images/youtube-logotype.svg')}}"
                 alt="youtube-icon"/>
          </a>
          @endif
        </div>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('home.close')
        </button>
      </div>
    </div>
  </div>
</div>
