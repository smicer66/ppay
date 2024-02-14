<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ProbasePay | Pay Zambia</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css?abc=2">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Font Awesome
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">-->
  <!-- jvectormap -->
  <link rel="stylesheet" href="/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/AdminLTE.min.css?xyz=2">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css?l=3">
  <link rel="stylesheet" href="/plugins/timepicker/bootstrap-timepicker.min.css">
  
  <link rel="stylesheet" href="/css/css2.css">
  <!--<link rel="stylesheet" href="/css/styles12.css">-->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  @yield('css')
  <![endif]-->
	<style>
		.control-label{
			font-weight: bold !important;
			text-align: left !important;
			padding-left: 30px !important;
			font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
		}
		
		body{
			font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
		}
		
		.btn-group > .dropdown-menu
		{
			position: absolute;
			bottom: 100% !important;
			right: 0 !important;
			top: auto !important;
			left: auto !important;
		}
	</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="/menu" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Pb</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Probase</b>Pay</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="background-color: #000 !important;">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!-- Notifications: style can be found in dropdown.less -->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{\Auth::user()->profile_pix!=null ? "/files/passports/".\Auth::user()->profile_pix : "/dist/img/user2-160x160.jpg"}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{\Auth::user()->username}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header" style="background-color: #000 !important;">
                <img src="{{\Auth::user()->profile_pix!=null ? "/files/passports/".\Auth::user()->profile_pix : "/dist/img/user2-160x160.jpg"}}" class="img-circle" alt="User Image">

                <p>
                  <small>Signed In As</small>
                  {{\Auth::user()->username}}
                </p>
              </li>
              <!-- Menu Body -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="/user/password-change" class="btn btn-primary btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="/logout" class="btn btn-danger btn-flat">Sign Out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>

    </nav>
  </header>

  <?php
    $roles = new \App\Models\Roles();
  ?>

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px !important; ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
          <h1>
            <div class="col col-md-6">

              @yield('section_title')
            </div>

            <div class="col col-md-6">

                @yield('quick_buttons')
                &nbsp;
              </div>
          </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
	
	@include('core.authenticated.partials.quick_view_customer_accounts')
	@include('core.authenticated.partials.quick_view_customer_cards')
	@include('core.authenticated.partials.quick_view_customer_profile')
	@include('core.authenticated.partials.quick_view_customer_new_account')
	@include('core.authenticated.partials.quick_view_new_customer_account_card')
	@include('core.authenticated.partials.quick_view_account_cards')
	@include('core.authenticated.partials.quick_view_account_balance')
	@include('core.authenticated.partials.quick_view_card_balance')
	@include('core.authenticated.partials.quick_view_new_customer_card')
	@include('core.authenticated.partials.quick_view_transfer_customer_card')
	@include('core.authenticated.partials.quick_view_change_card_pin')
	@include('core.authenticated.partials.quick_view_change_card_cvv')
	
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Powered By </b>Probase Group
    </div>
    <strong>Copyright &copy; 2014-2015 <a href="http://probasegroup.com">Probase Group</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->

</div>



<!-- ./wrapper -->

<!-- jQuery 2.2.0-->
@yield('scripts1')
<!--<script src="/dist/js/demo.js"></script>-->
<script src="/plugins/jQuery/jQuery-2.1.4.min.js?ls=1"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/plugins/fastclick/fastclick.min.js"></script>
<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="/js/app.min.js"></script>
<script src="/js/demo.js?ks=3"></script><!---->

@yield('scripts')

@yield('extraviews')

</body>
</html>
