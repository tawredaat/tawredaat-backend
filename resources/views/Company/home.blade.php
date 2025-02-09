@extends('Company.index') @section('dashboard-active', 'm-menu__item--active m-menu__item--open')
@section('page-title', 'Dashboard')
@section('content')
<style type="text/css">
    .no-margins{
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

.dashboard-stat:hover { transform: translateY(-4px); }

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


/* Colors */
.dashboard-stat.color-1 {
    background: linear-gradient(to left, rgba(255,255,255,0) 25%, rgba(255,255,255,0.2));
    background-color: #64bc36;
}

.dashboard-stat.color-2 {
    background: linear-gradient(to left, rgba(255,255,255,0) 25%, rgba(255,255,255,0.1));
    background-color: #363841;
}

.dashboard-stat.color-3 {
    background: linear-gradient(to left, rgba(255,255,255,0) 25%, rgba(255,255,255,0.3));
    background-color: #ffae00;
}

.dashboard-stat.color-4 {
    background: linear-gradient(to left, rgba(255,255,255,0) 25%, rgba(255,255,255,0.1));
    background-color: #f3103c;
}


</style>
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    <!-- BEGIN: Left Aside -->
    <!-- END: Left Aside -->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                             Dashboard
                             </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="container">
                        <div class="row">
                            <!-- Products -->
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-1">
                                    <a href="{{route('company.products.index')}}" target="_blank">
                                        <div class="dashboard-stat-content">
                                            <h4>{{ CompanyProducts() }}</h4>
                                            <h5 style="color: #fff">Products</h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                    </a>
                                </div>
                            </div>
                            <!-- Brands -->
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-2">
                                    <a href="{{route('company.view.brands')}}" target="_blank">
                                        <div class="dashboard-stat-content">
                                            <h4>{{ CompanyBrands() }}</h4>
                                            <h5 style="color: #fff">Brands</h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                    </a>
                                </div>
                            </div>
                             <!-- Categories -->
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-3">
                                    <a href="{{route('company.view.categories')}}" target="_blank">
                                        <div class="dashboard-stat-content">
                                            <h4>{{ CompanyCategories() }}</h4>
                                            <h5 style="color: #fff">Categories</h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                    </a>
                                </div>
                            </div>
                             <!-- Call now button clicks -->
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-4">
                                    <a href="{{route('company.callbacks')}}" target="_blank">
                                        <div class="dashboard-stat-content">
                                            <h4>{{ CompanyCallBackRequests()}}</h4>
                                            <h5 style="color: #fff">Call now button clicks</h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                       <div class="row">
                            <!-- More info button clicks -->
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-4">
                                    <a href="{{route('company.moreInfo')}}" target="_blank">
                                        <div class="dashboard-stat-content">
                                            <h4>{{ CompanyMoreInfoBtns()}}</h4>
                                            <h5 style="color: #fff">More info button clicks</h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                    </a>
                                </div>
                            </div>
                            <!-- Product RFQ  -->
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-3">
                                    <a href="{{route('company.product.rfq')}}" target="_blank">
                                        <div class="dashboard-stat-content">
                                            <!-- <h4>{{ CompanyProductRfqs() }}</h4> -->
                                            <h4>---</h4>
                                            <h5 style="color: #fff">Product RFQ </h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                    </a>
                                </div>
                            </div>
                             <!-- General RFQ -->
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-2">
                                    <a href="{{route('company.products.rfq')}}" target="_blank">
                                        <div class="dashboard-stat-content">
                                            <h4>{{ CompanyGeneralRfqs() }}</h4>
                                            <h5 style="color: #fff">General RFQ</h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                    </a>
                                </div>
                            </div>
                             <!-- User Tenders -->
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-1">
                                    <a href="#" target="_blank">
                                        <div class="dashboard-stat-content">
                                            <h4>---</h4>
                                            <h5 style="color: #fff">User Tenders</h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                    </a>
                                </div>
                            </div>
                       </div>
                        <div class="row">
                            <!--Profile Views -->
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-3">
                                    <a href="{{route('company.viewInformation')}}" target="_blank">
                                        <div class="dashboard-stat-content">
                                            <h4>{{CompanyProfileViews()}}</h4>
                                            <h5 style="color: #fff">Profile Views </h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                    </a>
                                </div>
                            </div>
                            <!-- Download PDFs  -->
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-4">
                                    <a href=" {{route('company.pdfs')}}" target="_blank">
                                        <div class="dashboard-stat-content">
                                            <h4>{{ CompanyPdfDownloads() }}</h4>
                                            <h5 style="color: #fff">Download PDFs</h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-1">
                                        <div class="dashboard-stat-content">
                                           <h5>
                                            @if(CompanyDayToEndSecscription())
                                                 {{CompanyDayToEndSecscription()}} Days
                                                  <h5 style="color: #fff"> Days till end of subscription</h5>
                                            @else
                                               <span style="font-size: 15px">You have no subscription yet</span>
                                            @endif
                                            </h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-2">
                                        <div class="dashboard-stat-content">

                                            <h5>
                                                @if(CompanySecscription())
                                                    <h5 style="color: #fff">Subscription name :</h5>  {{CompanySecscription()}}
                                                @else
                                                  <span style="font-size: 15px">You have no subscription yet</span>
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="dashboard-stat color-4">
                                    <a href="{{route('company.whatscallbacks')}}" target="_blank">
                                        <div class="dashboard-stat-content">
                                            <h4>{{ CompanyWhatsuCallRequests()}}</h4>
                                            <h5 style="color: #fff"> Whatsapp call button clicks</h5>
                                        </div>
                                        <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
</div>
@endsection
<!-- end:: Body -->
