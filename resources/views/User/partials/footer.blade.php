<div class="container">
  <div class="content-wrapper">
    <div class="about-us" style="line-height: 25px">
      <div class="img-holder">
        <img data-src="{{ asset('storage/'.$setting->footer_logo) }}" class="lazyload" src="{{ asset('storage/'.$setting->footer_logo) }}" alt="@lang('home.ElectricalEquipment')|{{$setting->footerLogoAlt}}" />
      </div>
      <p>
        {!! $setting->description !!}
      </p>
    </div>
    <span class="divider">
    </span>
    <div class="contact-wrapper">
      <div class="helpful-links">
        <p class="footer-headline">@lang('home.helpfulLinks')
        </p>
        <ul>
          <li>
            <a href="{{route('login')}}">@lang('home.login')
            </a>
          </li>
          <li>
            <a href="{{route('website.signup')}}">@lang('home.registration')
            </a>
          </li>
          <li>
            <a href="">@lang('home.ourPartners')
            </a>
          </li>
          <li>
            <a href="{{ route('user.about') }}">@lang('home.aboutUs')
            </a>
          </li>
          <li>
            <a href="{{route('company.login')}}" target="_blank">@lang('home.companyRegistration')
            </a>
          </li>
          <li>
            <a href="{{ route('user.contact') }}">@lang('home.contactUs')
            </a>
          </li>
            <li>
                <a href="{{route('user.terms.conditions')}}">@lang('home.termsConditions')
                </a>
            </li>
            <li>
                <a href="{{route('user.privacy.policy')}}">@lang('home.privacyPolicy')
                </a>
            </li>
            <li>
                <a href="{{route('user.sell.policies')}}">@lang('home.sellPolicies')
                </a>
            </li>
        </ul>
      </div>
      <span class="divider">
      </span>
      <div class="contact-us">
        <p class="footer-headline">@lang('home.contactUs')
        </p>
        <div>
          <address>
            {{$setting->address}}
          </address>
          <div>
            @lang('home.phone'):
            <a href="tel:{{$setting->phone}}"> {{$setting->phone}}
            </a>
          </div>
          <div>
            @lang('home.mail'):
            <a href="mailto:customercare@souqkahraba.com"
               >{{$setting->email}}
            </a
              >
          </div>
        </div>
        <div class="social-wrapper">
          <p class="footer-headline">@lang('home.followUs')
          </p>
          @if($setting->facebook)
          <a target="_blank" href="{{$setting->facebook}}">
            <img data-src="{{ asset('frontend_plugins/web/images/facebook-app-symbol.svg') }}" class="lazyload" src="{{ asset('frontend_plugins/web/images/facebook-app-symbol.svg') }}" alt="@lang('home.ElectricalEquipment')|facebook-icon"/>
          </a>
          @endif
          @if($setting->insta)
          <a target="_blank" href="{{$setting->insta}}">
            <img data-src="{{ asset('frontend_plugins/web/images/instagram.svg')}}" class="lazyload" src="{{ asset('frontend_plugins/web/images/instagram.svg')}}" alt="@lang('home.ElectricalEquipment')|instagram-icon"/>
          </a>
          @endif
          @if($setting->linkedin)
          <a target="_blank" href="{{$setting->linkedin}}">
            <img data-src="{{ asset('frontend_plugins/web/images/linkedin.svg')}}" class="lazyload" src="{{ asset('frontend_plugins/web/images/linkedin.svg')}} alt="@lang('home.ElectricalEquipment')|linkedin-icon"/>
          </a>
          @endif
          @if($setting->youtube)
          <a target="_blank" href="{{$setting->youtube}}">
            <img data-src="{{ asset('frontend_plugins/web/images/youtube-logotype.svg')}}" class="lazyload" src="{{ asset('frontend_plugins/web/images/youtube-logotype.svg')}}" alt="@lang('home.ElectricalEquipment')|youtube-icon"/>
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="copy-right">{{date('Y')}} Souq Kahraba.© @lang('home.allRightsReserved')
  </div>
</div>
