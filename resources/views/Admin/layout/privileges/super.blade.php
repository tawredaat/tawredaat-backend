<li class="m-menu__item  @yield('dashboard-active')" aria-haspopup="true">
    <a href="{{ route('admin.home') }}" class="m-menu__link ">
        <i class="m-menu__link-icon flaticon-line-graph"></i>
        <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
                <span class="m-menu__link-text">Dashboard</span>
            </span>
        </span>
    </a>
</li>
<li class="m-menu__item  m-menu__item--submenu @yield('rfqs-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="{{ route('admins.rfqs.index') }}" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-quote-right" aria-hidden="true"></i>
        <span class="m-menu__link-text">User RFQs</span>
    </a>
</li>
<li class="m-menu__item  m-menu__item--submenu @yield('admins-active')" aria-haspopup="true" m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-users"></i>
        <span class="m-menu__link-text">Admins</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('admins-create-active')" aria-haspopup="true">
                <a href="{{ route('admins.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('admins-view-active')" aria-haspopup="true">
                <a href="{{ route('admins.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="m-menu__item  m-menu__item--submenu @yield('seo-active')" aria-haspopup="true" m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-users"></i>
        <span class="m-menu__link-text">SEO</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('admins-view-active')" aria-haspopup="true">
                <a href="{{ route('seo.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="m-menu__item  m-menu__item--submenu @yield('users-active')" aria-haspopup="true" m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-users"></i>
        <span class="m-menu__link-text">Users</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('users-create-active')" aria-haspopup="true">
                <a href="{{ route('users.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('users-view-active')" aria-haspopup="true">
                <a href="{{ route('users.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="m-menu__item  m-menu__item--submenu @yield('users-active')" aria-haspopup="true" m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-users"></i>
        <span class="m-menu__link-text">Dayra Users</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('users-view-active')" aria-haspopup="true">
                <a href="{{ route('dayra.users') }}"" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>



<li class="m-menu__item  m-menu__item--submenu @yield('notifications-active')" aria-haspopup="true" m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-bell"></i>
        <span class="m-menu__link-text">Notifications</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('notifications-create-active')" aria-haspopup="true">
                <a href="{{ route('notifications.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">New</span>
                </a>
            </li>

            <li class="m-menu__item @yield('notifications-view-active')" aria-haspopup="true">
                <a href="{{ route('notifications.view') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<!-- <li class="m-menu__item  m-menu__item--submenu @yield('units-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-balance-scale"></i>
        <span class="m-menu__link-text">Units</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('units-create-active')" aria-haspopup="true">
                <a href="{{ route('units.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('units-view-active')" aria-haspopup="true">
                <a href="{{ route('units.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li> -->

<!-- <li class="m-menu__item  m-menu__item--submenu @yield('areas-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-area-chart"></i>
        <span class="m-menu__link-text">Areas</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('areas-create-active')" aria-haspopup="true">
                <a href="{{ route('areas.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('areas-view-active')" aria-haspopup="true">
                <a href="{{ route('areas.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li> -->

<li class="m-menu__item  m-menu__item--submenu @yield('cities-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-area-chart"></i>
        <span class="m-menu__link-text">Cities</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('cities-create-active')" aria-haspopup="true">
                <a href="{{ route('cities.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('cities-view-active')" aria-haspopup="true">
                <a href="{{ route('cities.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="m-menu__item  m-menu__item--submenu @yield('blogs-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-clipboard"></i>
        <span class="m-menu__link-text">Blogs</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('blogs-create-active')" aria-haspopup="true">
                <a href="{{ route('blogs.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('blogs-view-active')" aria-haspopup="true">
                <a href="{{ route('blogs.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>




<!-- <li class="m-menu__item  m-menu__item--submenu @yield('countries-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-flag"></i>
        <span class="m-menu__link-text">Countries</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('countries-create-active')" aria-haspopup="true">
                <a href="{{ route('countries.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('countries-view-active')" aria-haspopup="true">
                <a href="{{ route('countries.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li> -->
<!--
<li class="m-menu__item  m-menu__item--submenu @yield('companies-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-building-o"></i>
        <span class="m-menu__link-text">Companies</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('companies-create-active')" aria-haspopup="true">
                <a href="{{ route('companies.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('companies-view-active')" aria-haspopup="true">
                <a href="{{ route('companies.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>

            <li class="m-menu__item @yield('companies-join-active')" aria-haspopup="true">
                <a href="{{ route('company.join') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Join requests</span>
                </a>
            </li>

            <li class="m-menu__item @yield('companies-subscriped-active')" aria-haspopup="true">
                <a href="{{ route('subscriptions.companies') . '?type=active' }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Subscribed companies</span>
                </a>
            </li>

            <li class="m-menu__item @yield('companies-expired-active')" aria-haspopup="true">
                <a href="{{ route('subscriptions.companies') . '?type=expire' }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Expired companies</span>
                </a>
            </li>
            <li class="m-menu__item @yield('companies-requests-active')" aria-haspopup="true">
                <a href="{{ route('subscriptions.requests') . '?type=renew' }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Subscription requests</span>
                </a>
            </li>

        </ul>
    </div>
</li> -->

<!-- <li class="m-menu__item  m-menu__item--submenu @yield('companyTypes-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-building-o"></i>
        <span class="m-menu__link-text">Company Types</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item  @yield('companyTypes-create-active')" aria-haspopup="true">
                <a href="{{ route('company_types.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('companyTypes-view-active')" aria-haspopup="true">
                <a href="{{ route('company_types.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li> -->

<li class="m-menu__item  m-menu__item--submenu @yield('productsSpecs-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-product-hunt" aria-hidden="true"></i>
        <span class="m-menu__link-text">Products Specs</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('productsSpecs-create-active')" aria-haspopup="true">
                <a href="{{ route('productSpecs.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('productsSpecs-view-active')" aria-haspopup="true">
                <a href="{{ route('productSpecs.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>





<!--
<li class="m-menu__item  m-menu__item--submenu @yield('quantity-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-product-hunt" aria-hidden="true"></i>
        <span class="m-menu__link-text">Quantity Types</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('quantity-create-active')" aria-haspopup="true">
                <a href="{{ route('quantityTypes.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('quantity-view-active')" aria-haspopup="true">
                <a href="{{ route('quantityTypes.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li> -->



<li class="m-menu__item  m-menu__item--submenu @yield('categories-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-list-alt" aria-hidden="true"></i>
        <span class="m-menu__link-text">All Categories</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('categories-create-active')" aria-haspopup="true">
                <a href="{{ route('categories.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('categories-view-active')" aria-haspopup="true">
                <a href="{{ route('categories.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>
{{-- <li class="m-menu__item  m-menu__item--submenu @yield('categories-level3-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="{{ route('categories.level3.index') }}" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-list-alt" aria-hidden="true"></i>
        <span class="m-menu__link-text">Level Three Categories</span>
    </a>
</li> --}}
<li class="m-menu__item  m-menu__item--submenu @yield('brands-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-xing" aria-hidden="true"></i>
        <span class="m-menu__link-text">Brands</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('brands-create-active')" aria-haspopup="true">
                <a href="{{ route('brands.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('brands-view-active')" aria-haspopup="true">
                <a href="{{ route('brands.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
            {{-- <li class="m-menu__item @yield('brands-companies-view-active')" aria-haspopup="true">
                <a href="{{ route('brand.CompaniesRequests') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Companies Requests</span>
                </a>
            </li> --}}
        </ul>
    </div>
</li>

<!-- <li class="m-menu__item  m-menu__item--submenu @yield('products-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-product-hunt" aria-hidden="true"></i>
        <span class="m-menu__link-text">Products</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('products-create-active')" aria-haspopup="true">
                <a href="{{ route('products.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Add new</span>
                </a>
            </li>
            <li class="m-menu__item @yield('products-view-active')" aria-haspopup="true">
                <a href="{{ route('products.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
            <li class="m-menu__item @yield('products-mass-active')" aria-haspopup="true">
                <a href="{{ route('products.import.csv') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-file">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Import  mass uploads </span>
                </a>
            </li>
            <li class="m-menu__item @yield('products-pdfs-active')" aria-haspopup="true">
                <a href="{{ route('products.upload.PDF') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-file">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Upload PDFs</span>
                </a>
            </li>
            <li class="m-menu__item @yield('products-images-active')" aria-haspopup="true">
                <a href="{{ route('products.upload.image') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-image">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Upload Images</span>
                </a>
            </li>

        </ul>
    </div>
</li> -->
<li class="m-menu__item  m-menu__item--submenu @yield('shop-products-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa  fa-shopping-basket" aria-hidden="true"></i>
        <span class="m-menu__link-text">Shop Products</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('shop-products-create-active')" aria-haspopup="true">
                <a href="{{ route('shop.products.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Add new</span>
                </a>
            </li>
            <li class="m-menu__item @yield('shop-products-view-active')" aria-haspopup="true">
                <a href="{{ route('shop.products.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
            <li class="m-menu__item @yield('shop-offers-products-view-active')" aria-haspopup="true">
                <a href="{{ route('shop.offers.products.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View Offers</span>
                </a>
            </li>
            <li class="m-menu__item @yield('shop-products-mass-active')" aria-haspopup="true">
                <a href="{{ route('shop.products.import.csv') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-file">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Import mass uploads </span>
                </a>
            </li>
            <li class="m-menu__item @yield('shop-products-pdfs-active')" aria-haspopup="true">
                <a href="{{ route('shop.products.upload.PDF') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-file">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Upload PDFs</span>
                </a>
            </li>
            <li class="m-menu__item @yield('shop-products-images-active')" aria-haspopup="true">
                <a href="{{ route('shop.products.upload.image') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-image">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Upload Images</span>
                </a>
            </li>
            <li class="m-menu__item @yield('shop-products-update-prices-active')" aria-haspopup="true">
                <a href="{{ route('shop.products.update.prices') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-file">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Update Prices </span>
                </a>
            </li>
            <li class="m-menu__item @yield('shop-products-update-quantities-active')" aria-haspopup="true">
                <a href="{{ route('shop.products.update.quantities') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-file">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Update Quantities </span>
                </a>
            </li>
            <li class="m-menu__item @yield('shop-products-update-detalis-active')" aria-haspopup="true">
                <a href="{{ route('shop.products.update.details') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-file">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Update Details </span>
                </a>
            </li>
            <li class="m-menu__item @yield('shop-products-update-detalis-active')" aria-haspopup="true">
                <a href="{{ route('shop.products.update.offers') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-file">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Update Offers </span>
                </a>
            </li>                                      
        </ul>
    </div>
</li>

<li class="m-menu__item  m-menu__item--submenu @yield('bundels-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa  fa-gift" aria-hidden="true"></i>
        <span class="m-menu__link-text">Bundels</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('bundels-create-active')" aria-haspopup="true">
                <a href="{{ route('bundels.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Add new</span>
                </a>
            </li>
            <li class="m-menu__item @yield('bundels-mass-active')" aria-haspopup="true">
                <a href="{{ route('bundels.import.csv') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-file">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Import  mass uploads </span>
                </a>
            </li>
            <li class="m-menu__item @yield('bundels-view-active')" aria-haspopup="true">
                <a href="{{ route('bundels.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
            <li class="m-menu__item @yield('bundels-view-active')" aria-haspopup="true">
                <a href="{{ route('bundel.banners.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View Banners</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="m-menu__item  m-menu__item--submenu @yield('dynamic-page-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fas fa-file-alt" aria-hidden="true"></i> <!-- Changed to a document-like icon -->
        <span class="m-menu__link-text">Dynamic Page</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('dynamic-page-create-active')" aria-haspopup="true">
                <a href="{{ route('dynamic-page.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fas fa-plus-circle">
                        <span></span>
                    </i> <!-- Changed to a 'plus-circle' icon -->
                    <span class="m-menu__link-text"> Add new</span>
                </a>
            </li>
            <li class="m-menu__item @yield('dynamic-page-view-active')" aria-haspopup="true">
                <a href="{{ route('dynamic-page.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fas fa-th-list">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="m-menu__item  m-menu__item--submenu @yield('offer-packages-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa  fa-gift" aria-hidden="true"></i>
        <span class="m-menu__link-text">Offer Packages</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('offer-packages-create-active')" aria-haspopup="true">
                <a href="{{ route('shop.offerPackages.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text"> Add new</span>
                </a>
            </li>
            <li class="m-menu__item @yield('offer-packages-view-active')" aria-haspopup="true">
                <a href="{{ route('shop.offerPackages.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="m-menu__item  m-menu__item--submenu @yield('orders-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-shopping-cart" aria-hidden="true"></i>
        <span class="m-menu__link-text">Orders</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('orders-view-active')" aria-haspopup="true">
                <a href="{{ route('orders.index') }}" class="m-menu__link  ">
                    <i class="m-menu__link-bullet m-menu__link-icon  fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View</span>
                </a>
            </li>
            <li class="m-menu__item @yield('orders-cancelled-view-active')" aria-haspopup="true">
                <a href="{{ route('orders.cancelled.index') }}" class="m-menu__link  ">
                    <i class="m-menu__link-bullet m-menu__link-icon  fa fa-times">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Cancelled</span>
                </a>
            </li>

            <li class="m-menu__item @yield('orders-create-active')" aria-haspopup="true">
                <a href="{{ route('orders.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="m-menu__item  m-menu__item--submenu @yield('orderStatus-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fas fa-battery-half" aria-hidden="true"></i>
        <span class="m-menu__link-text">Order Status</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('orderStatus-create-active')" aria-haspopup="true">
                <a href="{{ route('order_statuses.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('orderStatus-view-active')" aria-haspopup="true">
                <a href="{{ route('order_statuses.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="m-menu__item  m-menu__item--submenu @yield('promoCodes-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-tags" aria-hidden="true"></i>
        <span class="m-menu__link-text">PromoCodes</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('promoCodes-create-active')" aria-haspopup="true">
                <a href="{{ route('promocodes.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('promoCodes-view-active')" aria-haspopup="true">
                <a href="{{ route('promocodes.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="m-menu__item  m-menu__item--submenu @yield('payments-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-credit-card" aria-hidden="true"></i>
        <span class="m-menu__link-text">Payments</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('payments-create-active')" aria-haspopup="true">
                <a href="{{ route('payments.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('payments-view-active')" aria-haspopup="true">
                <a href="{{ route('payments.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
            
            <li class="m-menu__item @yield('payments-view-active')" aria-haspopup="true">
                <a href="{{ route('payment_notes.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Payment Notes</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<!-- <li  class="m-menu__item  m-menu__item--submenu @yield('interests-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-thumbs-up" aria-hidden="true"></i>
        <span class="m-menu__link-text">Interests</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('interests-create-active')" aria-haspopup="true">
                <a href="{{ route('interests.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('interests-view-active')" aria-haspopup="true">
                <a href="{{ route('interests.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li> -->
<li class="m-menu__item  m-menu__item--submenu @yield('banners-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fas fa-image" aria-hidden="true"></i>
        <span class="m-menu__link-text">Home Banners</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('banners-create-active')" aria-haspopup="true">
                <a href="{{ route('banners.home.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new Banner For Home Page</span>
                </a>
            </li>

            <!--<li class="m-menu__item @yield('banners-create-active')" aria-haspopup="true">-->
            <!--    <a href="{{ route('banners.create.second') }}" class="m-menu__link ">-->
            <!--        <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">-->
            <!--            <span></span>-->
            <!--        </i>-->
            <!--        <span class="m-menu__link-text">Add new Banner For Section two</span>-->
            <!--    </a>-->
            <!--</li>-->

            <!--<li class="m-menu__item @yield('banners-create-active')" aria-haspopup="true">-->
            <!--    <a href="{{ route('banners.create.third') }}" class="m-menu__link ">-->
            <!--        <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">-->
            <!--            <span></span>-->
            <!--        </i>-->
            <!--        <span class="m-menu__link-text">Add new Banner For Section Three</span>-->
            <!--    </a>-->
            <!--</li>-->

            {{-- <li class="m-menu__item @yield('banners-ads-active')" aria-haspopup="true">
                <a href="{{ route('admin.banners.ads') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Control Ads in banners</span>
                </a>
            </li> --}}
            <li class="m-menu__item @yield('banners-view-active')" aria-haspopup="true">
                <a href="{{ route('banners.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="m-menu__item  m-menu__item--submenu @yield('vendors-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-users" aria-hidden="true"></i>
        <span class="m-menu__link-text">Vendors</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('vendors-create-active')" aria-haspopup="true">
                <a href="{{ route('vendors.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('vendors-view-active')" aria-haspopup="true">
                <a href="{{ route('vendors.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<!-- <li class="m-menu__item  m-menu__item--submenu @yield('shop-banners-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fas fa-image" aria-hidden="true"></i>
        <span class="m-menu__link-text">Shop Banners</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('shop-banners-create-active')" aria-haspopup="true">
                <a href="{{ route('shop.banners.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('shop-banners-view-active')" aria-haspopup="true">
                <a href="{{ route('shop.banners.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>
        </ul>
    </div>
</li> -->
<!-- <li class="m-menu__item  m-menu__item--submenu @yield('ads-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fas fa-image" aria-hidden="true"></i>
        <span class="m-menu__link-text">Google Ads</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">

            <li class="m-menu__item @yield('ads-brands-active')" aria-haspopup="true">
                <a href="{{ route('brand.image') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">AD in the Brand</span>
                </a>
            </li>
            <li class="m-menu__item @yield('ads-brands-active')" aria-haspopup="true">
                <a href="{{ route('company.image') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">AD in the Company</span>
                </a>
            </li>
        </ul>
    </div>
</li> -->
<!-- <li class="m-menu__item  m-menu__item--submenu @yield('advertisings-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon far fa-lightbulb" aria-hidden="true"></i>
        <span class="m-menu__link-text">Advertisings</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('advertisings-create-company-active')" aria-haspopup="true">
                <a href="{{ route('advertisings.create') . '?type=company' }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">New company Ad</span>
                </a>
            </li>

            <li class="m-menu__item @yield('advertisings-create-category-active')" aria-haspopup="true">
                <a href="{{ route('advertisings.create') . '?type=category' }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">New category Ad</span>
                </a>
            </li>
            <li class="m-menu__item @yield('advertisings-create-brand-active')" aria-haspopup="true">
                <a href="{{ route('advertisings.create') . '?type=brand' }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">New brand Ad</span>
                </a>
            </li>
            <li class="m-menu__item @yield('advertisings-create-product-active')" aria-haspopup="true">
                <a href="{{ route('advertisings.create') . '?type=product' }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">New product Ad</span>
                </a>
            </li>
            <li class="m-menu__item @yield('advertisings-view-company-active')" aria-haspopup="true">
                <a href="{{ route('advertisings.index') . '?type=company' }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View Company Ad</span>
                </a>
            </li>
            <li class="m-menu__item @yield('advertisings-view-category-active')" aria-haspopup="true">
                <a href="{{ route('advertisings.index') . '?type=category' }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View Category Ad</span>
                </a>
            </li>
            <li class="m-menu__item @yield('advertisings-view-brand-active')" aria-haspopup="true">
                <a href="{{ route('advertisings.index') . '?type=brand' }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View Brand Ad</span>
                </a>
            </li>
        <li class="m-menu__item @yield('advertisings-view-product-active')" aria-haspopup="true">
                <a href="{{ route('advertisings.index') . '?type=product' }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View Product Ad</span>
                </a>
            </li>
        </ul>
    </div>
</li> -->
<!--
<li class="m-menu__item  m-menu__item--submenu @yield('subscriptions-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-envelope-open-o" aria-hidden="true"></i>
        <span class="m-menu__link-text">Subscriptions</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('subscriptions-create-active')" aria-haspopup="true">
                <a href="{{ route('subscriptions.create') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Add new</span>
                </a>
            </li>

            <li class="m-menu__item @yield('subscriptions-view-active')" aria-haspopup="true">
                <a href="{{ route('subscriptions.index') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">View all</span>
                </a>
            </li>

            <li class="m-menu__item @yield('subscriptions-assign-active')" aria-haspopup="true">
                <a href="{{ route('subscribe.company') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Assign to company</span>
                </a>
            </li>
        </ul>
    </div>
</li> -->
<!-- Search Store -->
<li class="m-menu__item  m-menu__item--submenu @yield('search-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-key" aria-hidden="true"></i>
        <span class="m-menu__link-text">Search Store</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item @yield('search-product-active')" aria-haspopup="true">
                <a href="{{ route('search.store.product') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Search in products</span>
                </a>
            </li>
            <li class="m-menu__item @yield('search-company-active')" aria-haspopup="true">
                <a href="{{ route('search.store.company') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Search in companies</span>
                </a>
            </li>
            <li class="m-menu__item @yield('search-brand-active')" aria-haspopup="true">
                <a href="{{ route('search.store.brand') }}" class="m-menu__link ">
                    <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                        <span></span>
                    </i>
                    <span class="m-menu__link-text">Search in brands</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="m-menu__item  m-menu__item--submenu @yield('pages-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-eye" aria-hidden="true"></i>
        <span class="m-menu__link-text">Pages</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--submenu @yield('terms-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="{{ route('terms.view') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-info" aria-hidden="true"></i>
                    <span class="m-menu__link-text">Terms & Conditions</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu @yield('sell-policies-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="{{ route('sell.policies.view') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-cart-plus" aria-hidden="true"></i>
                    <span class="m-menu__link-text">Sell Policies</span>
                </a>
            </li>

            <li class="m-menu__item  m-menu__item--submenu @yield('privacy-policy-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="{{ route('privacy.policy.view') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-lock" aria-hidden="true"></i>
                    <span class="m-menu__link-text">Privacy & Policy</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu @yield('refund_and_returns_policy-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="{{ route('refund-and-returns-policy.view') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-info" aria-hidden="true"></i>
                    <span class="m-menu__link-text">Refund and Returns Policy</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu @yield('faqs-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="{{ route('faqs.view') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-question-circle" aria-hidden="true"></i>
                    <span class="m-menu__link-text">FAQS</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="m-menu__item  m-menu__item--submenu @yield('settings-section-active')" aria-haspopup="true"
    m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon fa fa-bars" aria-hidden="true"></i>
        <span class="m-menu__link-text">Settings</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">

            <li class="m-menu__item  m-menu__item--submenu @yield('settings-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="{{ route('site.settings') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fas fa-cog" aria-hidden="true"></i>
                    <span class="m-menu__link-text">Settings</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu
            @yield('brand-store-banners-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="{{ route('brand-store-banners.index') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fas fa-cog" aria-hidden="true"></i>
                    <span class="m-menu__link-text">Brand Store Banner</span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu @yield('categories-brands-store-pages-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-cog" aria-hidden="true"></i>
                    <span class="m-menu__link-text">Featured Brands</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item @yield('categories-brands-store-pages-create-active')" aria-haspopup="true">
                            <a href="{{ route('categories-brands-store-pages.create') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-plus">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Add new</span>
                            </a>
                        </li>

                        <li class="m-menu__item @yield('categories-brands-store-pages-view-active')" aria-haspopup="true">
                            <a href="{{ route('categories-brands-store-pages.index') }}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-icon fa fa-eye">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">View all</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="m-menu__item  m-menu__item--submenu @yield('site-map-active')" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="{{ route('site.map') }}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-map-marker" aria-hidden="true"></i>
                    <span class="m-menu__link-text">Site Map</span>
                </a>
            </li>

        </ul>
    </div>
</li>
