<div id="cardBalanceWrapper" class="allfloater col col-md-6" style="padding-top:30px;display: none; background: rgba(0,0,0,0.55); top: 0%; position: fixed; z-index:10000; height:100%;width:100%">
	<!--<div id="yourdiv" style="display: inline-block;">You text</div>-->

	<div class="modal-content" class="col col-md-6" style="box-shadow: 0 2px 3px rgba(0,0,0,0.125); position:
absolute; height: 90%; left: 5%;  background-color: transparent; top:5%;opacity: 1 !important;
filter: alpha(opacity=100); width:90%; display:block;">
		<div class="modal-header" style="background-color: #000 !important; color: #fff !important">
			<button type="button" class="close" onclick="javascript:hidenewcard('cardBalanceWrapper')" aria-label="Close">
				<span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="modal-title">Card Balance</h4>
		</div>
		<div class="modal-body" style="background-color: #fff !important; height:80% !important; overflow-y: scroll">
			<!--<form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/new-customer" method="post" enctype="application/x-www-form-urlencoded">-->
			<input type="hidden" name="account" value="" id="account">
			<div id="notifymsg" style="padding:3px;"></div>
			<div class="box-body">
				<h4 class="modal-title" id="modal-title">Card Details</h4>
				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-6 control-label">Customers Name:</label>

					<div class="col-md-6" id="cardBalanceFullname">
						
					</div>
				</div>

				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-6 control-label">Card Number:</label>

					<div class="col-md-6" id="cardBalanceCardNumber">
						
					</div>
				</div>

				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-6 control-label">Card Serial No:</label>

					<div class="col-md-6" id="cardBalanceCardSerialNo">
						
					</div>
				</div>

				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-6 control-label">Type of Card:</label>

					<div class="col-md-6" id="cardBalanceCardType">
						
					</div>
				</div>

				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-6 control-label">Card Scheme:</label>

					<div class="col-md-6" id="cardBalanceCardScheme">
						
					</div>
				</div>

				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-6 control-label">Status of Card:</label>

					<div class="col-md-6" id="cardBalanceStatus">
						
					</div>
				</div>

				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-6 control-label">Account Number:</label>

					<div class="col-md-6" id="cardBalanceAccountNumber">
					
					</div>
				</div>
				<div style="clear: both !important" class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-6 control-label">Current Balance:</label>

					<div class="col-md-6" id="cardCurrentBalanceAmount">
						
					</div>
				</div>
				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-6 control-label">Available Balance:</label>

					<div class="col-md-6" id="cardAvailableBalanceAmount">
						
					</div>
				</div>
					
					
					
				<div class="col-md-12" id="cardbalancefundcarddiv" style="padding:0px !important; display: none !important">
					<div style="clear: both !important; padding:10px">&nbsp;
						<hr style="clear: both !important; margin-top: 0px !important">
					</div>
					<h4 class="modal-title" id="modal-title">Fund Card</h4>
					<div class="form-group  col-md-6">
						<label for="inputEmail3" class="col-sm-6 control-label">Current Account Balance:</label>

						<div class="col-md-6" id="cardAvailableBalanceAccountFloatingBalance">
							
						</div>
					</div>
					
					<div style="clear: both !important;" class="col-md-6" id="cardAvailableBalanceAccountBalance">
						<label for="inputEmail3" class="col-sm-6 control-label">Enter Amount To Credit:</label>

						<div class="col-md-6 pull-right" id="cardAvailableBalanceAccountFloatingBalance">
							<input type="number" name="cardFundAmount" class="form-control pull-right" id="cardFundAmount" value="0.00">
						</div>
						<div class="col-md-6 pull-right" style="clear: both !important;" id="cardAvailableBalanceAccountFloatingBalance">
							<a style="clear: both !important; cursor:hand" class="btn btn-success pull-right" id="refreshCardBalance">Fund Card</a>
						</div>
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<!-- /.box-footer -->

		</div>
		<div class="modal-footer" style="background-color: #000 !important; color: #fff !important">
			<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
			<input type="hidden" name="aid" id="aid" value="">
			<a style="cursor:hand" class="btn btn-primary" id="refreshCardBalance">Refresh Balance</a>
		</div>
	</div>

</div>