<div class="company-card card">

  <a href="{{urldecode(route('user.company',['name'=>str_replace([' ','/'], '-',$company->name),'id'=>$company->id]))}}">
    <div class="img-holder">
      <img class="img-fluid lazyload" data-src="{{ asset('storage/'.$company->logo) }}" src="{{ asset('storage/'.$company->logo) }}"  alt="@lang('home.ElectricalEquipment')|{{$company->name}}" />
    </div>

    <h5>{{$company->name}}
      @if($company->subscriptions)
        @if($company->subscriptions->pending==0)
          <span style="display: inline-block;"  title="@lang('home.hasSubscription')"><img  width="20" data-src="{{ asset('frontend_plugins/web/images/right-mark.png')}}" class="lazyload" alt="subscription" /></span>
        @endif
      @endif
    </h5>
    <h5>
    @if($company->hasProducts())
    <span style="display: inline-block;" title="@lang('home.hasProducts')"><img  width="25" data-src="{{ asset('frontend_plugins/web/images/Gold_Supplier_Icon.png')}}" class="lazyload" alt="company-has-product-icon" /></span>
    @endif
    </h5>
  </a>
      {{-- @if(isLogged()) --}}


        <a style="color:white" data-telephone="tel:{{$company->pri_contact_phone}}"
           class="primary-dark-fill w-100 sm-btn text-nowrap call-company call-tel-style"
           data-route="{{route('user.company-call')}}" data-company="{{$company->id}}" data-company-name="{{$company->name}}">
            <!-- call-tel-style -->
            <span class="text"><img src="{{ asset('frontend_plugins/web/images/phone-call.svg')}}" width="17" class="mr-2 d-inline" alt="phone">@lang('home.callCompanyNow')</span>
            <span class="tel">{{$company->pri_contact_phone}}</span>
        </a>
    {{-- @else
        <a style="color:white"  id="com-data" data-company="{{$company->id}}" data-company-name="{{$company->name}}" data-toggle="modal" data-target="#LoginModal"
           class="primary-dark-fill w-100 sm-btn call-company-login text-nowrap call-tel-style">
                              <span class="text"><img src="{{ asset('frontend_plugins/web/images/phone-call.svg')}}" width="17" class="mr-2 d-inline" alt="phone">@lang('home.callCompanyNow')</span>
                              <span class="tel">{{$company->pri_contact_phone}}
                              </span>
        </a>
    @endif --}}
    @if( ! $company->whatsup_number == null)
    <a data-company="{{$company->id}}" href="https://api.whatsapp.com/send?phone={{$company->whatsup_number}}" target="_blank" class="whatsClick whatsapp-fill w-100 sm-btn mt-2">
        <img data-src="{{ asset('frontend_plugins/web/images/whatsapp.svg')}}" class="mr-2 lazyload" width="19" alt="">
        @lang('home.sendWhatsapp')
    </a>
@endif
  <div class="details">
    @if(count($company->areas))
    <address>
      <img data-src="{{ asset('frontend_plugins/web/images/location.png')}}" class="lazyload" alt="location" />
      @lang('home.area') :  @foreach($company->areas as $area)
      {{$area->name}},
      @endforeach
    </address>
    @endif
    @if(count($company->company_types))
    <div class="location">
      <img data-src="{{ asset('frontend_plugins/web/images/agent.png')}}" class="lazyload" alt="agent" /> @lang('home.businessType'):
      @foreach($company->company_types as $type)
      {{$type->name}},
      @endforeach
    </div>
    @endif
    <time>
      <img data-src="{{ asset('frontend_plugins/web/images/date.png')}}" class="lazyload" alt="date" /> @lang('home.yearEstablished') : {{date('Y', strtotime($company->date) )}}
    </time>
  </div>
</div>
