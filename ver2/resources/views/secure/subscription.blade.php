
<link href="/css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">

<style>
	.skin-option {
		position: fixed;
		text-align: center;
		right: -1px;
		padding: 10px;
		top: 80px;
		width: 150px;
		height: 133px;
		text-transform: uppercase;
		background-color: #ffffff;
		box-shadow: 0 1px 10px 0px rgba(0, 0, 0, 0.05), 10px 12px 7px 3px rgba(0, 0, 0, .1);
		border-radius: 4px 0 0 4px;
		z-index: 100;
	}
</style>

<div style="background-color: #fff !important;" class="col-md-12">
	
	<div class="pull-right" style="padding-right: 30px; padding-top:20px;">
		<a href="javascript:closeModals()"><i class="fa fa-close"></i></a>
	</div>
	<div class="row mt-40 mb-30">

		<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
			
			<div class="submite-list-wrapper">
			
				<div class="row">
					<div class="col-lg-12 text-center welcome-message">
						<h2>
							Your Dashboard
						</h2>

						<p>
							<strong>Kindly Note:</strong> Data displayed on this dashboard are refreshed on page refresh
						</p>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="hpanel">
							<div class="panel-heading">
								<!--<div class="panel-tools">
									<a class="showhide"><i class="fa fa-chevron-up"></i></a>
									<a class="closebox"><i class="fa fa-times"></i></a>
								</div>-->
								Dashboard information and statistics
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-3 text-center">
										<div class="small">
											<strong>Restaurant Menus</strong>
										</div>
										<div>
											<h1 class="font-extra-bold m-t-xl m-b-xs">
												34
											</h1>
											<small>Active Drivers on Platform</small>
										</div>
									</div>
									<div class="col-md-6 text-center">
										<div class="small">
											<strong>Transactions this Month ({{date('M')}})</strong>
										</div>
										<div>
											<h1 class="font-extra-bold m-t-xl m-b-xs">
												53
											</h1>
										</div>
										<div class="small m-t-xl">
											Only Card Payment
										</div>
									</div>
									<div class="col-md-3 text-center">
										<div class="small">
											<strong>Table Reservations</strong>
										</div>
										<div>
											<h1 class="font-extra-bold m-t-xl m-b-xs">
												53
											</h1>
										</div>
										<div class="small m-t-xl">
											Active Passengers on Platform
										</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
							<span class="pull-right">
								  <strong>Last Transaction</strong> sdasd <strong>to</strong> asdasd <strong>(ZMW)232</strong>
							</span>
								As at: {{date('Y M d H:m')}}Hrs
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4">
						<div class="hpanel">
							<div class="panel-body text-center h-200">
								<i class="pe-7s-graph1 fa-4x"></i>

								<h1 class="m-xs"><i class="fa fa-cutlery"></i></h1>

								<h3 class="font-extra-bold no-margins text-success">
									Menus & Pricing
								</h3>
								<small>Add new menus, manage existing restaurant menus etc</small>
							</div>
							<div class="panel-footer">
								<select class="form-control" id="menus" onchange="javascript:handleDashboardFunctions('menus')">
									<option>-Select An Action-</option>
									<option value="1">New Menu</option>
									<option value="2">List Menus</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="hpanel">
							<div class="panel-body text-center h-200">
								<i class="pe-7s-graph1 fa-4x"></i>

								<h1 class="m-xs"><i class="fa fa-credit-card"></i></h1>

								<h3 class="font-extra-bold no-margins text-success">
									Transactions
								</h3>
								<small>View customer transactions, table reservations and orders</small>
							</div>
							<div class="panel-footer">
								<select class="form-control" id="transactions" onchange="javascript:handleDashboardFunctions('transactions')">
									<option>-Select An Action-</option>
									<option value="3">View Transactions</option>
									<option value="4">View Table Reservations</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="hpanel">
							<div class="panel-body text-center h-200">
								<i class="pe-7s-graph1 fa-4x"></i>

								<h1 class="m-xs"><i class="fa fa-gear"></i></h1>

								<h3 class="font-extra-bold no-margins text-success">
									Settings
								</h3>
								<small>Manage your restaurant features like restaurant settings, promotions</small>
							</div>
							<div class="panel-footer">
								<select class="form-control" id="settings" onchange="javascript:handleDashboardFunctions('settings')">
									<option>-Select An Action-</option>
									<option value="5">Restaurant Settings</option>
									<option value="6">New Promotions</option>
									<option value="7">View Promotions</option>
								</select>
							</div>
						</div>
					</div>
					
					
					<div class="col-lg-4">
						<div class="hpanel">
							<div class="panel-body text-center h-200">
								<i class="pe-7s-graph1 fa-4x"></i>

								<h1 class="m-xs"><i class="fa fa-sliders"></i></h1>

								<h3 class="font-extra-bold no-margins text-success">
									Frontpage Sliders
								</h3>
								<small>Add a front page slide image to get more customer views and patronage</small>
							</div>
							<div class="panel-footer">
								<select class="form-control" id="sliders" onchange="javascript:handleDashboardFunctions('sliders')">
									<option>-Select An Action-</option>
									<option value="8">New Slider</option>
									<option value="9">View Sliders</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="hpanel">
							<div class="panel-body text-center h-200">
								<i class="pe-7s-graph1 fa-4x"></i>

								<h1 class="m-xs"><i class="fa fa-cart-plus"></i></h1>

								<h3 class="font-extra-bold no-margins text-success">
									Subscriptions
								</h3>
								<small>Manage your subscriptions. Renew subscriptions</small>
							</div>
							<div class="panel-footer">
								<select class="form-control" id="subscriptions" onchange="javascript:handleDashboardFunctions('subscriptions')">
									<option>-Select An Action-</option>
									<option value="10">New Subscription</option>
									<option value="11">View Subscriptions</option>
								</select>
							</div>
						</div>
					</div>
						
				</div>
				
			</div>
			
		</div>

	</div>

</div>


<script>



</script>