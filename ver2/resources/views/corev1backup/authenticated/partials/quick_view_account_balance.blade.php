<div id="accountBalanceWrapper" class="allfloater col col-md-6" style="padding-top:30px;display: none; background: rgba(0,0,0,0.55); top: 0%; position: fixed; z-index:10000; height:100%;width:100%">
	<!--<div id="yourdiv" style="display: inline-block;">You text</div>-->

	<div class="modal-content" class="col col-md-6" style="box-shadow: 0 2px 3px rgba(0,0,0,0.125); position:
absolute; height: 90%; left: 5%;  background-color: transparent; top:5%;opacity: 1 !important;
filter: alpha(opacity=100); width:90%; display:block;">
		<div class="modal-header" style="background-color: #000 !important; color: #fff !important">
			<button type="button" class="close" onclick="javascript:hidenewcard('accountBalanceWrapper')" aria-label="Close">
				<span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="modal-title">Account Balance</h4>
		</div>
		<div class="modal-body" style="background-color: #fff !important; height:80% !important; overflow-y: scroll">
			<!--<form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/new-customer" method="post" enctype="application/x-www-form-urlencoded">-->
			<input type="hidden" name="account" value="" id="account">
			<div id="notifymsg" style="padding:3px;"></div>
			<div class="box-body">
				<div class="form-group  col-md-4">
					<label for="inputEmail3" class="col-sm-6 control-label">Full Name:</label>

					<div class="col-md-6" id="accountBalanceFullname">
						
					</div>
				</div>

				<div class="form-group  col-md-4">
					<label for="inputEmail3" class="col-sm-6 control-label">Customer Number:</label>

					<div class="col-md-6" id="accountCustomerVerficationNumber">
						
					</div>
				</div>
				<div class="form-group  col-md-4">
					<label for="inputEmail3" class="col-sm-6 control-label">Account Number:</label>

					<div class="col-md-6" id="accountBalanceAccountNumber">
					
					</div>
				</div>
				<div class="form-group  col-md-4">
					<label for="inputEmail3" class="col-sm-6 control-label">Current Balance:</label>

					<div class="col-md-6" id="accountCurrentBalanceAmount">
						
					</div>
				</div>
				<div class="form-group  col-md-4">
					<label for="inputEmail3" class="col-sm-6 control-label">Available Balance:</label>

					<div class="col-md-6" id="accountAvailableBalanceAmount">
						
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<!-- /.box-footer -->

		</div>
		<div class="modal-footer" style="background-color: #000 !important; color: #fff !important">
			<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
			<input type="hidden" name="aid" id="aid" value="">
			<a style="cursor:hand" class="btn btn-primary" id="refreshAccountBalance">Refresh Balance</a>
		</div>
	</div>

</div>