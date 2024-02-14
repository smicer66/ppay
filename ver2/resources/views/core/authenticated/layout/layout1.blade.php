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
	<link href="/favicon.png" rel="shortcut icon">
	<link href="/apple-touch-icon.png" rel="apple-touch-icon">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet" type="text/css">
	<link href="/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
	<link href="/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<link href="/bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
	<link href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
	<link href="/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
	<link href="/bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
	<link href="/css/main.css?version=4.5.0" rel="stylesheet"> </head>

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
						<div class="avatar-w"> <img alt="" src="/images/avatar1.png"> </div>
						<div class="logged-user-info-w">
							<div class="logged-user-name">
									{{\Auth::user()->firstName}} {{\Auth::user()->lastName}}
								</div>
								<div class="logged-user-role">
									{{str_replace('_', ' ', \Auth::user()->role_code)}}
								</div>
						</div>
					</div>
					<!--------------------
            START - Mobile Menu List
            -------------------->@if(\Auth::user()->role_code=='POTZR_STAFF') @include('partials.navigation_bar_potzr_staff') 
		@elseif(\Auth::user()->role_code=='EXCO_STAFF')
              	@include('partials.navigation_bar_exco_staff') @elseif(\Auth::user()->role_code=='BANK_STAFF') @include('partials.navigation_bar_bank_teller') @elseif(\Auth::user()->role_code=='CUSTOMER') @include('partials.navigation_bar_customer_web') @elseif(\Auth::user()->role_code=='ACCOUNTANT') @include('partials.navigation_bar_accountant_web') @endif
					<!--------------------
            END - Mobile Menu List
            -------------------->
					
				</div>
			</div>
			<!--------------------
        END - Mobile Menu
        -------------------->
			<!--------------------
        START - Main Menu
        -------------------->
			<div class="menu-w color-scheme-light color-style-transparent menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
				<div class="logo-w">
					<a class="logo" href="index.html">
						<div class="logo-element"></div>
						<div class="logo-label"> Clean Admin </div>
					</a>
				</div>
				<div class="logged-user-w avatar-inline">
					<div class="logged-user-i">
						<div class="avatar-w"> <img alt="" src="/images/avatar1.png"> </div>
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
								<div class="avatar-w"> <img alt="" src="/images/avatar1.png"> </div>
								<div class="logged-user-info-w">
									<div class="logged-user-name">
									{{\Auth::user()->firstName}} {{\Auth::user()->lastName}}
								</div>
								<div class="logged-user-role">
									{{str_replace('_', ' ', \Auth::user()->role_code)}}
								</div>
								</div>
							</div>
							<div class="bg-icon"> <i class="os-icon os-icon-wallet-loaded"></i> </div>
							<ul>
								<li> <a href="/logout"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a> </li>
							</ul>
						</div>
					</div>
				</div>
				<div class="menu-actions">
					
				</div>
				
				<h1 class="menu-page-header">
            Page Header
          </h1> @if(\Auth::user()->role_code=='POTZR_STAFF') @include('partials.navigation_bar_potzr_staff_web') 
		@elseif(\Auth::user()->role_code=='EXCO_STAFF')
              	@include('partials.navigation_bar_exco_staff') @elseif(\Auth::user()->role_code=='BANK_STAFF') @include('partials.navigation_bar_bank_teller_web') @elseif(\Auth::user()->role_code=='CUSTOMER') @include('partials.navigation_bar_customer_web') @elseif(\Auth::user()->role_code=='ACCOUNTANT') @include('partials.navigation_bar_accountant_web') @endif
				
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
								<div class="avatar-w"> <img alt="" src="/images/avatar1.png"> </div>
								<div class="logged-user-menu color-style-bright">
									<div class="logged-user-avatar-info">
										<div class="avatar-w"> <img alt="" src="/images/avatar1.png"> </div>
										<div class="logged-user-info-w">
											<div class="logged-user-name">
									{{\Auth::user()->firstName}} {{\Auth::user()->lastName}}
								</div>
								<div class="logged-user-role">
									{{str_replace('_', ' ', \Auth::user()->role_code)}}
								</div>
										</div>
									</div>
									<div class="bg-icon"> <i class="os-icon os-icon-wallet-loaded"></i> </div>
									<ul>
										<li> <a href="/logout"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a> </li>
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
          -------------------->
				<!--------------------
          START - Breadcrumbs
          -------------------->
				<ul class="breadcrumb">
					<li class="breadcrumb-item"> <a href="index.html">Home</a> </li>
					<!--<li class="breadcrumb-item"> <a href="index.html">Products</a> </li>
					<li class="breadcrumb-item"> <span>Laptop with retina screen</span> </li>-->
				</ul>
				<!--------------------
          END - Breadcrumbs
          -------------------->
				<div class="content-panel-toggler"> <i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span> </div>
				<div class="content-i">
					<div class="content-box">
						@yield('content')
					</div>
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
	<script src="/js/main.js?version=4.5.0"></script>
	@yield('scripts')
	@yield('styles')
</body>

</html>