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
    <link href="favicon.png" rel="shortcut icon">
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
</head>
<body class="menu-position-side menu-side-left full-screen with-content-panel">


<div class="all-wrapper with-side-panel solid-bg-all">
    <div aria-hidden="true" class="onboarding-modal modal fade animated" id="cards_overview_modal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-centered" role="document">
            <div class="modal-content text-center">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="os-icon os-icon-close"></span></button>
                <div class="onboarding-slider-w">
                    <div class="onboarding-slide" style="background-image: url(../img/onboarding-gradient-hor.png); width: 550px; background-position: 50% !important; background-size: contain; background-repeat: no-repeat;">
                        <div class="onboarding-media" style="padding-top:60px !important">
                            <img width="200px" src="http://creditcard.axiomthemes.com/wp-content/uploads/2017/06/card-1.png">
                        </div>
                        <div class="onboarding-content with-gradient" style="background-image: none !important;">
                            @if($accounts!=null && sizeof($accounts)>0)
                                <h4 class="onboarding-title">
                                    Add A New Card
                                </h4>
                                <div class="onboarding-text" style="color: #000 !Important">
                                    Adding a new card is easy.
                                </div>
                            @else
                                <h4 class="onboarding-title">
                                    Your first card or wallet
                                </h4>
                                <div class="onboarding-text" style="color: #000 !Important">
                                    Setting one up is easy. You can later on add other cards or wallets. Lets help you setup your first card or wallet.
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="onboarding-slide" style="background-image: url(../img/onboarding-gradient-hor.png); width: 550px; background-position: 50% !important; background-size: contain; background-repeat: no-repeat;">
                        <div class="onboarding-media" style="padding-top:60px !important">
                            <img width="200px" src="http://creditcard.axiomthemes.com/wp-content/uploads/2017/06/card-1.png">
                        </div>
                        <div class="onboarding-content with-gradient" style="background-image: none !important;">
                            @if($accounts!=null && sizeof($accounts)>0)
                            @else
                            <h4 class="onboarding-title">
                                Step One
                            </h4>
                            @endif
                            <div class="onboarding-text" style="text-align: left !important; color: #000 !Important; padding-left: 0px !important; text-align: center !important">
                                <strong>Virtual wallet:</strong><br>Convenience and Zero card costs!<br>
                                <strong>Physical cards:</strong><br>Stylish! Interested in gold-plated cards?<br>
                                <small style="font-weight: 100 !important">Information with red asterisk (<span style="color: red">*</span>) must be provided</small>
                            </div>
                            <form id="newWalletForm">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Your Preferred Product<span style="color: red">*</span></label>
                                            <select class="form-control" name="newWalletCardScheme">
                                                @foreach($all_card_schemes as $card_scheme)
                                                <option value="{{$card_scheme->id}}">
                                                    {{$card_scheme->schemeName}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Wallet or Card?<span style="color: red">*</span></label>
                                            <select class="form-control" name="newWalletCardType">
                                                <option value="TUTUKA_VIRTUAL_CARD">
                                                    I Want A Virtual Wallet
                                                </option>
                                                <option value="TUTUKA_PHYSICAL_CARD">
                                                    I Want A Physical Card
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if($accounts!=null && sizeof($accounts)>0)
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12" style="text-align: right !important">
                                            <div class="">
                                                <a style="cursor: pointer !important" class="btn btn-success pull-right" onclick="handleNewCard('{{\Session::get('jwt_token')}}', event, 'newWalletForm')">Create My Card</a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                @endif
                            </form>
                        </div>
                    </div>


                    @if($accounts!=null && sizeof($accounts)>0)
                    @else
                    <div class="onboarding-slide" style="background-image: url(../img/onboarding-gradient-hor.png); width: 550px; background-position: 50% !important; background-size: contain; background-repeat: no-repeat;">
                        <div class="onboarding-media" style="padding-top:60px !important">
                            <img width="200px" src="http://creditcard.axiomthemes.com/wp-content/uploads/2017/06/card-1.png">
                        </div>
                        <div class="onboarding-content with-gradient" style="background-image: none !important;">
                            <h4 class="onboarding-title">
                                Step Two
                            </h4>
                            <div class="onboarding-text" style="text-align: left !important; color: #000 !Important; padding-left: 0px !important; text-align: center !important">
                                Provide us some information about you.<br>
                                <small style="font-weight: 100 !important">Information with red asterisk (<span style="color: red">*</span>) must be provided</small>
                            </div>
                            <form id="newWalletFormStepTwo" data-toggle="validator">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="">Home Address<span style="color: red">*</span></label>
                                            <input type="text" name="newWalletAddressLine1" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">City<span style="color: red">*</span></label>
                                            <input type="text" name="newWalletAddressLine2" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">District<span style="color: red">*</span></label>
                                            <select class="form-control" name="newWalletDistrict" required>
                                                @foreach($all_districts as $district)
                                                    <option value="{{$district->id}}">
                                                        {{$district->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Means of Identification<span style="color: red">*</span></label>
                                            <select class="form-control" name="newWalletMeansOfIdentification" required>
                                                <option value="NATIONAL_ID">
                                                    National ID
                                                </option>
                                                <option value="INTERNATIONAL_PASSPORT">
                                                    International Passport
                                                </option>
                                                <option value="DRIVERS_LICENSE">
                                                    Drivers License
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Identity Number<span style="color: red">*</span></label>
                                            <input type="text" name="newWalletIdentityNumber" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Gender<span style="color: red">*</span></label>
                                            <select class="form-control" name="newWalletGender" required>
                                                <option value="MALE">
                                                    I'm A Male
                                                </option>
                                                <option value="FEMALE">
                                                    I'm A Female
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Date Of Birth<span style="color: red">*</span></label>
                                            <!--<input type="text" name="newWalletDateOfBirth" class="form-control">-->
                                            <input class="single-daterange form-control" name="newWalletDateOfBirth" placeholder="Date of birth" type="text" value="04/12/1978">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email Address</label>
                                            <input type="email" name="newWalletEmailAddress" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12" style="text-align: right !important">
                                        <div class="">
                                            <a style="cursor: pointer !important"  class="btn btn-success pull-right" onclick="handleNewCard('{{\Session::get('jwt_token')}}', event, 'newWalletForm', 'newWalletFormStepTwo')">Create My Card</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                    <!--<div class="onboarding-slide">
                        <div class="onboarding-media">
                            <img alt="" src="img/bigicon6.png" width="200px">
                        </div>
                        <div class="onboarding-content with-gradient">
                            <h4 class="onboarding-title">
                                Showcase App Features
                            </h4>
                            <div class="onboarding-text">
                                In this example you can showcase some of the features of your application, it is very handy to make new users aware of your hidden features. You can use boostrap columns to split them up.
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul class="features-list">
                                        <li>
                                            Fully Responsive design
                                        </li>
                                        <li>
                                            Pre-built app layouts
                                        </li>
                                        <li>
                                            Incredible Flexibility
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="features-list">
                                        <li>
                                            Boxed & Full Layouts
                                        </li>
                                        <li>
                                            Based on Bootstrap 4
                                        </li>
                                        <li>
                                            Developer Friendly
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
    <div class="search-with-suggestions-w">
        <div class="search-with-suggestions-modal">
            <div class="element-search">
                <input class="search-suggest-input" placeholder="Start typing to search..." type="text">
                <div class="close-search-suggestions">
                    <i class="os-icon os-icon-x"></i>
                </div>
                </input>
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
                        </a><a class="ssg-item" href="users_profile_big.html">
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
                        </a><a class="ssg-item" href="users_profile_big.html">
                            <div class="item-media" style="background-image: url(img/avatar2.jpg)"></div>
                            <div class="item-name">
                                Th<span>omas</span> Mullier
                            </div>
                        </a><a class="ssg-item" href="users_profile_big.html">
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
                        </a><a class="ssg-item" href="#">
                            <div class="item-icon">
                                <i class="os-icon os-icon-film"></i>
                            </div>
                            <div class="item-name">
                                V<span>ideo</span>.avi
                            </div>
                        </a><a class="ssg-item" href="#">
                            <div class="item-icon">
                                <i class="os-icon os-icon-database"></i>
                            </div>
                            <div class="item-name">
                                User<span>Tabl</span>e.sql
                            </div>
                        </a><a class="ssg-item" href="#">
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
                <a class="mm-logo" href="index.html"><img src="img/logo.png"><span>Clean Admin</span></a>
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
                        <img alt="" src="img/avatar1.jpg">
                    </div>
                    <div class="logged-user-info-w">
                        <div class="logged-user-name">
                            Maria Gomez
                        </div>
                        <div class="logged-user-role">
                            Administrator
                        </div>
                    </div>
                </div>
                <!--------------------
                START - Mobile Menu List
                -------------------->
                <ul class="main-menu">
                    <li class="">
                        <a href="/dashboard">
                            <div class="icon-w">
                                <div class="os-icon os-icon-layout"></div>
                            </div>
                            <span>Dashboard</span></a>
                    </li>
                    <li class="has-sub-menu">
                        <a href="layouts_menu_top_image.html">
                            <div class="icon-w">
                                <div class="os-icon os-icon-layers"></div>
                            </div>
                            <span>Menu Styles</span></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="layouts_menu_side_full.html">Side Menu Light</a>
                            </li>
                            <li>
                                <a href="layouts_menu_side_full_dark.html">Side Menu Dark</a>
                            </li>
                            <li>
                                <a href="layouts_menu_side_transparent.html">Side Menu Transparent <strong class="badge badge-danger">New</strong></a>
                            </li>
                            <li>
                                <a href="apps_pipeline.html">Side &amp; Top Dark</a>
                            </li>
                            <li>
                                <a href="apps_projects.html">Side &amp; Top</a>
                            </li>
                            <li>
                                <a href="layouts_menu_side_mini.html">Mini Side Menu</a>
                            </li>
                            <li>
                                <a href="layouts_menu_side_mini_dark.html">Mini Menu Dark</a>
                            </li>
                            <li>
                                <a href="layouts_menu_side_compact.html">Compact Side Menu</a>
                            </li>
                            <li>
                                <a href="layouts_menu_side_compact_dark.html">Compact Menu Dark</a>
                            </li>
                            <li>
                                <a href="layouts_menu_right.html">Right Menu</a>
                            </li>
                            <li>
                                <a href="layouts_menu_top.html">Top Menu Light</a>
                            </li>
                            <li>
                                <a href="layouts_menu_top_dark.html">Top Menu Dark</a>
                            </li>
                            <li>
                                <a href="layouts_menu_top_image.html">Top Menu Image <strong class="badge badge-danger">New</strong></a>
                            </li>
                            <li>
                                <a href="layouts_menu_sub_style_flyout.html">Sub Menu Flyout</a>
                            </li>
                            <li>
                                <a href="layouts_menu_sub_style_flyout_dark.html">Sub Flyout Dark</a>
                            </li>
                            <li>
                                <a href="layouts_menu_sub_style_flyout_bright.html">Sub Flyout Bright</a>
                            </li>
                            <li>
                                <a href="layouts_menu_side_compact_click.html">Menu Inside Click</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub-menu">
                        <a href="apps_bank.html">
                            <div class="icon-w">
                                <div class="os-icon os-icon-package"></div>
                            </div>
                            <span>Applications</span></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="apps_email.html">Email Application</a>
                            </li>
                            <li>
                                <a href="apps_support_dashboard.html">Support Dashboard</a>
                            </li>
                            <li>
                                <a href="apps_support_index.html">Tickets Index</a>
                            </li>
                            <li>
                                <a href="apps_crypto.html">Crypto Dashboard <strong class="badge badge-danger">New</strong></a>
                            </li>
                            <li>
                                <a href="apps_projects.html">Projects List</a>
                            </li>
                            <li>
                                <a href="apps_bank.html">Banking <strong class="badge badge-danger">New</strong></a>
                            </li>
                            <li>
                                <a href="apps_full_chat.html">Chat Application</a>
                            </li>
                            <li>
                                <a href="apps_todo.html">To Do Application <strong class="badge badge-danger">New</strong></a>
                            </li>
                            <li>
                                <a href="misc_chat.html">Popup Chat</a>
                            </li>
                            <li>
                                <a href="apps_pipeline.html">CRM Pipeline</a>
                            </li>
                            <li>
                                <a href="rentals_index_grid.html">Property Listing <strong class="badge badge-danger">New</strong></a>
                            </li>
                            <li>
                                <a href="misc_calendar.html">Calendar</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-file-text"></div>
                            </div>
                            <span>Pages</span></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="misc_invoice.html">Invoice</a>
                            </li>
                            <li>
                                <a href="ecommerce_order_info.html">Order Info <strong class="badge badge-danger">New</strong></a>
                            </li>
                            <li>
                                <a href="rentals_index_grid.html">Property Listing <strong class="badge badge-danger">New</strong></a>
                            </li>
                            <li>
                                <a href="misc_charts.html">Charts</a>
                            </li>
                            <li>
                                <a href="auth_login.html">Login</a>
                            </li>
                            <li>
                                <a href="auth_register.html">Register</a>
                            </li>
                            <li>
                                <a href="auth_lock.html">Lock Screen</a>
                            </li>
                            <li>
                                <a href="misc_pricing_plans.html">Pricing Plans</a>
                            </li>
                            <li>
                                <a href="misc_error_404.html">Error 404</a>
                            </li>
                            <li>
                                <a href="misc_error_500.html">Error 500</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-life-buoy"></div>
                            </div>
                            <span>UI Kit</span></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="uikit_modals.html">Modals <strong class="badge badge-danger">New</strong></a>
                            </li>
                            <li>
                                <a href="uikit_alerts.html">Alerts</a>
                            </li>
                            <li>
                                <a href="uikit_grid.html">Grid</a>
                            </li>
                            <li>
                                <a href="uikit_progress.html">Progress</a>
                            </li>
                            <li>
                                <a href="uikit_popovers.html">Popover</a>
                            </li>
                            <li>
                                <a href="uikit_tooltips.html">Tooltips</a>
                            </li>
                            <li>
                                <a href="uikit_buttons.html">Buttons</a>
                            </li>
                            <li>
                                <a href="uikit_dropdowns.html">Dropdowns</a>
                            </li>
                            <li>
                                <a href="uikit_typography.html">Typography</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-mail"></div>
                            </div>
                            <span>Emails</span></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="emails_welcome.html">Welcome Email</a>
                            </li>
                            <li>
                                <a href="emails_order.html">Order Confirmation</a>
                            </li>
                            <li>
                                <a href="emails_payment_due.html">Payment Due</a>
                            </li>
                            <li>
                                <a href="emails_forgot.html">Forgot Password</a>
                            </li>
                            <li>
                                <a href="emails_activate.html">Activate Account</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-users"></div>
                            </div>
                            <span>Users</span></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="users_profile_big.html">Big Profile</a>
                            </li>
                            <li>
                                <a href="users_profile_small.html">Compact Profile</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-edit-32"></div>
                            </div>
                            <span>Forms</span></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="forms_regular.html">Regular Forms</a>
                            </li>
                            <li>
                                <a href="forms_validation.html">Form Validation</a>
                            </li>
                            <li>
                                <a href="forms_wizard.html">Form Wizard</a>
                            </li>
                            <li>
                                <a href="forms_uploads.html">File Uploads</a>
                            </li>
                            <li>
                                <a href="forms_wisiwig.html">Wisiwig Editor</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-grid"></div>
                            </div>
                            <span>Tables</span></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="tables_regular.html">Regular Tables</a>
                            </li>
                            <li>
                                <a href="tables_datatables.html">Data Tables</a>
                            </li>
                            <li>
                                <a href="tables_editable.html">Editable Tables</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-zap"></div>
                            </div>
                            <span>Icons</span></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="icon_fonts_simple_line_icons.html">Simple Line Icons</a>
                            </li>
                            <li>
                                <a href="icon_fonts_feather.html">Feather Icons</a>
                            </li>
                            <li>
                                <a href="icon_fonts_themefy.html">Themefy Icons</a>
                            </li>
                            <li>
                                <a href="icon_fonts_picons_thin.html">Picons Thin</a>
                            </li>
                            <li>
                                <a href="icon_fonts_dripicons.html">Dripicons</a>
                            </li>
                            <li>
                                <a href="icon_fonts_eightyshades.html">Eightyshades</a>
                            </li>
                            <li>
                                <a href="icon_fonts_entypo.html">Entypo</a>
                            </li>
                            <li>
                                <a href="icon_fonts_font_awesome.html">Font Awesome</a>
                            </li>
                            <li>
                                <a href="icon_fonts_foundation_icon_font.html">Foundation Icon Font</a>
                            </li>
                            <li>
                                <a href="icon_fonts_metrize_icons.html">Metrize Icons</a>
                            </li>
                            <li>
                                <a href="icon_fonts_picons_social.html">Picons Social</a>
                            </li>
                            <li>
                                <a href="icon_fonts_batch_icons.html">Batch Icons</a>
                            </li>
                            <li>
                                <a href="icon_fonts_dashicons.html">Dashicons</a>
                            </li>
                            <li>
                                <a href="icon_fonts_typicons.html">Typicons</a>
                            </li>
                            <li>
                                <a href="icon_fonts_weather_icons.html">Weather Icons</a>
                            </li>
                            <li>
                                <a href="icon_fonts_light_admin.html">Light Admin</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!--------------------
                END - Mobile Menu List
                -------------------->
                <div class="mobile-menu-magic">
                    <h4>
                        Light Admin
                    </h4>
                    <p>
                        Clean Bootstrap 4 Template
                    </p>
                    <div class="btn-w">
                        <a class="btn btn-white btn-rounded" href="https://themeforest.net/item/light-admin-clean-bootstrap-dashboard-html-template/19760124?ref=Osetin" target="_blank">Purchase Now</a>
                    </div>
                </div>
            </div>
        </div>
        @include('core.authenticated.partials.side_menu')
        <div class="content-w">
            <div class="content-i">
                <div class="content-box">
                    <div class="element-wrapper compact pt-4">
                        <div class="element-actions">
                            <a class="btn btn-primary btn-sm" data-target="#cards_overview_modal" data-toggle="modal" ><i class="os-icon os-icon-ui-22"></i><span>Add Card</span></a>
                            <a class="btn btn-success btn-sm" data-target="#cards_overview_modal" data-toggle="modal" ><i class="os-icon os-icon-grid-10"></i><span>Transfer Money</span></a>
                            <a class="btn btn-danger btn-sm" data-target="#cards_overview_modal" data-toggle="modal" ><i class="os-icon os-icon-grid-10"></i><span>Buy Utility</span></a>
                        </div>
                        <h6 class="element-header">
                            Wallet Overview
                        </h6>
                        <div class="element-box-tp">
                            <div class="row">
                                <div class="col-lg-7 col-xxl-6">
                                    <!--START - BALANCES-->
                                    <div class="element-balances">
                                        <div class="balance hidden-mobile">
                                            <div class="balance-title">
                                                Available Balance
                                            </div>
                                            <div class="balance-value">
                                                <span id="overViewAvailableBalance">0.00</span>
                                            </div>
                                            <div class="balance-link">
                                                <a class="btn btn-link btn-underlined" href="#"><span>View Statement</span><i class="os-icon os-icon-arrow-right4"></i></a>
                                            </div>
                                        </div>
                                        <div class="balance">
                                            <div class="balance-title">
                                                Current Balance
                                            </div>
                                            <div class="balance-value" id="overViewCurrentBalance">
                                                0.00
                                            </div>
                                            <div class="balance-link">
                                                <a class="btn btn-link btn-underlined" href="#"><span>Request Increase</span><i class="os-icon os-icon-arrow-right4"></i></a>
                                            </div>
                                        </div>
                                        <div class="balance">
                                            <div class="balance-title">
                                                Today's Bill
                                            </div>
                                            <div class="balance-value danger" id="todaysBill">
                                                $180
                                            </div>
                                            <div class="balance-link">
                                                <a class="btn btn-link btn-underlined btn-gold" href="#"><span>Pay Now</span><i class="os-icon os-icon-arrow-right4"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--END - BALANCES-->
                                </div>
                                <div class="col-lg-5 col-xxl-6">
                                    <!--START - MESSAGE ALERT-->
                                    <div class="alert alert-warning borderless">
                                        <h5 class="alert-heading">
                                            Refer Friends. Get Rewarded
                                        </h5>
                                        <p>
                                            You can earn: 15,000 Membership Rewards points for each approved referral – up to 55,000 Membership Rewards points per calendar year.
                                        </p>
                                        <div class="alert-btn">
                                            <a class="btn btn-white-gold" href="#"><i class="os-icon os-icon-ui-92"></i><span>Send Referral</span></a>
                                        </div>
                                    </div>
                                    <!--END - MESSAGE ALERT-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-xxl-6">
                            <!--START - CHART-->
                            <div class="element-wrapper">
                                <div class="element-box">
                                    <div class="element-actions">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm">
                                                <option selected="true">
                                                    Last 30 days
                                                </option>
                                                <option>
                                                    This Week
                                                </option>
                                                <option>
                                                    This Month
                                                </option>
                                                <option>
                                                    Today
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <h5 class="element-box-header">
                                        Expense History
                                    </h5>
                                    <div class="el-chart-w"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                        <canvas data-chart-data="13,28,19,24,43,49,40,35,42,46" height="212" id="liteLineChartV2" width="709" style="display: block; width: 709px; height: 212px;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!--END - CHART-->
                        </div>
                        <div class="col-lg-5 col-xxl-6">
                            <!--START - Money Withdraw Form-->
                            <div class="element-wrapper">
                                <div class="element-box">
                                    <form id="accountOverViewTransferToCardForm">
                                        <h5 class="element-box-header">
                                            Transfer to My Card
                                        </h5>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label class="lighter" for="">Select Amount</label>
                                                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                        <input class="form-control" placeholder="Enter Amount..." name="amountAccountOverViewTransferToCard" id="amountAccountOverViewTransferToCard" type="text" value="0">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text defaultTransferCurrency" id="">
                                                                USD
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="form-group">
                                                    <label class="lighter" for="">Transfer to</label><select name="cardAccountOverViewTransferToCard" id="cardAccountOverViewTransferToCard" class="form-control">
                                                        @foreach($cards as $card)
                                                        <option value="{{$card->trackingNumber}}|||{{$card->serialNo}}">
                                                            {{$card->nameOnCard}} - {{$card->pan}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-buttons-w text-right compact">
                                            <a class="btn btn-grey" data-target="#cards_overview_modal" data-toggle="modal" ><i class="os-icon os-icon-ui-22"></i><span>Add Card</span></a>
                                            <a class="btn btn-primary" onclick="transferWalletToCard('{{\Session::get('jwt_token')}}')"><span>Transfer</span><i class="os-icon os-icon-grid-18"></i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--END - Money Withdraw Form-->
                        </div>
                    </div>
                    <!--START - Transactions Table-->
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            Recent Transactions
                        </h6>
                        <div class="element-box-tp">
                            <div class="table-responsive">
                                <table class="table table-padded">
                                    <thead>
                                    <tr>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Description
                                        </th>
                                        <th class="text-center">
                                            Category
                                        </th>
                                        <th class="text-right">
                                            Amount
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="nowrap">
                                            <span class="status-pill smaller green"></span><span>Complete</span>
                                        </td>
                                        <td>
                                            <span>Today</span><span class="smaller lighter">1:52am</span>
                                        </td>
                                        <td class="cell-with-media">
                                            <img alt="" src="img/company1.png" style="height: 25px;"><span>Banana Shakes LLC</span>
                                        </td>
                                        <td class="text-center">
                                            <a class="badge badge-success" href="">Shopping</a>
                                        </td>
                                        <td class="text-right bolder nowrap">
                                            <span class="text-success">+ 1,250 USD</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="nowrap">
                                            <span class="status-pill smaller red"></span><span>Declined</span>
                                        </td>
                                        <td>
                                            <span>Jan 19th</span><span class="smaller lighter">3:22pm</span>
                                        </td>
                                        <td class="cell-with-media">
                                            <img alt="" src="img/company2.png" style="height: 25px;"><span>Stripe Payment Processing</span>
                                        </td>
                                        <td class="text-center">
                                            <a class="badge badge-danger" href="">Cafe</a>
                                        </td>
                                        <td class="text-right bolder nowrap">
                                            <span class="text-success">+ 952.23 USD</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="nowrap">
                                            <span class="status-pill smaller yellow"></span><span>Pending</span>
                                        </td>
                                        <td>
                                            <span>Yesterday</span><span class="smaller lighter">7:45am</span>
                                        </td>
                                        <td class="cell-with-media">
                                            <img alt="" src="img/company3.png" style="height: 25px;"><span>MailChimp Services</span>
                                        </td>
                                        <td class="text-center">
                                            <a class="badge badge-warning" href="">Restaurants</a>
                                        </td>
                                        <td class="text-right bolder nowrap">
                                            <span class="text-danger">- 320 USD</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="nowrap">
                                            <span class="status-pill smaller yellow"></span><span>Pending</span>
                                        </td>
                                        <td>
                                            <span>Jan 23rd</span><span class="smaller lighter">2:12pm</span>
                                        </td>
                                        <td class="cell-with-media">
                                            <img alt="" src="img/company1.png" style="height: 25px;"><span>Starbucks Cafe</span>
                                        </td>
                                        <td class="text-center">
                                            <a class="badge badge-primary" href="">Shopping</a>
                                        </td>
                                        <td class="text-right bolder nowrap">
                                            <span class="text-success">+ 17.99 USD</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="nowrap">
                                            <span class="status-pill smaller green"></span><span>Complete</span>
                                        </td>
                                        <td>
                                            <span>Jan 12th</span><span class="smaller lighter">9:51am</span>
                                        </td>
                                        <td class="cell-with-media">
                                            <img alt="" src="img/company4.png" style="height: 25px;"><span>Ebay Marketplace</span>
                                        </td>
                                        <td class="text-center">
                                            <a class="badge badge-danger" href="">Groceries</a>
                                        </td>
                                        <td class="text-right bolder nowrap">
                                            <span class="text-danger">- 244 USD</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="nowrap">
                                            <span class="status-pill smaller yellow"></span><span>Pending</span>
                                        </td>
                                        <td>
                                            <span>Jan 9th</span><span class="smaller lighter">12:45pm</span>
                                        </td>
                                        <td class="cell-with-media">
                                            <img alt="" src="img/company2.png" style="height: 25px;"><span>Envato Templates Inc</span>
                                        </td>
                                        <td class="text-center">
                                            <a class="badge badge-primary" href="">Business</a>
                                        </td>
                                        <td class="text-right bolder nowrap">
                                            <span class="text-success">+ 340 USD</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--END - Transactions Table--><!--------------------
              START - Color Scheme Toggler
              -------------------->
                    <div class="floated-colors-btn second-floated-btn">
                        <div class="os-toggler-w">
                            <div class="os-toggler-i">
                                <div class="os-toggler-pill"></div>
                            </div>
                        </div>
                        <span>Dark </span><span>Colors</span>
                    </div>
                    <!--------------------
                    END - Color Scheme Toggler
                    --------------------><!--------------------
              START - Demo Customizer
              -------------------->
                    <div class="floated-customizer-btn third-floated-btn">
                        <div class="icon-w">
                            <i class="os-icon os-icon-ui-46"></i>
                        </div>
                        <span>Customizer</span>
                    </div>
                    <div class="floated-customizer-panel">
                        <div class="fcp-content">
                            <div class="close-customizer-btn">
                                <i class="os-icon os-icon-x"></i>
                            </div>
                            <div class="fcp-group">
                                <div class="fcp-group-header">
                                    Menu Settings
                                </div>
                                <div class="fcp-group-contents">
                                    <div class="fcp-field">
                                        <label for="">Menu Position</label><select class="menu-position-selector">
                                            <option value="left">
                                                Left
                                            </option>
                                            <option value="right">
                                                Right
                                            </option>
                                            <option value="top">
                                                Top
                                            </option>
                                        </select>
                                    </div>
                                    <div class="fcp-field">
                                        <label for="">Menu Style</label><select class="menu-layout-selector">
                                            <option value="compact">
                                                Compact
                                            </option>
                                            <option value="full">
                                                Full
                                            </option>
                                            <option value="mini">
                                                Mini
                                            </option>
                                        </select>
                                    </div>
                                    <div class="fcp-field with-image-selector-w" style="display: none;">
                                        <label for="">With Image</label><select class="with-image-selector">
                                            <option value="yes">
                                                Yes
                                            </option>
                                            <option value="no">
                                                No
                                            </option>
                                        </select>
                                    </div>
                                    <div class="fcp-field">
                                        <label for="">Menu Color</label>
                                        <div class="fcp-colors menu-color-selector">
                                            <div class="color-selector menu-color-selector color-bright"></div>
                                            <div class="color-selector menu-color-selector color-dark"></div>
                                            <div class="color-selector menu-color-selector color-light"></div>
                                            <div class="color-selector menu-color-selector color-transparent selected"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fcp-group">
                                <div class="fcp-group-header">
                                    Sub Menu
                                </div>
                                <div class="fcp-group-contents">
                                    <div class="fcp-field">
                                        <label for="">Sub Menu Style</label><select class="sub-menu-style-selector">
                                            <option value="flyout">
                                                Flyout
                                            </option>
                                            <option value="inside">
                                                Inside/Click
                                            </option>
                                            <option value="over">
                                                Over
                                            </option>
                                        </select>
                                    </div>
                                    <div class="fcp-field">
                                        <label for="">Sub Menu Color</label>
                                        <div class="fcp-colors">
                                            <div class="color-selector sub-menu-color-selector color-bright selected"></div>
                                            <div class="color-selector sub-menu-color-selector color-dark"></div>
                                            <div class="color-selector sub-menu-color-selector color-light"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fcp-group">
                                <div class="fcp-group-header">
                                    Other Settings
                                </div>
                                <div class="fcp-group-contents">
                                    <div class="fcp-field">
                                        <label for="">Full Screen?</label><select class="full-screen-selector">
                                            <option value="yes">
                                                Yes
                                            </option>
                                            <option value="no">
                                                No
                                            </option>
                                        </select>
                                    </div>
                                    <div class="fcp-field">
                                        <label for="">Show Top Bar</label><select class="top-bar-visibility-selector">
                                            <option value="yes">
                                                Yes
                                            </option>
                                            <option value="no">
                                                No
                                            </option>
                                        </select>
                                    </div>
                                    <div class="fcp-field">
                                        <label for="">Above Menu?</label><select class="top-bar-above-menu-selector">
                                            <option value="yes">
                                                Yes
                                            </option>
                                            <option value="no">
                                                No
                                            </option>
                                        </select>
                                    </div>
                                    <div class="fcp-field">
                                        <label for="">Top Bar Color</label>
                                        <div class="fcp-colors">
                                            <div class="color-selector top-bar-color-selector color-bright selected"></div>
                                            <div class="color-selector top-bar-color-selector color-dark"></div>
                                            <div class="color-selector top-bar-color-selector color-light"></div>
                                            <div class="color-selector top-bar-color-selector color-transparent"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--------------------
                    END - Demo Customizer
                    --------------------><!--------------------
              START - Chat Popup Box
              -------------------->
                    <div class="floated-chat-btn">
                        <i class="os-icon os-icon-mail-07"></i><span>Demo Chat</span>
                    </div>
                    <div class="floated-chat-w">
                        <div class="floated-chat-i">
                            <div class="chat-close">
                                <i class="os-icon os-icon-close"></i>
                            </div>
                            <div class="chat-head">
                                <div class="user-w with-status status-green">
                                    <div class="user-avatar-w">
                                        <div class="user-avatar">
                                            <img alt="" src="img/avatar1.jpg">
                                        </div>
                                    </div>
                                    <div class="user-name">
                                        <h6 class="user-title">
                                            John Mayers
                                        </h6>
                                        <div class="user-role">
                                            Account Manager
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-messages ps ps--theme_default" data-ps-id="f416230c-c7a1-822d-f979-25b6e7b1d1cb">
                                <div class="message">
                                    <div class="message-content">
                                        Hi, how can I help you?
                                    </div>
                                </div>
                                <div class="date-break">
                                    Mon 10:20am
                                </div>
                                <div class="message">
                                    <div class="message-content">
                                        Hi, my name is Mike, I will be happy to assist you
                                    </div>
                                </div>
                                <div class="message self">
                                    <div class="message-content">
                                        Hi, I tried ordering this product and it keeps showing me error code.
                                    </div>
                                </div>
                                <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__scrollbar-y-rail" style="top: 0px; right: 0px;"><div class="ps__scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                            <div class="chat-controls">
                                <input class="message-input" placeholder="Type your message here..." type="text">
                                <div class="chat-extra">
                                    <a href="#"><span class="extra-tooltip">Attach Document</span><i class="os-icon os-icon-documents-07"></i></a><a href="#"><span class="extra-tooltip">Insert Photo</span><i class="os-icon os-icon-others-29"></i></a><a href="#"><span class="extra-tooltip">Upload Video</span><i class="os-icon os-icon-ui-51"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--------------------
                    END - Chat Popup Box
                    -------------------->
                </div>
            </div>
        </div>



    </div>
    <div class="display-type"></div>
</div>


@include('core.authenticated.account.account_listing_view_for_customer')
@include('core.authenticated.utility.pay_utility_bill')
@include('core.authenticated.account.customer_new_wallet')


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
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="/js/action.js?version=4.5.0"></script>


<script>
    $( document ).ready(function() {
        loadAccountOverview('{{\Session::get('jwt_token')}}', '{{$accountIdentifier}}');
    });


</script>
</body>
</html>
