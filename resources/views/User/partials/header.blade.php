<div class="top-header">
    <!-- <div class="container"> -->
        <ul class="first-links">
            <li>
                <a href="{{route('user.home')}}">@lang('home.home')
                </a>
            </li>
            <span class="seperator-holder"></span>
            <li>
                <a href="{{ route('user.about') }}">@lang('home.about')
                </a>
            </li>
            <span class="seperator-holder"></span>
            <li>
                <a href="{{ route('user.blogs') }}">@lang('home.blogs')
                </a>
            </li>
            <span class="seperator-holder"></span>
            <li>
                <a href="{{ route('user.contact') }}">@lang('home.contact')
                </a>
            </li>
            <span class="seperator-holder"></span>
            <li>
                <a href="{{route('joinus')}}">@lang('home.Getlisted')
                </a>
            </li>
        </ul>
        <a title="Choose language" href="{{$changeLangUrl}}" style="display: contents;font-weight: bold;color: #000"
        class="lang-holder">
        <img class="" src="{{$changeLangImg}}" alt="{{$changeLangAlt}}" width="30" height="30"/> <span
        style="margin-left: 5px;">{{$changeLangString}}</span>
        </a>
        <!-- <div class="second-links">
            <ul>
                <li>
                    <a href="">Create an Account</a>
                </li>
                <span class="seperator-holder"></span>
                <li>
                    <a href="">Daily Deals</a>
                </li>
                <span class="seperator-holder"></span>
                <li>
                    <a href="">Customer Service</a>
                </li>
                <span class="seperator-holder"></span>
                <li>
                    <a href="">Sell with Us</a>
                </li>
                <span class="seperator-holder"></span>
                <li>
                    <a href="">Track Order</a>
                </li>
                <span class="seperator-holder"></span>
                <li>
                    <a title="Choose language" href="{{$changeLangUrl}}" style="display: contents;font-weight: bold;color: #000"
                    class="lang-holder">
                    <img class="" src="{{$changeLangImg}}" alt="{{$changeLangAlt}}" width="30" height="30"/> <span
                    style="margin-left: 5px;">{{$changeLangString}}</span>
                    </a>
                </li>
            </ul>
    </div> -->
    <!-- </div> -->
</div>
<div class="container pl-0-phablet">
    <!-- start middle header -->
    <div class="middle-header">
        <div class="logo-holder d-flex">
            <div class="res-menu d-block d-lg-none">
                <button class="close-menu-btn">X
                </button>
                <ul class="" id="navAccordion">
                    <h3>@lang('home.menu')
                    </h3>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{route('user.home')}}"
                        >@lang('home.home')
                            <span class="sr-only">(@lang('home.current'))
              </span>
                        </a
                        >
                    </li>
                    @if(!Auth::guard('web')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('login')}}">@lang('home.login')
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.companies')}}">@lang('home.companies')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.products')}}">@lang('home.products')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.brands')}}">@lang('home.brands')
                        </a>
                    </li>
                    <li class="nav-item shop-item" style="osition: relative;border: solid 2px #23408d;padding: 1px;border-radius: 17px;">
                        <a class="nav-link" href="{{route('user.shop.products')}}">@lang('home.shop')</a>
                        {{-- <span class="new-btn">@lang('home.new')</span> --}}
                    </li>
                </ul>
                <div class="overlay">
                </div>
                <button>&#x2630;
                </button>
                {{-- <!-- <button><img src="images/Layer_5.svg" alt=""></button> --> --}}
            </div>
            <a href="{{route('user.home')}}" class="logo">
                <img src="{{ asset('storage/'.$setting->site_logo) }}" class="img-fluid"
                     alt="@lang('home.ElectricalEquipment')|{{$setting->siteLogoAlt}}"/>
            </a>
        </div>
        <div class="search-holder d-none d-lg-block">
            <form class="form-inline" action="{{route('user.search')}}" method="get">
                <select class="mr-3" class="search_type" name="search_type" id="">
                    <option
                        {{request()->input('search_type')=='products'?'selected':''}} value="products">@lang('home.browse') @lang('home.products')
                    </option>
                    <option
                        value="companies" {{request()->input('search_type')=='companies'?'selected':''}}>@lang('home.browse') @lang('home.companies')
                    </option>
                    <option
                        value="brands" {{request()->input('search_type')=='brands'?'selected':''}}>@lang('home.browse') @lang('home.brands')
                    </option>
                </select>
                <div class="input-group search-input">
                    <button type="submit">
                        <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                <img class="mr-1" src="{{ asset('frontend_plugins/web/images/search-icon.svg')}}"
                     alt="@lang('home.ElectricalEquipment')|search-icon"/> @lang('home.search')
              </span>
                        </div>
                    </button>
                    <input
                        type="text"
                        name="s"
                        value="{{request()->input('s')?request()->input('s'):''}}"
                        class="form-control"
                        placeholder="@lang('home.search') @lang('home.products'), @lang('home.companies') @lang('home.and')  @lang('home.brands')"
                        aria-label="Username"
                        aria-describedby="basic-addon1"/>
                </div>
            </form>
        </div>
        <div class="user-action">
            <!-- <select name="" id="">
      <option value="">login</option>
      <option value="">logout</option>
      </select> -->
            @if(!Auth::guard('web')->check())
                <div class="user-menu">
                    <div class="user-drop-holder">
                        <img class="header-item__img" src="{{asset('frontend_plugins/web/images/Sign-in-Icon.png')}}"
                             alt="@lang('home.ElectricalEquipment')|Signin">
                        <div class="curent">
                            <p>@lang('home.login')</p>
                            <p>@lang('home.JoinFree')</p></div>
                        </div>
                <!-- <div class="curent">@lang('home.hello') @lang('home.login')
                    </div> -->
                    <div class="content">
                        <h4>@lang('home.GetStartedNow')
                        </h4>
                        <button onclick='location.href="{{route('login')}}";'
                                class="primary-dark-fill">@lang('home.SignIn')
                        </button>
                        <span>@lang('home.or')
                        </span>
                        <button onclick='location.href="{{route('website.signup')}}";'
                                class="primary-dark-outline">@lang('home.JoinFree')
                        </button>
                        <div class="social-login">
                            <p>@lang('home.continueWith'):
                            </p>
                            <a href="{{route('redirect.facebook','facebook')}}">
                                <img src="{{ asset('frontend_plugins/web/images/facebook-app-symbol.svg')}}"
                                     alt="@lang('home.ElectricalEquipment')|facebook-login-icon"/>
                            </a>

                            <a href="{{route('redirect.facebook','google')}}">
                                <img style="background: none;"
                                     src="{{ asset('frontend_plugins/web/images/google.svg')}}"
                                     alt="@lang('home.ElectricalEquipment')|google-login-icon"/>
                            </a>
                        </div>


                    </div>
                </div>
            @elseif(Auth::guard('web')->check())
                <div class="dropdown">
                    <button class="dropbtn"><span
                            style="font-weight:bold" class="welcome-title">@lang('home.hello'), </span><span>{{auth('web')->user()->name}}</span>
                        <i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="{{route('user.account.settings')}}">@lang('home.settings')</a>
                        <a href="{{route('user.rfq.list')}}">@lang('home.rfqlist')</a>
                        <a href="{{route('user.product.rfq.list')}}">@lang('home.productrfq')</a>
                        <a href="{{route('logout')}}">@lang('home.logout')</a>
                    </div>
                </div>
            @endif
            {{-- <div class="cart header-item-holder">
                <div class="cart-img">
                    <img class="header-item__img" src="{{ asset('frontend_plugins/web/images/shopping-cart.svg')}}" alt="cart-icon"/>
                    <span class="cart-products-num">0</span>
                </div>
                <p class="header-item__title">@lang('home.cart')
                </p>
                <div class="cart-detailes">
                    <div class="cart-empty">
                        <h4>@lang('home.cartEmpty')
                        </h4>
                        <div class="empty-cart-img">
                            <img src="{{ asset('frontend_plugins/web/images/shopping-cart1.svg')}}" alt="">
                        </div>
                    </div>
                    <div>
                        <div class="img-holder">
                            <img src="{{ asset('frontend_plugins/web/images/cards/465_thumbnail.png')}}" alt="">
                        </div>
                        <p class="name">Terminal Block
                        </p>
                        <div class="amount">15
                        </div>
                        <div class="price">199 L.E
                        </div>
                    </div>
                    <div>
                        <div class="img-holder">
                            <img src="{{ asset('frontend_plugins/web/images/cards/728_thumbnail.png')}}" alt="">
                        </div>
                        <p class="name">Zs4 Screw Clamp
                        </p>
                        <div class="amount">5
                        </div>
                        <div class="price">199 L.E
                        </div>
                    </div>
                </div>
            </div> --}}
            <a href="{{route('user.rfq')}}" class="header-item-holder">
                <img class="header-item__img" src="{{ asset('frontend_plugins/web/images/RFQ-Icon.png')}}"
                     alt="@lang('home.ElectricalEquipment')|RFQ">
                <p class="header-item__title">@lang('home.rfq')</p>
            </a>
            <a href="{{route('user.view.myOrders')}}" class="header-item-holder">
                <img class="header-item__img" src="{{ asset('frontend_plugins/web/images/Orders-Icon.png')}}"
                     alt="@lang('home.ElectricalEquipment')|Orders">
                <p class="header-item__title">@lang('home.orders')</p>
            </a>
            <a href="{{route('user.view.cart')}}" class="header-item-holder header-cart-holder" style="position: relative;">
                <img class="header-item__img" src="{{ asset('frontend_plugins/web/images/cart-ce.svg')}}" alt="cart">
                <span class="cart-num-holder">
                    @if(auth('web')->user())
                        {{auth('web')->user()->items->count()}}
                    @else
                        {!! count(json_decode(stripslashes(\Cookie::get('shopping_cart')), true)?json_decode(stripslashes(\Cookie::get('shopping_cart')), true):[]) !!}
                    @endif
                </span>
                <!-- <p class="header-item__title">@lang('home.orders')</p> -->
            </a>
        </div>
    </div>
</div>
<!-- start bottom header -->
<div class="bottom-header d-none d-lg-block">
    <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container justify-content-start">
            <button
                class="navbar-toggler"
                data-target="#navbarSupportedContent"
                data-toggle="collapse"
                type="button">
        <span class="navbar-toggler-icon">
        </span>
            </button>
            <div class="collapse navbar-collapse px-0" id="navbarSupportedContent">
                <ul class="navbar-nav ">
                    <li class="nav-item dropdown categories-btn">
                        <a>
                            <img src="{{ asset('frontend_plugins/web/images/menu-icon.svg')}}"
                                 alt="@lang('home.ElectricalEquipment')|menu-icon"
                                 class="mr-15"/>@lang('home.categories')
                        </a>
                        <!-- <div class="container"> -->
                        <div class="dropdown-menu categories-menu-wrapper" id="categoriesWeb">
                        </div>
                        <!-- </div>  -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.companies')}}">@lang('home.companies')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.products')}}">@lang('home.products')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.brands')}}">@lang('home.brands')
                        </a>
                    </li>
                    <li class="nav-item shop-item">
                        <a class="nav-link" href="{{route('user.shop.products')}}">@lang('home.shop')</a>
                        <span class="new-btn">@lang('home.new')</span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="search-holder mb-3 d-block d-lg-none search-holder-res">
    <form class="form-inline w-100 justify-content-center" method="get" action="{{route('user.search')}}">
        <select class="search_type" name="search_type" id="">
            <option
                value="products" {{request()->input('search_type')=='products'?'selected':''}}>@lang('home.browse') @lang('home.products')
            </option>
            <option
                value="companies" {{request()->input('search_type')=='companies'?'selected':''}}>@lang('home.browse') @lang('home.companies')
            </option>
            <option
                value="brands" {{request()->input('search_type')=='brands'?'selected':''}}>@lang('home.browse') @lang('home.brands')
            </option>
        </select>
        <div class="input-group search-input d-flex w-100 w-sm-60 mx-2">
            <button type="submit">
                <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">
            <img src="{{ asset('frontend_plugins/web/images/search-icon.svg')}}"
                 alt="@lang('home.ElectricalEquipment')|search-icon"/>
          </span>
                </div>
            </button>
            <input
                type="text"
                name="s"
                value="{{request()->input('s')?request()->input('s'):''}}"
                class="form-control"
                placeholder="@lang('home.search') @lang('home.products'), @lang('home.companies'),@lang('home.brands')"
                aria-label="Username"
                aria-describedby="basic-addon1"/>
        </div>
    </form>
</div>
