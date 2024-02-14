<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Stanbic | Customer Promo</title>
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  @yield('css')
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Stb</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Stanbic</b> Promo</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
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
              <img src="/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">Admin</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <small>Signed In As</small>
                  Admin
                </p>
              </li>
              <!-- Menu Body -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="/user/password-change" class="btn btn-default btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="/logout" class="btn btn-default btn-flat">Sign Out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>

    </nav>
  </header>


  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left info" style="left:0px !important">
          <p><small>Hello Admin</small></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
        <div style="height:50px;"></div>
      </div>
      <!-- search form -->
      <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
        @include('partials.navigation_stanbic_promo_user')
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
          <h1>
            <div class="col col-md-6">

              List of Customers Captured
            </div>

            <div class="col col-md-6">

                
                &nbsp;
              </div>
          </h1>
    </section>

    <!-- Main content -->
    <section class="content">

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Customer Receipt List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Customer Detail</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Merchant Detail</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Receipt No</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Receipt</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending" style="width:120px !important;">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                    $x=0;
                                    ?>
                                <tbody>
                                @foreach($stanbicUsers as $key => $stanbicUser)
                                    <?php
                                    $image_file = "/images/".$stanbicUser->customer_mobile."_".$stanbicUser->identity_id.".png";
                                    ?>
                                    <tr role="row" class="{{$x++%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1"><small>{{$stanbicUser->customer_name}}<br>{{$stanbicUser->customer_mobile}}</small></td>
                                        <td class="sorting_1"><small>{{$stanbicUser->name}}<br>{{$stanbicUser->username}}</small></td>
										@if($stanbicUser->receipt_no==null)
											<td class="sorting_1"><small>
											    <form action="/update-stanbic-promo-receipts/{{$stanbicUser->id}}" method="post">
											    <input type="text" name="receipt_no_{{$stanbicUser->id}}" class="pull-right"><br>
											    <input type="submit" value="Save" class="btn btn-success pull-right">
											    </form></small></td>
										@else
											<td class="sorting_1"><small>{{$stanbicUser->receipt_no}}</small></td>
										@endif
                                        <td>
											<img src="{{$image_file}}" style="height:200px !important; width: 200px !important">
										</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-primary" type="button">Action</button>
                                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu rm">

                                                            <li><a href="{{$image_file}}" target="_window">Download Receipt</a></li>
                                                    
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>



</section>
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


<!--<script src="/dist/js/demo.js"></script>-->
<script src="/plugins/jQuery/jQuery-2.1.4.min.js?ls=1"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/plugins/fastclick/fastclick.min.js"></script>
<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="/js/app.min.js"></script>
<script src="/js/demo.js?ks=3"></script><!---->


</body>
</html>
