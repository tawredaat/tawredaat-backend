<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close">
    </i>
</button>
<div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1"
        m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item  @yield('dashboard-active')" aria-haspopup="true">
                <a href="{{ route('company.home') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph">
                    </i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Dashboard
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  @yield('subscription-active')" aria-haspopup="true">
                <a href="{{ route('company.subscription') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon fas fa-money-check">
                    </i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">My Current Subscription
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item @yield('admins-active')  m-menu__item--submenu" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-users">
                    </i>
                    <span class="m-menu__link-text">Admins
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right">
                    </i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow">
                    </span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @yield('admins-create-active')" aria-haspopup="true">
                            <a href="{{ route('company.admins.create') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">Add new
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('admins-view-active')" aria-haspopup="true">
                            <a href="{{ route('company.admins.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">View all
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item  @yield('members-active')  m-menu__item--submenu" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-users">
                    </i>
                    <span class="m-menu__link-text">Team Members
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right">
                    </i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow">
                    </span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @yield('members-create-active')" aria-haspopup="true">
                            <a href="{{ route('company.members.create') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">Add new
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('members-view-active')" aria-haspopup="true">
                            <a href="{{ route('company.members.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">View all
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item  @yield('rfq-active')  m-menu__item--submenu" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-address-book">
                    </i>
                    <span class="m-menu__link-text">RFQs
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right">
                    </i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow">
                    </span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @yield('rfq-show-active')" aria-haspopup="true">
                            <a href="{{ route('company.rfqs') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">View rfqs
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('members-show-responded-active')" aria-haspopup="true">
                            <a href="{{ route('company.responded.rfqs') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">Responded rfqs
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item  @yield('productrfq-active')  m-menu__item--submenu" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-address-book">
                    </i>
                    <span class="m-menu__link-text">Products RFQs
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right">
                    </i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow">
                    </span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @yield('productrfq-show-active')" aria-haspopup="true">
                            <a href="{{ route('company.product-rfqs') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">View rfqs
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item  @yield('branches-active') m-menu__item--submenu" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fas fa-code-branch">
                    </i>
                    <span class="m-menu__link-text">Branches
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right">
                    </i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow">
                    </span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @yield('branches-create-active')" aria-haspopup="true">
                            <a href="{{ route('company.branches.create') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">Add new
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('branches-view-active')" aria-haspopup="true">
                            <a href="{{ route('company.branches.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">View all
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item  @yield('areas-active')  m-menu__item--submenu" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-area-chart">
                    </i>
                    <span class="m-menu__link-text">Areas of operation
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right">
                    </i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow">
                    </span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @yield('areas-create-active')" aria-haspopup="true">
                            <a href="{{ route('company.areasOperations.create') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">Add new
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('areas-view-active')" aria-haspopup="true">
                            <a href="{{ route('company.areasOperations.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">View all
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item @yield('company_types-active')  m-menu__item--submenu" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon   fa fa-file-text-o">
                    </i>
                    <span class="m-menu__link-text">Types
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right">
                    </i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow">
                    </span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @yield('company_types-create-active')" aria-haspopup="true">
                            <a href="{{ route('company.types.create') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">Add new
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('company_types-view-active')" aria-haspopup="true">
                            <a href="{{ route('company.types.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">View all
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item @yield('certificates-active') m-menu__item--submenu" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-certificate">
                    </i>
                    <span class="m-menu__link-text">Certificates
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right">
                    </i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow">
                    </span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @yield('certificates-create-active')" aria-haspopup="true">
                            <a href="{{ route('company.certificate.create') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">Add new
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('certificates-view-active')" aria-haspopup="true">
                            <a href="{{ route('company.certificate.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">View all
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!--            <li class="m-menu__item @yield('products-active')  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
<a href="javascript:;" class="m-menu__link m-menu__toggle">
<i class="m-menu__link-icon fa fa-product-hunt"></i>
<span class="m-menu__link-text">Products</span>
<i class="m-menu__ver-arrow la la-angle-right"></i>
</a>
<div class="m-menu__submenu ">
<span class="m-menu__arrow"></span>
<ul class="m-menu__subnav">
<li class="m-menu__item @yield('products-assign-active')" aria-haspopup="true">
<a href="{{ route('company.products.create') }}" class="m-menu__link ">
<i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
<span></span>
</i>
<span class="m-menu__link-text">Assign new</span>
</a>
</li>
<li class="m-menu__item @yield('products-view-active')" aria-haspopup="true">
<a href="{{ route('company.products.index') }}" class="m-menu__link ">
<i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
<span></span>
</i>
<span class="m-menu__link-text">View all</span>
</a>
</li>
</ul>
</div>
</li> -->
            <li class="m-menu__item @yield('products-new-active')  m-menu__item--submenu" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-product-hunt">
                    </i>
                    <span class="m-menu__link-text">Products
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right">
                    </i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow">
                    </span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @yield('products-assign-new-active')" aria-haspopup="true">
                            <a href="{{ route('company.products.selectBrands') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">Assign new
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('products-view-new-active')" aria-haspopup="true">
                            <a href="{{ route('company.products.view') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">View all
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item  @yield('brand-active')  m-menu__item--submenu" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="{{ route('company.view.brands') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-xing">
                    </i>
                    <span class="m-menu__link-text">Brands
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu @yield('reports-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-file">
                    </i>
                    <span class="m-menu__link-text">Reports
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right">
                    </i>
                </a>
                <div class="m-menu__submenu">
                    <span class="m-menu__arrow">
                    </span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @yield('reports-moreInfo-active')" aria-haspopup="true">
                            <a href="{{ route('company.moreInfo') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">
                                    More info btn clicks
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('reports-general-rfq-active')" aria-haspopup="true">
                            <a href="{{ route('company.products.rfq') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">
                                    General RFQs
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('reports-product-rfq-active')" aria-haspopup="true">
                            <a href="{{ route('company.product.rfq') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">
                                    Product RFQs
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('reports-callbacks-active')" aria-haspopup="true">
                            <a href="{{ route('company.callbacks') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">
                                    Call Now Requests
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('reports-pdfs-active')" aria-haspopup="true">
                            <a href="{{ route('company.pdfs') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">
                                    PDF Downloads
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @yield('reports-viewInformation-active')" aria-haspopup="true">
                            <a href="{{ route('company.viewInformation') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span>
                                    </span>
                                </i>
                                <span class="m-menu__link-text">
                                    Profile Views
                                </span>
                            </a>
                        </li>
                        {{--                           
            <li class="m-menu__item " aria-haspopup="true">
              <a href="{{ route('owner.quotations') }}" class="m-menu__link ">
                <i
                   class="m-menu__link-bullet m-menu__link-bullet--dot">
                  <span>
                  </span>
                </i>
                <span class="m-menu__link-text">
                  طلب عرض الاسعار
                </span>
              </a>
            </li>  --}}
                    </ul>
                </div>
            </li>
            <li class="m-menu__item  @yield('companies-active')  m-menu__item--submenu" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="{{ route('company.companies.edit', auth('company')->user()->id) }}"
                    class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-cog">
                    </i>
                    <span class="m-menu__link-text">Settings
                    </span>
                </a>
            </li>
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
