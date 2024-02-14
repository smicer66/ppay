<!DOCTYPE html>
<html>
  <head>
    <title>Admin Dashboard HTML Template</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta content="Tamerlan Soziev" name="author">
    <meta content="Admin dashboard html template" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="/images/favicon-16x16.png" rel="shortcut icon">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet" type="text/css">
    <link href="/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="/bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="/bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="/css/main.css?version=4.5.0" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/js/all.min.js" integrity="sha512-cyAbuGborsD25bhT/uz++wPqrh5cqPh1ULJz4NSpN9ktWcA6Hnh9g+CWKeNx2R0fgQt+ybRXdabSBgYXkQTTmA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<style>
	.abc{
		border-bottom: 0px !important;
	}
	</style>
  </head>
  <body class="menu-position-side menu-side-left full-screen with-content-panel">
    <div class="all-wrapper with-side-panel solid-bg-all">
      <div class="layout-w">
        <!--------------------
        START - Mobile Menu
        -------------------->
        <div class="menu-mobile menu-activated-on-click color-scheme-dark">
          <div class="mm-logo-buttons-w">
            <a class="mm-logo" href="index.html"><img src="/img/logo.png"><span>Clean Admin</span></a>
            <div class="mm-buttons">
              <div class="content-panel-open">
                <div class="os-icon os-icon-grid-circles"></div>
              </div>
              <div class="mobile-menu-trigger">
                <div class="os-icon os-icon-hamburger-menu-1"></div>
              </div>
            </div>
          </div>
          <div class="menu-and-user">
            <div class="logged-user-w">
              <div class="avatar-w">
                <img alt="" src="/img/avatar1.jpg">
              </div>
              <div class="logged-user-info-w">
                <div class="logged-user-name">
                  {{\Auth::user()->firstName}} {{\Auth::user()->lastName}}
                </div>
                <div class="logged-user-role">
                  {{\Auth::user()->role_code}}ss{{str_replace('_', ' ', \Auth::user()->role_code)}}
                </div>
              </div>
            </div>
            <!--------------------
            START - Mobile Menu List
            -------------------->
            	@if(\Auth::user()->role_code=='POTZR_STAFF')
			@include('partials.navigation_bar_potzr_staff')
		@elseif(\Auth::user()->role_code=='BANK_STAFF')
			@include('partials.navigation_bar_bank_teller')
              @elseif(\Auth::user()->role_code=='CUSTOMER')
              	@include('partials.navigation_bar_customer_web')
		@elseif(\Auth::user()->role_code=='ACCOUNTANT')
              	@include('partials.navigation_bar_accountant_web')
		@elseif(\Auth::user()->role_code=='EXCO_STAFF')
              	@include('partials.navigation_bar_exco_staff')
		@endif
            <!--------------------
            END - Mobile Menu List
            -------------------->
            
          </div>
        </div>
        <!--------------------
        END - Mobile Menu
        --------------------><!--------------------
        START - Main Menu
        -------------------->
        <div class="menu-w color-scheme-light color-style-transparent menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
          <div class="logo-w">
            <a class="logo" href="index.html">
              <div><img src="/img/logo.png"></div>
              <div class="logo-label">
                Bevura
              </div>
            </a>
          </div>
          <div class="logged-user-w avatar-inline">
            <div class="logged-user-i">
              <div class="avatar-w">
                <img alt="" src="/img/avatar1.jpg">
              </div>
              <div class="logged-user-info-w">
                <div class="logged-user-name">
                  {{\Auth::user()->firstName}} {{\Auth::user()->lastName}}
                </div>
                <div class="logged-user-role">
                  {{str_replace('_', ' ', \Auth::user()->role_code)}}
                </div>
              </div>
              <div class="logged-user-toggler-arrow">
                <div class="os-icon os-icon-chevron-down"></div>
              </div>
              <div class="logged-user-menu color-style-bright">
                <div class="logged-user-avatar-info">
                  <div class="avatar-w">
                    <img alt="" src="/img/avatar1.jpg">
                  </div>
                  <div class="logged-user-info-w">
                    <div class="logged-user-name">
                      {{\Auth::user()->firstName}} {{\Auth::user()->lastName}}
                    </div>
                    <div class="logged-user-role">
                      {{str_replace('_', ' ', \Auth::user()->role_code)}}
                    </div>
                  </div>
                </div>
                <div class="bg-icon">
                  <i class="os-icon os-icon-wallet-loaded"></i>
                </div>
                <ul>
                  <!--<li>
                    <a href="apps_email.html"><i class="os-icon os-icon-mail-01"></i><span>Incoming Mail</span></a>
                  </li>
                  <li>
                    <a href="users_profile_big.html"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a>
                  </li>
                  <li>
                    <a href="/potzr-staff/logs/sdsad"><i class="os-icon os-icon-coins-4"></i><span>Billing Details</span></a>
                  </li>
                  <li>
                    <a href="#"><i class="os-icon os-icon-others-43"></i><span>Notifications</span></a>
                  </li>-->
                  <li>
                    <a href="/logout"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="menu-actions">
            
          </div>
          
          <h1 class="menu-page-header">
            Page Header
          </h1>
         	@if(\Auth::user()->role_code=='POTZR_STAFF')
			@include('partials.navigation_bar_potzr_staff_web')
		@elseif(\Auth::user()->role_code=='BANK_STAFF')
			@include('partials.navigation_bar_bank_teller_web')
             	@elseif(\Auth::user()->role_code=='CUSTOMER')
			@include('partials.navigation_bar_customer_web')
		@elseif(\Auth::user()->role_code=='ACCOUNTANT')
			@include('partials.navigation_bar_accountant_web')
		@elseif(\Auth::user()->role_code=='EXCO_STAFF')
              	@include('partials.navigation_bar_exco_staff')
		@endif
          
        </div>
        <!--------------------
        END - Main Menu
        -------------------->
        <div class="content-w">
          <!--------------------
          START - Top Bar
          -------------------->
          <div class="top-bar color-scheme-transparent">
            <!--------------------
            START - Top Menu Controls
            -------------------->
            <div class="top-menu-controls">
              <!--------------------
              START - User avatar and menu in secondary top menu
              -------------------->
              <div class="logged-user-w">
                <div class="logged-user-i">
                  <div class="avatar-w">
                    <img alt="" src="/img/avatar1.jpg">
                  </div>
                  <div class="logged-user-menu color-style-bright">
                    <div class="logged-user-avatar-info">
                      <div class="avatar-w">
                        <img alt="" src="/img/avatar1.jpg">
                      </div>
                      <div class="logged-user-info-w">
                        <div class="logged-user-name">
                          {{\Auth::user()->firstName}} {{\Auth::user()->lastName}}
                	</div>
                	<div class="logged-user-role">
                  		{{str_replace('_', ' ', \Auth::user()->role_code)}}
                        </div>
                      </div>
                    </div>
                    <div class="bg-icon">
                      <i class="os-icon os-icon-wallet-loaded"></i>
                    </div>
                    <ul>
                      <!--<li>
                        <a href="apps_email.html"><i class="os-icon os-icon-mail-01"></i><span>Incoming Mail</span></a>
                      </li>
                      <li>
                        <a href="users_profile_big.html"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a>
                      </li>
                      <li>
                        <a href="/potzr-staff/logs/sdsad"><i class="os-icon os-icon-coins-4"></i><span>Billing Details</span></a>
                      </li>
                      <li>
                        <a href="#"><i class="os-icon os-icon-others-43"></i><span>Notifications</span></a>
                      </li>-->
                      <li>
                        <a href="/logout"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!--------------------
              END - User avatar and menu in secondary top menu
              -------------------->
            </div>
            <!--------------------
            END - Top Menu Controls
            -------------------->
          </div>
          <!--------------------
          END - Top Bar
          --------------------><!--------------------
          START - Breadcrumbs
          -------------------->
          <ul class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item">
              <a href="dashboard">Dashboard</a>
            </li>
          </ul>
          <!--------------------
          END - Breadcrumbs
          -------------------->
          <div class="content-panel-toggler">
            <i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span>
          </div>
          <div class="">
            <div class="content-box">
              <div class="row">
                <div class="col-sm-12">
                  <div class="element-wrapper">
                    <div class="element-actions">
                      <form class="form-inline justify-content-sm-end">
                        <select class="form-control form-control-sm" id="salesdate" onchange="handleSalesDateChange()">
                          <option value="month">
                            Last 30 Days
                          </option>
                          <option value="today">
                            Today
                          </option>
                          <option value="week">
                            Last Week 
                          </option>
                        </select>
                      </form>
                    </div>
                    <h6 class="element-header">
                      Sales Dashboard
                    </h6>
                    <div class="element-content">
                      <div class="row">
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo" href="#">
                            <div class="label">
                              Transactions
                            </div>
                            <div class="value" id="transactionsHolder">
                              0.00
                            </div>
                            <!--<div class="trending trending-up-basic">
                              <span>12%</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>-->
                          </a>
                        </div>
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo" href="#">
                            <div class="label">
                              Income
                            </div>
                            <div class="value" id="incomeHolder">
                              0.00
                            </div>
                            <!--<div class="trending trending-down-basic">
                              <span>12%</span><i class="os-icon os-icon-arrow-down"></i>
                            </div>-->
                          </a>
                        </div>
                        <div class="col-sm-4 col-xxxl-3">
                          <a class="element-box el-tablo" href="#">
                            <div class="label">
                              Customers
                            </div>
                            <div class="value" id="customerCountHolder">
                              0
                            </div>
                            <!--<div class="trending trending-down-basic">
                              <span>9%</span><i class="os-icon os-icon-arrow-down"></i>
                            </div>-->
                          </a>
                        </div>
                        <div class="d-none d-xxxl-block col-xxxl-3">
                          <a class="element-box el-tablo" href="#">
                            <div class="label">
                              Pool Balance
                            </div>
                            <div class="value" id="poolBalanceHolder">
                              0.00
                            </div>
                            <!--<div class="trending trending-up-basic">
                              <span>12%</span><i class="os-icon os-icon-arrow-up2"></i>
                            </div>-->
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>




              <div class="row">
                <div class="col-sm-8 col-xxxl-6">
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Mastercard Card Requests + Latest Virtual Cards
                    </h6>
                    <div class="element-box">
                      <div class="table-responsive">
                        <table class="table table-lightborder">
                          <thead>
                            <tr>
                              <th>
                                Customer
                              </th>
                              <th>
                                Card Product
                              </th>
                              <th class="text-center">
                                Status
                              </th>
                              <th class="text-right">
                                Created
                              </th>
                            </tr>
                          </thead>
                          <tbody id="tbodyForMasterCard">
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 d-xxxl-none">
                  <!--START - Top Selling Chart-->
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Top Selling Today
                    </h6>
                    <div class="element-box">
                      <div class="el-chart-w">
                        <canvas height="120" id="donutChart" width="120"></canvas>
                        <div class="inside-donut-chart-label">
                          <strong>142</strong><span>Total Orders</span>
                        </div>
                      </div>
                      <div class="el-legend condensed">
                        <div class="row">
                          <div class="col-auto col-xxxxl-6 ml-sm-auto mr-sm-auto col-6">
                            <div class="legend-value-w">
                              <div class="legend-pin legend-pin-squared" style="background-color: #6896f9;"></div>
                              <div class="legend-value">
                                <span>Prada</span>
                                <div class="legend-sub-value">
                                  14 Pairs
                                </div>
                              </div>
                            </div>
                            <div class="legend-value-w">
                              <div class="legend-pin legend-pin-squared" style="background-color: #85c751;"></div>
                              <div class="legend-value">
                                <span>Maui Jim</span>
                                <div class="legend-sub-value">
                                  26 Pairs
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-6 d-lg-none d-xxl-block">
                            <div class="legend-value-w">
                              <div class="legend-pin legend-pin-squared" style="background-color: #806ef9;"></div>
                              <div class="legend-value">
                                <span>Gucci</span>
                                <div class="legend-sub-value">
                                  17 Pairs
                                </div>
                              </div>
                            </div>
                            <div class="legend-value-w">
                              <div class="legend-pin legend-pin-squared" style="background-color: #d97b70;"></div>
                              <div class="legend-value">
                                <span>Armani</span>
                                <div class="legend-sub-value">
                                  12 Pairs
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--END - Top Selling Chart-->
                </div>
                <div class="d-none d-xxxl-block col-xxxl-6">
                  <!--START - Questions per Product-->
                  <div class="element-wrapper">
                    <div class="element-actions">
                      
                    </div>
                    <h6 class="element-header">
                      Inventory Stats
                    </h6>
                    <div class="element-box">
                      <div class="os-progress-bar primary">
                        <div class="bar-labels">
                          <div class="bar-label-left">
                            <span class="bigger">Virtual Cards</span>
                          </div>
                          <div class="bar-label-right">
                            <span class="info" id="virtualCardCountHolder">25 items / 10 remaining</span>
                          </div>
                        </div>
                        <div class="bar-level-1" style="width: 100%">
                          <div class="bar-level-2" id="virtualCardCountHolderLevel2" style="">
                            <div class="bar-level-3" id="virtualCardCountHolderLevel3" style="width: 40%"></div>
                          </div>
                        </div>
                      </div>
                      <div class="os-progress-bar primary">
                        <div class="bar-labels">
                          <div class="bar-label-left">
                            <span class="bigger">Physical Cards</span>
                          </div>
                          <div class="bar-label-right">
                            <span class="info" id="physicalCardCountHolder">18 items / 7 remaining</span>
                          </div>
                        </div>
                        <div class="bar-level-1" style="width: 100%">
                          <div class="bar-level-2" id="physicalCardCountHolderLevel2" style="width: 40%">
                            <div class="bar-level-3" id="physicalCardCountHolderLevel3" style="width: 20%"></div>
                          </div>
                        </div>
                      </div>
                      <div class="os-progress-bar primary">
                        <div class="bar-labels">
                          <div class="bar-label-left">
                            <span class="bigger">Wallets</span>
                          </div>
                          <div class="bar-label-right">
                            <span class="info" id="walletCountHolder">15 items / 12 remaining</span>
                          </div>
                        </div>
                        <div class="bar-level-1" style="width: 100%">
                          <div class="bar-level-2" id="walletCountHolderLevel2" style="width: 60%">
                            <div class="bar-level-3" id="walletCountHolderLevel3" style="width: 30%"></div>
                          </div>
                        </div>
                      </div>
                      <div class="os-progress-bar primary">
                        <div class="bar-labels">
                          <div class="bar-label-left">
                            <span class="bigger">MPQR</span>
                          </div>
                          <div class="bar-label-right">
                            <span class="info" id="mpqrCountHolder">12 items / 4 remaining</span>
                          </div>
                        </div>
                        <div class="bar-level-1" style="width: 100%">
                          <div class="bar-level-2" id="mpqrCountHolderLevel2" style="width: 30%">
                            <div class="bar-level-3" id="mpqrCountHolderLevel3" style="width: 10%"></div>
                          </div>
                        </div>
                      </div>
                      <div class="os-progress-bar primary">
                        <div class="bar-labels">
                          <div class="bar-label-left">
                            <span class="bigger">Merchants</span>
                          </div>
                          <div class="bar-label-right">
                            <span class="info" id="merchantCountHolder">12 items / 4 remaining</span>
                          </div>
                        </div>
                        <div class="bar-level-1" style="width: 100%">
                          <div class="bar-level-2" id="merchantCountHolderLevel2" style="width: 30%">
                            <div class="bar-level-3" id="merchantCountHolderLevel3" style="width: 10%"></div>
                          </div>
                        </div>
                      </div>
                      <div class="os-progress-bar primary">
                        <div class="bar-labels">
                          <div class="bar-label-left">
                            <span class="bigger">Devices</span>
                          </div>
                          <div class="bar-label-right">
                            <span class="info" id="deviceCountHolder">12 items / 4 remaining</span>
                          </div>
                        </div>
                        <div class="bar-level-1" style="width: 100%">
                          <div class="bar-level-2" id="deviceCountHolderLevel2" style="width: 30%">
                            <div class="bar-level-3" id="deviceCountHolderLevel3" style="width: 10%"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--END - Questions per product                  -->
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 col-xxxl-9">
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Transactions
                    </h6>
                    <div class="element-box">
                      <div class="os-tabs-w">
                        <div class="os-tabs-controls">
                          <ul class="nav nav-tabs smaller">
                            <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#tab_overview">Debits</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" data-toggle="tab" href="#tab_sales">Credits</a>
                            </li>
                          </ul>
                          <ul class="nav nav-pills smaller d-none d-md-flex">
                            <!--<li class="nav-item">
                              <a class="nav-link" data-toggle="tab" href="#">Today</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#">7 Days</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" data-toggle="tab" href="#">14 Days</a>
                            </li>-->
                            <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#">This Month</a>
                            </li>
                          </ul>
                        </div>
                        <div class="tab-content">
                          <div class="tab-pane active" id="tab_overview">
                            <div class="el-tablo bigger">
                              <div class="label">
                                Maximum Transaction Amount
                              </div>
                              <div class="value" id="maxTransactionAmountDiv">
                                0.00
                              </div>
                            </div>
                            <div class="el-chart-w">
                              <canvas height="150px" id="lineChartAcc" width="600px"></canvas>
                            </div>
                          </div>
                          <div class="tab-pane" id="tab_sales"></div>
                          <div class="tab-pane" id="tab_conversion"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-none d-xxxl-block col-xxxl-3">
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Cards
                    </h6>
                    <div class="element-box less-padding">
                      <div class="el-chart-w">
                        <canvas height="120" id="donutChart1" width="120"></canvas>
                        <div class="inside-donut-chart-label">
                          <strong id="totalCardsForChar">0</strong><span>Payment Cards</span>
                        </div>
                      </div>
                      <div class="el-legend condensed">
                        <div class="row">
                          <div class="col-auto col-xxxxl-6 ml-sm-auto mr-sm-auto">
                            <div class="legend-value-w">
                              <div class="legend-pin legend-pin-squared" style="background-color: #6896f9;"></div>
                              <div class="legend-value">
                                <span>Virtual Cards</span>
                                <div class="legend-sub-value" id="virtualcardforchart">
                                  0
                                </div>
                              </div>
                            </div>
                            <div class="legend-value-w">
                              <div class="legend-pin legend-pin-squared" style="background-color: #85c751;"></div>
                              <div class="legend-value">
                                <span>Physical Cards</span>
                                <div class="legend-sub-value" id="physicalcardforchart">
                                  0
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="element-wrapper">
                    <h6 class="element-header">
                      Recent Transactions
                    </h6>
                    <div class="element-box-tp">
                      
                      <!--------------------
                      END - Controls Above Table
                      ------------------          --><!--------------------
                      START - Table with actions
                      ------------------  -->
                      <div class="table-responsive">
                        <table class="table table-bordered table-lg table-v2 table-striped">
                          <thead>
                            <tr>
                              <th style="text-align: left !important;">
					Date
                              </th>
                              <th style="text-align: left !important;">
					Reference
                              </th>
                              <th style="text-align: left !important;">
                                Details
                              </th>
                              <th style="text-align: right !important;">
                                Amount
                              </th>
                              <th style="text-align: left !important;">
                                Paid By
                              </th>
                              <th style="text-align: left !important;">
                                Status
                              </th>
                            </tr>
                          </thead>
                          <tbody id="transactionListTable">
                            
                          </tbody>
                        </table>
                      </div>
                      <!--------------------
                      END - Table with actions
                      ------------------            -->
                    </div>
                  </div>
                </div>
              </div>




		




            </div>
            <!--------------------
            START - Sidebar
            -------------------->
            <div class="content-panel">
              
              
              <!--------------------
              END - Issues
              -------------------->
            </div>
            <!--------------------
            END - Sidebar
            -------------------->
          </div>
        </div>
      </div>
      <div class="display-type"></div>
    </div>
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/popper.js/dist/umd/popper.min.js"></script>
    <script src="/bower_components/moment/moment.js"></script>
    <script src="/bower_components/chart.js/dist/Chart.min.js"></script>
    <script src="/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="/bower_components/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
    <script src="/bower_components/ckeditor/ckeditor.js"></script>
    <script src="/bower_components/bootstrap-validator/dist/validator.min.js"></script>
    <script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/bower_components/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <script src="/bower_components/dropzone/dist/dropzone.js"></script>
    <script src="/bower_components/editable-table/mindmup-editabletable.js"></script>
    <script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="/bower_components/tether/dist/js/tether.min.js"></script>
    <script src="/bower_components/slick-carousel/slick/slick.min.js"></script>
    <script src="/bower_components/bootstrap/js/dist/util.js"></script>
    <script src="/bower_components/bootstrap/js/dist/alert.js"></script>
    <script src="/bower_components/bootstrap/js/dist/button.js"></script>
    <script src="/bower_components/bootstrap/js/dist/carousel.js"></script>
    <script src="/bower_components/bootstrap/js/dist/collapse.js"></script>
    <script src="/bower_components/bootstrap/js/dist/dropdown.js"></script>
    <script src="/bower_components/bootstrap/js/dist/modal.js"></script>
    <script src="/bower_components/bootstrap/js/dist/tab.js"></script>
    <script src="/bower_components/bootstrap/js/dist/tooltip.js"></script>
    <script src="/bower_components/bootstrap/js/dist/popover.js"></script>
    <script src="/js/demo_customizer.js?version=4.5.0"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/js/main.js?version=4.5.0"></script>
    <script src="/js/action.js"></script>

    <script>
		var serviceTypes = [];
		var statusList = [];
		<?Php
		$arrayValues = array_values(getAllServiceTypes());
		foreach($arrayValues as $arr)
		{
		?>
			serviceTypes.push('{{$arr}}');
		<?php
		}


		$arrayValues = array_values(getAllTransactionStatus());
		foreach($arrayValues as $arr)
		{
		?>
			statusList.push('{{$arr}}');
		<?php
		}
		?>
	$(document).ready(function()
	{
		var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
	 	var deviceCode = '{{BEVURA_DEVICE_CODE}}';
		var token = '{{\Auth::user()->token}}';
		

		console.log(serviceTypes);
		loadAccountantDashboard(jwtToken, deviceCode, $('#salesdate').val(), token, serviceTypes, statusList);


		loadChart();
	});


	function handleSalesDateChange()
	{
		var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
	 	var deviceCode = '{{BEVURA_DEVICE_CODE}}';
		var token = '{{\Auth::user()->token}}';
		loadAccountantDashboard(jwtToken, deviceCode, $('#salesdate').val(), token, serviceTypes, statusList);
	}


	
    </script>
  </body>
</html>




