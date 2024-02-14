
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <!--<li class="active treeview">
                <a href="/dashboard">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Layout Options</span>
                <span class="label label-primary pull-right">4</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
              </ul>
            </li>
            <li>
              <a href="pages/widgets.html">
                <i class="fa fa-th"></i> <span>Widgets</span>
                <small class="label pull-right bg-green">new</small>
              </a>
            </li>-->
            <?php

            $id = \Crypt::encryptPseudo(intval(\Auth::user()->merchant_id), \Auth::user()->merchant_dec_key);
            ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Devices</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/merchant/devices/view-merchant-devices/{{$id}}"><i class="fa fa-circle-o"></i> My Device Listing</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Vendor Services</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/merchant/vendor-service/vendor-service-listing/{{$id}}"><i class="fa fa-circle-o"></i> My Vendor Service Listing</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Transactions</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/merchant/transactions/all-device/{{$id}}"><i class="fa fa-circle-o"></i> My Transactions</a></li>
                </ul>
            </li>
            <!--<li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Accounts</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/merchant/transactions/all-device/{{$id}}"><i class="fa fa-circle-o"></i> My Transactions</a></li>
                </ul>
            </li>-->
        </ul>
