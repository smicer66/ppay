<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title')</title>
		<meta charset="utf-8">
		<meta content="ie=edge" http-equiv="x-ua-compatible">
		<meta content="Bevura Probase" name="keywords">
		<meta content="Probase" name="author">
		<meta content="@yield('title')" name="description">
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
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
		

		<style>
		label{
			font-weight: bold !important;
		}

		.row{
			width: 100% !important;
		}


		.dataTables_length > label > select {
			float: left !important;
		}


		.dropdown-menu{
			right: 0px !important;
			left: auto !important;
		}

		.dropdown-menu > li{
			padding: 7px !important;
			white-space: nowrap !important;
		}

		.dropdown-menu > li:hover {
			background-color: #f1f1f1 !important;
		}


		.floatleft{
			float: left !important;
		}

		.floatright{
			float: right !important;
		}

		.os-icon-close:before {
			content: "\e941";
			float: right !important;
    		font-size: 0.7em;
    		padding: 15px !important;
		}

		.pull-right{
			float: right !important;
		}

		.pull-left{
			float: left !important;
		}

		.btn{
			cursor: pointer !important;
		}

        .element-header{
            padding-top: 15px !important;
        }

        td{
            color: #000 !important;
        }
		</style>
		@yield('style')

	</head>
	<body class="menu-position-side menu-side-left full-screen with-content-panel">
		<div class="all-wrapper with-side-panel solid-bg-all">
			<div class="search-with-suggestions-w">
				<div class="search-with-suggestions-modal">
					<div class="element-search">
						<!--<input class="search-suggest-input" placeholder="Start typing to search..." type="text">
						<div class="close-search-suggestions">
							<i class="os-icon os-icon-x"></i>
						</div>
						</input>-->
					</div>
					<div class="search-suggestions-group">
						<div class="ssg-header">
							<div class="ssg-icon">
								<div class="os-icon os-icon-box"></div>
							</div>
							<div class="ssg-name">
								Projects
							</div>
							<div class="ssg-info">
								24 Total
							</div>
						</div>
						<div class="ssg-content">
							<div class="ssg-items ssg-items-boxed">
								<a class="ssg-item" href="users_profile_big.html">
									<div class="item-media" style="background-image: url(img/company6.png)"></div>
									<div class="item-name">
										Integ<span>ration</span> with API
									</div>
								</a>
								<a class="ssg-item" href="users_profile_big.html">
									<div class="item-media" style="background-image: url(img/company7.png)"></div>
									<div class="item-name">
										Deve<span>lopm</span>ent Project
									</div>
								</a>
							</div>
						</div>
					</div>
					<div class="search-suggestions-group">
						<div class="ssg-header">
							<div class="ssg-icon">
								<div class="os-icon os-icon-users"></div>
							</div>
							<div class="ssg-name">
								Customers
							</div>
							<div class="ssg-info">
								12 Total
							</div>
						</div>
						<div class="ssg-content">
							<div class="ssg-items ssg-items-list">
								<a class="ssg-item" href="users_profile_big.html">
									<div class="item-media" style="background-image: url(img/avatar1.jpg)"></div>
									<div class="item-name">
										John Ma<span>yer</span>s
									</div>
								</a>
								<a class="ssg-item" href="users_profile_big.html">
									<div class="item-media" style="background-image: url(img/avatar2.jpg)"></div>
									<div class="item-name">
										Th<span>omas</span> Mullier
									</div>
								</a>
								<a class="ssg-item" href="users_profile_big.html">
									<div class="item-media" style="background-image: url(img/avatar3.jpg)"></div>
									<div class="item-name">
										Kim C<span>olli</span>ns
									</div>
								</a>
							</div>
						</div>
					</div>
					<div class="search-suggestions-group">
						<div class="ssg-header">
							<div class="ssg-icon">
								<div class="os-icon os-icon-folder"></div>
							</div>
							<div class="ssg-name">
								Files
							</div>
							<div class="ssg-info">
								17 Total
							</div>
						</div>
						<div class="ssg-content">
							<div class="ssg-items ssg-items-blocks">
								<a class="ssg-item" href="#">
									<div class="item-icon">
										<i class="os-icon os-icon-file-text"></i>
									</div>
									<div class="item-name">
										Work<span>Not</span>e.txt
									</div>
								</a>
								<a class="ssg-item" href="#">
									<div class="item-icon">
										<i class="os-icon os-icon-film"></i>
									</div>
									<div class="item-name">
										V<span>ideo</span>.avi
									</div>
								</a>
								<a class="ssg-item" href="#">
									<div class="item-icon">
										<i class="os-icon os-icon-database"></i>
									</div>
									<div class="item-name">
										User<span>Tabl</span>e.sql
									</div>
								</a>
								<a class="ssg-item" href="#">
									<div class="item-icon">
										<i class="os-icon os-icon-image"></i>
									</div>
									<div class="item-name">
										wed<span>din</span>g.jpg
									</div>
								</a>
							</div>
							<div class="ssg-nothing-found">
								<div class="icon-w">
									<i class="os-icon os-icon-eye-off"></i>
								</div>
								<span>No files were found. Try changing your query...</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="layout-w">
				<!--------------------
					START - Mobile Menu
					-------------------->
				<div class="menu-mobile menu-activated-on-click color-scheme-dark">
					<div class="mm-logo-buttons-w">
						<a class="mm-logo" href="/"><img src="/img/logo.png"><span>Bevura</span></a>
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
								<img alt="" src="/images/avatar1.png">
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
						<!--------------------
							START - Mobile Menu List
							-------------------->

						@if(\Auth::user()->role_code=='POTZR_STAFF')
							@include('partials.navigation_bar_potzr_staff')
						@elseif(\Auth::user()->role_code=='EXCO_STAFF')
							@include('partials.navigation_bar_exco_staff')
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
						<!--<div class="mobile-menu-magic">
							<h4>
								Light Admin
							</h4>
							<p>
								Clean Bootstrap 4 Template
							</p>
							<div class="btn-w">
								<a class="btn btn-white btn-rounded" href="https://themeforest.net/item/light-admin-clean-bootstrap-dashboard-html-template/19760124?ref=Osetin" target="_blank">Purchase Now</a>
							</div>
						</div>-->
					</div>
				</div>
				<!--------------------
					END - Mobile Menu
					--------------------><!--------------------
					START - Main Menu
					-------------------->
				<div class="menu-w color-scheme-light color-style-transparent menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
					<div class="logo-w">
						<a class="mm-logo" href="/"><img src="/img/logo.png"><span>Bevura</span></a>
					</div>
					<div class="logged-user-w avatar-inline">
						<div class="logged-user-i">
							<div class="avatar-w">
								<img alt="" src="/img/{{isset(\Auth::user()->profile_pix) && \Auth::user()->profile_pix!=null ? \Auth::user()->profile_pix : 'avatar1.jpg'}}">
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
										<img alt="" src="/img/{{isset(\Auth::user()->profile_pix) && \Auth::user()->profile_pix!=null ? \Auth::user()->profile_pix : 'avatar1.jpg'}}">
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
									<li>
										<a href="/logout"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
									</li>
									<!--<li>
										<a href="users_profile_big.html"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a>
									</li>
									<li>
										<a href="users_profile_small.html"><i class="os-icon os-icon-coins-4"></i><span>Billing Details</span></a>
									</li>
									<li>
										<a href="/notifications"><i class="os-icon os-icon-others-43"></i><span>Notifications</span></a>
									</li>
									<li>
										<a href="/logout"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
									</li>-->
								</ul>
							</div>
						</div>
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
					@elseif(\Auth::user()->role_code=='AGENT')
						@include('partials.navigation_bar_agent_web')
                    @endif
				</div>
				<!--------------------
					END - Main Menu
					-------------------->
				<div class="content-w" style="padding-left: 0px !important;">
					<!--------------------
						START - Top Bar
						-------------------->
					<div class="top-bar color-scheme-transparent">
						<!--------------------
							START - Top Menu Controls
							-------------------->
						<div class="top-menu-controls">
							<!--<div class="element-search autosuggest-search-activator">
								<input placeholder="Start typing to search..." type="text">
							</div>
							
							<div class="messages-notifications os-dropdown-trigger os-dropdown-position-left">
								<i class="os-icon os-icon-mail-14"></i>
								<div class="new-messages-count">
									12
								</div>
								<div class="os-dropdown light message-list">
									<ul>
										<li>
											<a href="#">
												<div class="user-avatar-w">
													<img alt="" src="/img/{{\Auth::user()->profile_pix}}">
												</div>
												<div class="message-content">
													<h6 class="message-from">
														John Mayers
													</h6>
													<h6 class="message-title">
														Account Update
													</h6>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="user-avatar-w">
													<img alt="" src="/img/avatar2.jpg">
												</div>
												<div class="message-content">
													<h6 class="message-from">
														Phil Jones
													</h6>
													<h6 class="message-title">
														Secutiry Updates
													</h6>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="user-avatar-w">
													<img alt="" src="/img/avatar3.jpg">
												</div>
												<div class="message-content">
													<h6 class="message-from">
														Bekky Simpson
													</h6>
													<h6 class="message-title">
														Vacation Rentals
													</h6>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="user-avatar-w">
													<img alt="" src="/img/avatar4.jpg">
												</div>
												<div class="message-content">
													<h6 class="message-from">
														Alice Priskon
													</h6>
													<h6 class="message-title">
														Payment Confirmation
													</h6>
												</div>
											</a>
										</li>
									</ul>
								</div>
							</div>
							
							<div class="top-icon top-settings os-dropdown-trigger os-dropdown-position-left">
								<i class="os-icon os-icon-ui-46"></i>
								<div class="os-dropdown">
									<div class="icon-w">
										<i class="os-icon os-icon-ui-46"></i>
									</div>
									<ul>
										<li>
											<a href="users_profile_small.html"><i class="os-icon os-icon-ui-49"></i><span>Profile Settings</span></a>
										</li>
										<li>
											<a href="users_profile_small.html"><i class="os-icon os-icon-grid-10"></i><span>Billing Info</span></a>
										</li>
										<li>
											<a href="users_profile_small.html"><i class="os-icon os-icon-ui-44"></i><span>My Invoices</span></a>
										</li>
										<li>
											<a href="users_profile_small.html"><i class="os-icon os-icon-ui-15"></i><span>Cancel Account</span></a>
										</li>
									</ul>
								</div>
							</div>-->
							<!--------------------
								END - Settings Link in secondary top menu
								--------------------><!--------------------
								START - User avatar and menu in secondary top menu
								-------------------->
							<div class="logged-user-w">
								<div class="logged-user-i">
									<div class="avatar-w">
										<img alt="" src="/img/{{\Auth::user()->profile_pix}}">
									</div>
									<div class="logged-user-menu color-style-bright">
										<div class="logged-user-avatar-info">
											<div class="avatar-w">
												<img alt="" src="/img/{{\Auth::user()->profile_pix}}">
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
										<!--<ul>
											<li>
												<a href="apps_email.html"><i class="os-icon os-icon-mail-01"></i><span>Incoming Mail</span></a>
											</li>
											<li>
												<a href="users_profile_big.html"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a>
											</li>
											<li>
												<a href="users_profile_small.html"><i class="os-icon os-icon-coins-4"></i><span>Billing Details</span></a>
											</li>
											<li>
												<a href="#"><i class="os-icon os-icon-others-43"></i><span>Notifications</span></a>
											</li>
											<li>
												<a href="/logout"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
											</li>
										</ul>-->
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
						@foreach($breadcrumbs as $breadcrumbName => $link)
						<li class="breadcrumb-item">
							@if($link!=null)
								<a href="{{$link}}">{{$breadcrumbName}}</a>
							@else
								<span>{{$breadcrumbName}}</span>
							@endif
						</li>
						@endforeach
					</ul>
					<!--------------------
						END - Breadcrumbs
						-------------------->
					<div class="content-panel-toggler">
						<i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span>
					</div>
					<div class="content-i">

						@yield('content')
						@yield('extraviews')
						<!--
						<div class="content-panel">
							<div class="content-panel-close">
								<i class="os-icon os-icon-close"></i>
							</div>
							<div class="element-wrapper">
								<h6 class="element-header">
									Support Agents
								</h6>
								<div class="element-box-tp">
									<div class="profile-tile">
										<a class="profile-tile-box" href="users_profile_small.html">
											<div class="pt-avatar-w">
												<img alt="" src="/img/avatar1.jpg">
											</div>
											<div class="pt-user-name">
												John Mayers
											</div>
										</a>
										<div class="profile-tile-meta">
											<ul>
												<li>
													Last Login:<strong>Online Now</strong>
												</li>
												<li>
													Tickets:<strong><a href="apps_support_index.html">12</a></strong>
												</li>
												<li>
													Response Time:<strong>2 hours</strong>
												</li>
											</ul>
											<div class="pt-btn">
												<a class="btn btn-success btn-sm" href="apps_full_chat.html">Send Message</a>
											</div>
										</div>
									</div>
									<div class="profile-tile">
										<a class="profile-tile-box" href="users_profile_small.html">
											<div class="pt-avatar-w">
												<img alt="" src="/img/avatar3.jpg">
											</div>
											<div class="pt-user-name">
												Ben Gossman
											</div>
										</a>
										<div class="profile-tile-meta">
											<ul>
												<li>
													Last Login:<strong>Offline</strong>
												</li>
												<li>
													Tickets:<strong><a href="apps_support_index.html">9</a></strong>
												</li>
												<li>
													Response Time:<strong>3 hours</strong>
												</li>
											</ul>
											<div class="pt-btn">
												<a class="btn btn-secondary btn-sm" href="apps_full_chat.html">Send Message</a>
											</div>
										</div>
									</div>
									<div class="profile-tile">
										<a class="profile-tile-box" href="users_profile_small.html">
											<div class="pt-avatar-w">
												<img alt="" src="/img/avatar2.jpg">
											</div>
											<div class="pt-user-name">
												Ken Sorrons
											</div>
										</a>
										<div class="profile-tile-meta">
											<ul>
												<li>
													Last Login:<strong>Offline</strong>
												</li>
												<li>
													Tickets:<strong><a href="apps_support_index.html">17</a></strong>
												</li>
												<li>
													Response Time:<strong>1 hour</strong>
												</li>
											</ul>
											<div class="pt-btn">
												<a class="btn btn-danger btn-sm" href="apps_full_chat.html">Send Message</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="element-wrapper">
								<h6 class="element-header">
									Side Tables
								</h6>
								<div class="element-box">
									<h5 class="form-header">
										Table in white box
									</h5>
									<div class="form-desc">You can put a table tag inside an <code>.element-box</code> class wrapper and add <code>.table</code> class to it to get something like this:
									</div>
									<div class="controls-above-table">
										<div class="row">
											<div class="col-sm-12">
												<a class="btn btn-sm btn-primary" href="#">Download CSV</a><a class="btn btn-sm btn-danger" href="#">Delete</a>
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-lightborder">
											<thead>
												<tr>
													<th>
														Customer
													</th>
													<th class="text-center">
														Status
													</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														John Mayers
													</td>
													<td class="text-center">
														<div class="status-pill green" data-title="Complete" data-toggle="tooltip"></div>
													</td>
												</tr>
												<tr>
													<td>
														Kelly Brans
													</td>
													<td class="text-center">
														<div class="status-pill red" data-title="Cancelled" data-toggle="tooltip"></div>
													</td>
												</tr>
												<tr>
													<td>
														Tim Howard
													</td>
													<td class="text-center">
														<div class="status-pill green" data-title="Complete" data-toggle="tooltip"></div>
													</td>
												</tr>
												<tr>
													<td>
														Joe Trulli
													</td>
													<td class="text-center">
														<div class="status-pill yellow" data-title="Pending" data-toggle="tooltip"></div>
													</td>
												</tr>
												<tr>
													<td>
														Fred Kolton
													</td>
													<td class="text-center">
														<div class="status-pill green" data-title="Complete" data-toggle="tooltip"></div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						-->
					</div>
				</div>
			</div>
			<div class="display-type"></div>
		</div>

	@if(\Auth::user()->role_code=='CUSTOMER')
       	@include('core.authenticated.account.account_listing_view_for_customer')
	@endif



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
		<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/js/all.min.js"></script>

		@yield('scripts')

		@include('partials.notify')

		<script>


		</script>
	</body>
</html>
