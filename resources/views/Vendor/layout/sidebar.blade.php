<button class="m-aside-left-close  m-aside-left-close skin-new" id="m_aside_left_close_btn"><i
        class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left skin-new ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu skin-new m-aside-menu--submenu skin-new " m-menu-vertical="1"
        m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item  @yield('dashboard-active')" aria-haspopup="true">
                <a href="{{ route('vendor.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Dashboard</span>
                        </span>
                    </span>
                </a>
            </li>

            <!-- Start Vendor's info Module -->
            <li class="m-menu__item  m-menu__item--submenu @yield('vendors-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-info-circle" aria-hidden="true"></i>
                    <span class="m-menu__link-text">Your information</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">

                        <li class="m-menu__item @yield('vendor-view-active')" aria-haspopup="true">
                            <a href="{{ route('vendor.vendors.edit') }}" class="m-menu__link ">
                                <i class="m-menu__link-icon fa fa-eye" aria-hidden="true"></i>
                                <span></span>
                                </i>
                                <span class="m-menu__link-text">View Info</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- End Vendor's info Module -->



            <!-- Start Specifications Module -->
            <li class="m-menu__item  m-menu__item--submenu @yield('specifications-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-product-hunt" aria-hidden="true"></i>
                    <span class="m-menu__link-text">Specifications</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">

                        <li class="m-menu__item @yield('specifications-view-active')" aria-haspopup="true">
                            <a href="{{ route('vendor.specifications.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">View all</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- End Specifications Module -->

            <!-- Start Shop Products Module -->
            <li class="m-menu__item  m-menu__item--submenu @yield('shop-products-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-shopping-basket" aria-hidden="true"></i>
                    <span class="m-menu__link-text">Shop Products</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @yield('shop-products-create-active')" aria-haspopup="true">
                            <a href="{{ route('vendor.shop-products.create') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Add new</span>
                            </a>
                        </li>


                        <li class="m-menu__item @yield('shop-products-view-active')" aria-haspopup="true">
                            <a href="{{ route('vendor.shop-products.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">View all</span>
                            </a>
                        </li>

                        <li class="m-menu__item @yield('shop-offers-products-view-active')" aria-haspopup="true">
                            <a href="{{ route('vendor.shop-product-offers.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-gift">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">View Offers</span>
                            </a>
                        </li>



                        <li class="m-menu__item @yield('shop-products-mass-active')" aria-haspopup="true">
                            <a href="{{ route('vendor.shop-products.import') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-upload">
                                    {{-- <i class="fa-solid fa-file-import"></i> --}}
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text"> Import mass uploads </span>
                            </a>
                        </li>


                        <li class="m-menu__item @yield('shop-products-pdfs-active')" aria-haspopup="true">
                            <a href="{{ route('vendor.shop-product-mass-pdfs.upload') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-upload">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text"> Upload PDFs</span>
                            </a>
                        </li>

                        <li class="m-menu__item @yield('shop-products-images-active')" aria-haspopup="true">
                            <a href="{{ route('vendor.shop-product-mass-images.upload') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-image">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text"> Upload Images</span>
                            </a>
                        </li>

                        <li class="m-menu__item @yield('shop-products-update-prices-active')" aria-haspopup="true">
                            <a href="{{ route('vendor.shop-products.update-prices') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-money">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text"> Update Prices </span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <!-- End Shop Products Module -->
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
