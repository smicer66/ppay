@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Teller @stop
@section('css')


  <!--  Paper Dashboard core CSS    -->
  <link href="/assets/css/demo.css" rel="stylesheet" />
@stop
@section('content')

@include('partials.errors')
<!-- Info boxes -->
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-clone"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Virtual Accounts</span>
        <span class="info-box-number">{{number_format($dashboardStatistics->virtualAcctCount, 0, '', ',')}}<small></small></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Credit/Debit Cards</span>
        <span class="info-box-number">{{number_format($dashboardStatistics->cardCount, 0, '', ',')}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-mobile"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Mobile Accounts</span>
        <span class="info-box-number">{{number_format($dashboardStatistics->mobileAcctCount, 0, '', ',')}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">ProbaseWallet Users</span>
        <span class="info-box-number">{{number_format($dashboardStatistics->walletAcctCount, 0, '', ',')}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Monthly Recap Report</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <div class="btn-group">
            <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-wrench"></i></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </div>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-8">
            <p class="text-center">
              <strong>Transactions: 1 {{date('M, Y')}} - 30 {{date('M, Y')}}</strong>
            </p>

            <div class="chart">
              <!-- Sales Chart Canvas -->
              <!--<canvas id="salesChart" style="height: 180px;"></canvas>-->
              <div id="chartPreferences" class="ct-chart ct-perfect-fourth"></div>
            </div>
            <!-- /.chart-responsive -->
          </div>
          <!-- /.col -->
		  <?php
		  try
		  {
		  ?>
          
		  <?php
		  }
		  catch(\Exception $e)
		  {
			  
		  }
		  ?>
        </div>
        <!-- /.row -->
      </div>
      <!-- ./box-body -->
      <div class="box-footer">
        <div class="row">
          <div class="col-sm-3 col-xs-6">
            <!--<div class="description-block border-right">
              <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
              <h5 class="description-header">$35,210.43</h5>
              <span class="description-text">TOTAL REVENUE</span>
            </div>-->
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-xs-6">
            <!--<div class="description-block border-right">
              <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
              <h5 class="description-header">$10,390.90</h5>
              <span class="description-text">TOTAL COST</span>
            </div>-->
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-xs-6">
            <!--<div class="description-block border-right">
              <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
              <h5 class="description-header">$24,813.53</h5>
              <span class="description-text">TOTAL PROFIT</span>
            </div>-->
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-xs-6">
            <!--<div class="description-block">
              <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
              <h5 class="description-header">1200</h5>
              <span class="description-text">GOAL COMPLETIONS</span>
            </div>-->
            <!-- /.description-block -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <div class="col-md-8">

    <!-- TABLE: LATEST ORDERS -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Latest Transactions</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin">
            <thead>
            <tr>
              <th>Transaction Ref</th>
              <th>Channel</th>
              <th>Status</th>
              <th style="text-align:right !important">Amount (ZMW)</th>
            </tr>
            </thead>
            <tbody>
            @foreach(json_decode($dashboardStatistics->lastTransactions) as $transaction)
            <tr>
              <td><a href="pages/examples/invoice.html">{{$transaction->transactionRef}}</a></td>
              <td>{{$transaction->channel}}</td>
              <td><span class="label label-{{$transaction->status=="SUCCESS" ? "success" :
              ($transaction->status=="PAIDOUT" ? "primary" : ($transaction->status=="PENDING" ? "warning" : "info"))}}">{{$transaction->status}}</span></td>
              <td>
                <div class="sparkbar" data-color="#00a65a" data-height="20" style="text-align:right !important">{{number_format($transaction->amount, 2, '.', ',')}}</div>
              </td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>
      <!-- /.box-body -->
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->


  <?php
  $wall = isset($dashboardStatistics->walletAcctSum) ? $dashboardStatistics->walletAcctSum : 0.0;
  $mob = isset($dashboardStatistics->mobileAcctSum) ? $dashboardStatistics->mobileAcctSum : 0.0;
  $card = isset($dashboardStatistics->cardSum) ? $dashboardStatistics->cardSum : 0.0;
  $virt = isset($dashboardStatistics->virtualAcctSum) ? $dashboardStatistics->virtualAcctSum : 0.0;
  $totalAmt = $wall + $mob + $card + $virt;
  ?>

  <div class="col-md-4">
    <!-- Info Boxes Style 2 -->
    <div class="info-box bg-yellow">
      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

      
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    
    <!-- /.info-box -->

  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@stop
@section('section_title') <!--<i class="fa fa-server" style="color:#00a65a"></i>&nbsp;&nbsp;-->@stop

@section('scripts1')

  <script src="/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
  <script src="/assets/js/demo.js?od=3"></script>
  <script src="/assets/js/chartist.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      demo.initChartist([40, 60, 80],
              ['30%', '40%', '30%'], [], []);

    });
  </script>
@stop

@section('scripts')

@stop