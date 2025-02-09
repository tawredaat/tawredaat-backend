@extends('Admin.index')
@section('dashboard-active', 'm-menu__item--active')
@section('page-title', 'Dashboard')
@section('content')
@push('style')
<style type="text/css">
    .no-margins {
        color: #7fca7f;
    }

    .dashboard-stat {
        display: inline-block;
        padding: 0;
        height: 160px;
        background-color: #444;
        color: #fff;
        border-radius: 4px;
        width: 100%;
        position: relative;
        margin-bottom: 20px;
        overflow: hidden;
        transition: 0.3s;
        cursor: default;
    }

    .dashboard-stat:hover {
        transform: translateY(-4px);
    }

    .dashboard-stat-content {
        position: absolute;
        left: 32px;
        top: 50%;
        width: 45%;
        transform: translateY(-50%);
    }

    .dashboard-stat-content h4 {
        font-size: 42px;
        font-weight: 600;
        padding: 0;
        margin: 0;
        color: #fff;
        /*font-family: "Open Sans";*/
        letter-spacing: -1px;
    }

    .dashboard-stat-content span {
        font-size: 18px;
        margin-top: 4px;
        line-height: 24px;
        font-weight: 300;
        display: inline-block;
    }

    .dashboard-stat-icon {
        position: absolute;
        right: 32px;
        top: 50%;
        transform: translateY(-40%);
        font-size: 80px;
        opacity: 0.3;
    }

    .smaller-font {
        font-size: 40px;
    }

    /* Colors */
    .dashboard-stat.color-1 {
        background: linear-gradient(to left, rgba(255, 255, 255, 0) 25%, rgba(255, 255, 255, 0.2));
        background-color: #64bc36;
    }

    .dashboard-stat.color-2 {
        background: linear-gradient(to left, rgba(255, 255, 255, 0) 25%, rgba(255, 255, 255, 0.1));
        background-color: #363841;
    }

    .dashboard-stat.color-3 {
        background: linear-gradient(to left, rgba(255, 255, 255, 0) 25%, rgba(255, 255, 255, 0.3));
        background-color: #ffae00;
    }

    .dashboard-stat.color-4 {
        background: linear-gradient(to left, rgba(255, 255, 255, 0) 25%, rgba(255, 255, 255, 0.1));
        background-color: #f3103c;
    }

    .dashboard-stat.color-5 {
        background: linear-gradient(to left, rgba(255, 255, 255, 0) 25%, rgba(255, 255, 255, 0.1));
        background-color: rgb(228, 46, 137);
    }

    .dashboard-stat.color-6 {
        background: linear-gradient(to left, rgba(255, 255, 255, 0) 25%, rgba(255, 255, 255, 0.1));
        background-color: orange;
    }
</style>
@endpush
<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    <!-- BEGIN: Left Aside -->
    <!-- END: Left Aside -->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">Dashboard</h3>
                </div>
                <div>
                    <span style="display: none" class="m-subheader__daterange" id="m_dashboard_daterangepicker">
                        <span class="m-subheader__daterange-label">
                            <span class="m-subheader__daterange-title"></span>
                            <span class="m-subheader__daterange-date m--font-brand"></span>
                        </span>
                        <a href="#" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                            <i class="la la-angle-down"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <!-- Company Reuests -->
                <!-- <div class="col-lg-4 col-md-4">
               <div class="dashboard-stat color-1">                                                                                                                                                                                                                                                                                                                                                                                           </div>
                </div> -->
                <!-- Total Orders -->
                <div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-primary">
                        <a href="{{ route('orders.index') }}">
                            <div class="dashboard-stat-content">
                                <h4>{{ $gross_orders_count }}</h4>
                                <h6 style="color: #fff">All Orders Count</h6>
                              	<h4>{{ $gross_order_total }}</h4>
                                <h6 style="color: #fff">All Orders Value</h6>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>
              
              	<div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-success">
                        <a href="{{ route('orders.index') }}">
                            <div class="dashboard-stat-content">
                                <h4>{{ $deliverd_orders_count }}</h4>
                                <h6 style="color: #fff">Delivered Orders Count</h6>
                              	<h4>{{ $deliverd_orders_total }}</h4>
                                <h6 style="color: #fff">Delivered Orders Value</h6>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>
              
                <div class="col-lg-4 col-md-6">
                      <div class="dashboard-stat bg-danger">
                          <a href="{{ route('orders.index') }}">
                              <div class="dashboard-stat-content">
                                  <h4>{{ $cancelled_orders_count }}</h4>
                                  <h6 style="color: #fff">Cancelled Orders Count</h6>
                                  <h4>{{ $cancelled_orders_total }}</h4>
                                  <h6 style="color: #fff">Cancelled Orders Value</h6>
                              </div>
                              <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                          </a>
                      </div>
                  </div>
              
              <div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-primary">
                        <a href="{{ route('orders.index') }}">
                            <div class="dashboard-stat-content">
                                <h4>{{ $current_month_gross_orders_count }}</h4>
                                <h6 style="color: #fff">Month Orders Count</h6>
                              	<h4>{{ $current_month_gross_order_total }}</h4>
                                <h6 style="color: #fff">Month Order value</h6>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>
              
              	<div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-success">
                        <a href="{{ route('orders.index') }}">
                            <div class="dashboard-stat-content">
                                <h4>{{ $current_month_delivered_orders_count }}</h4>
                                <h6 style="color: #fff">Month Delivered Count</h6>
                              	<h4>{{ $current_month_delivered_orders_total }}</h4>
                                <h6 style="color: #fff">Month Delivered Value</h6>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>
              
                <div class="col-lg-4 col-md-6">
                      <div class="dashboard-stat bg-danger">
                          <a href="{{ route('orders.index') }}">
                              <div class="dashboard-stat-content">
                                  <h4>{{ $current_month__cancelled_orders_count }}</h4>
                                  <h6 style="color: #fff">Month Cancelled Count</h6>
                                  <h4>{{ $current_month_cancelled_orders_total }}</h4>
                                  <h6 style="color: #fff">Month Cancelled Value</h6>
                              </div>
                              <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                          </a>
                      </div>
                  </div>

                <div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-danger">
                        <a href="{{ route('admins.rfqs.index') }}" target="_blank">
                            <div class="dashboard-stat-content">
                                <h4>{{ userRfqs() }}</h4>
                                <h5 style="color: #fff">#User RFQs</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>
	
              	<div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-success">
                        <a href="{{ route('categories.index') }}" target="_blank">
                            <div class="dashboard-stat-content">
                                <h4>{{ CategoryLevelOne() }}</h4>
                                <h5 style="color: #fff">#Active Level One Categoris</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-dark">
                        <a href="{{ route('orders.index') }}">
                            <div class="dashboard-stat-content">
                                <h4 style="font-size:29px">{{ averageOrdersValue() }} EGP</h4>
                                <h5 style="color: #fff">Average Orders Value</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-info">
                        <a href="{{ route('orders.index') }}">
                            <div class="dashboard-stat-content">
                                <h4 style="font-size:17px">{{ topProduct() }} </h4>
                                <h5 style="color: #fff">Top Product</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>

                {{-- top brand --}}
                <div class="col-lg-4 col-md-4">
                    <div class="dashboard-stat bg-warning">
                        <a href="{{ route('orders.index') }}">
                            <div class="dashboard-stat-content">
                                <h4 style="font-size:20px">{{ topBrand() }} </h4>
                                <h5 style="color: #fff">Top Brand</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>
                {{-- top sub category --}}
                <div class="col-lg-4 col-md-4">
                    <div class="dashboard-stat bg-success">
                        <a href="{{ route('orders.index') }}">
                            <div class="dashboard-stat-content">
                                <h4 style="font-size:20px">{{ topCategory() }} </h4>
                                <h5 style="color: #fff">Top Category</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>
                {{-- top area --}}
                <div class="col-lg-4 col-md-4">
                    <div class="dashboard-stat bg-danger">
                        <a href="{{ route('orders.index') }}">
                            <div class="dashboard-stat-content">
                                <h4 style="font-size:20px">{{ topCity() }} </h4>
                                <h5 style="color: #fff">Top Geographical Area of Orders</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="dashboard-stat bg-primary">
                        <a href="{{ route('orders.index') }}">
                            <div class="dashboard-stat-content">
                                <h4>{{ averageOrderDeliveryTime() }} </h4>
                                <h5 style="color: #fff">Average Order Delivery Time In Days</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>

                 <!-- brands -->
                 <div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-dark">
                        <a href="{{ route('brands.index') }}" target="_blank">
                            <div class="dashboard-stat-content">
                                <h4>{{ CountBrands() }}</h4>
                                <h5 style="color: #fff">Brands</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-info">
                        <a href="{{ route('companies.index') }}" target="_blank">
                            <div class="dashboard-stat-content">
                                <h4>{{ CountCompanies() }}</h4>
                                <h5 style="color: #fff">Companies</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-warning">
                        <a href="{{ route('vendors.index') }}" target="_blank">
                            <div class="dashboard-stat-content">
                                <h4>{{ countVendors() }}</h4>
                                <h5 style="color: #fff">Vendors</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-success">
                        <a href="{{ route('users.index') }}" target="_blank">
                            <div class="dashboard-stat-content">
                                <h4>{{ CountUsers() }}</h4>
                                <h5 style="color: #fff">Users</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="dashboard-stat bg-danger">
                        <a href="{{ route('search.store.product') }}" target="_blank">
                            <div class="dashboard-stat-content">
                                <h4>{{ ProductsSearch() }}</h4>
                                <h5 style="color: #fff">#Search in products</h5>
                            </div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                      <div class="dashboard-stat bg-primary">
                          <a href="{{ route('shop.products.index') }}" target="_blank">
                              <div class="dashboard-stat-content">
                                  <h4>{{ AllShopProducts() }}</h4>
                                  <h5 style="color: #fff">#Total Sku</h5>
                              </div>
                              <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                          </a>
                      </div>
                </div> 
                <div class="col-lg-4 col-md-6">
                        <div class="dashboard-stat bg-warning">
                            <a href="{{ route('shop.products.index') }}" target="_blank">
                                <div class="dashboard-stat-content">
                                    <h4>{{ AllShopProductsWithQuantity() }}</h4>
                                    <h5 style="color: #fff">#Total Active Sku (quantity more than 0)</h5>
                                </div>
                                <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                            </a>
                        </div>
              	</div>
                <div class="col-lg-4 col-md-6">
                          <div class="dashboard-stat bg-success">
                              <a href="{{ route('shop.products.index') }}" target="_blank">
                                  <div class="dashboard-stat-content">
                                      <h4>{{ AllShopProductsWithoutQuantity() }}</h4>
                                      <h5 style="color: #fff">#Total Inactive Sku (quantity equals 0)</h5>
                                  </div>
                                  <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                              </a>
                          </div>
                  </div>
            </div>
            {{-- tops --}}
           <!--  <div class="row">
                
            </div> -->

<!--             <div class="row">
                <div class="col-lg-4 col-md-6">
                
            </div> -->

            <div class="row">
               
                <!-- companies -->
                
                
                <!-- Users -->
                
            </div>
            <div class="row">
                <!-- Site Visiors -->
                <!-- <div class="col-lg-4 col-md-6                                                                                                                                                                                                                                                       <div class="dashboard-stat color-3">
                <a href="{{ route('site.visitors') }}" target="_blank">
                <div class="dashboard-stat-content">
                <h4>{{ SiteVisitors() }}</h4>
                <h5 style="color: #fff">Site Visitors</h5>
                </div>
                <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                </a>
                </div>
                </div> -->
                <!-- Company View Count -->
                <!-- <div class="col-lg-4 col-md-6">
                <div class="dashboard-stat color-2">
                <a href="{{ route('company.visitors') }}" target="_blank">
                <div class="dashboard-stat-content">
                <h4>{{ CompanyVisitors() }}</h4>
                <h5 style="color: #fff">Companies View</h5>
                </div>
                <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                </a>
                </div>
                </div> -->
                <!-- Brand View Count -->
                <!-- <div class="col-lg-4 col-md-6">
                <div class="dashboard-stat color-4">
                <a href="{{ route('brand.visitors') }}" target="_blank">
                <div class="dashboard-stat-content">
                <h4>{{ BrandVisitors() }}</h4>
                <h5 style="color: #fff">Brands View</h5>
                </div>
                <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                </a>
                </div>
                </div> -->
            </div>
            <div class="row">
                <!-- Subscription Request -->
                <!-- <div class="col-lg-4 col-md-6">
                <div class="dashboard-stat color-1">
                    <a href="{{ route('subscriptions.requests') . '?type=renew' }}" target="_blank">
                        <div class="dashboard-stat-content">
                            <h4>{{ SecscriptionRequest() }}</h4>
                            <h5 style="color: #fff">Subscription Request</h5>
                        </div>
                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                    </a>
                </div>
            </div> -->
                <!-- Active Subscriptions -->
                <!-- <div class="col-lg-4 col-md-6">
                <div class="dashboard-stat color-3">
                    <a href="{{ route('subscriptions.companies') . '?type=active' }}" target="_blank">
                        <div class="dashboard-stat-content">
                            <h4>{{ SubscriptionActive() }}</h4>
                            <h5 style="color: #fff">Active Subscriptions</h5>
                        </div>
                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                    </a>
                </div>
            </div> -->
                <!-- Expired subscriptions -->
                <!-- <div class="col-lg-4 col-md-6">
                                                                                                                                                                                                                                                                                                                                                                                                                <div class="dashboard-stat color-1">                                                                                                                                                                                                                                                                                                                                                                                               </div>
                                                                                                                                                                                                                                                                                                                                                                                                            </div> -->
            </div>
            <div class="row">
                <!-- Search Products -->
                
                <!-- Search Companies -->
                <!-- <div class="col-lg-4 col-md-6">
                <div class="dashboard-stat color-2">
                    <a href="{{ route('search.store.company') }}" target="_blank">
                        <div class="dashboard-stat-content">
                            <h4>{{ CompaniesSearch() }}</h4>
                            <h5 style="color: #fff">#Search in companies</h5>
                        </div>
                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                    </a>
                </div>
            </div> -->
                <!-- Search Brands -->
                <!-- <div class="col-lg-4 col-md-6">
                <div class="dashboard-stat color-4">
                    <a href="{{ route('search.store.brand') }}" target="_blank">
                        <div class="dashboard-stat-content">
                            <h4>{{ BrandsSearch() }}</h4>
                            <h5 style="color: #fff">#Search in brands</h5>
                        </div>
                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                    </a>
                </div>
            </div> -->
            </div>
        </div>
    </div>
</div>
@endsection
<!-- end:: Body -->