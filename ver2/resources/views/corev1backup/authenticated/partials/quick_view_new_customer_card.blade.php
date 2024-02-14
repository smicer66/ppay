<div id="customerNewCardWrapper" class="allfloater col col-md-6" style="padding-top:30px;display: none; background: rgba(0,0,0,0.55); top: 0%; position: fixed; z-index:10000; height:100%;width:100%">
	<!--<div id="yourdiv" style="display: inline-block;">You text</div>-->

	<div class="modal-content" class="col col-md-6" style="box-shadow: 0 2px 3px rgba(0,0,0,0.125); position:
absolute; height: 90%; left: 10%;  background-color: transparent; top:5%;opacity: 1 !important;
filter: alpha(opacity=100); width:80%; display:block;">
		<div class="modal-header" style="background-color: #000 !important; color: #fff !important">
			<button type="button" class="close" onclick="javascript:hidenewcard('customerNewCardWrapper')" aria-label="Close">
				<span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="modal-title">New Card</h4>
		</div>
		<div class="modal-body" style="background-color: #fff !important; height:80% !important; overflow-y: scroll">
			<!--<form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/new-customer" method="post" enctype="application/x-www-form-urlencoded">-->
			<input type="hidden" name="account" value="" id="account">
			<div id="notifymsg" style="padding:3px;"></div>
			<div class="box-body">
				<label for="inputEmail3" class="col-sm-6 control-label" style="padding-left: 0px !important"><strong>Customer Name:</strong> <div id="customerNewCardCustomerName" class="" style="font-weight: 100 !important;"></div></label>
				
				<label for="inputEmail3" class="col-sm-6 control-label" style="text-align:right !important; padding-left: 0px !important"><strong>Customer Verification Number:</strong> <div id="customerNewCardCustomerverficationnumber" class="" style="font-weight: 100 !important;"></div></label>
				
				<div class="col-sm-12" style="padding-left: 0px !important">
					<hr>
					<h4 style="font-weight: bold; text-decoration: underline">Provide Card Details</h4>
					
                    <div class="form-group col-md-5" id="customerNewCardAccountDiv" style="padding-left: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">Account:</label>

                        <div class="col-sm-6">
                            <select class="form-control" name="customerNewCardAccount" id="customerNewCardAccount" required>
                                <option>-Select One-</option>
                            </select>
                        </div>
                    </div>
					
                    <div class="form-group col-md-5 pull-right" id="customerNewCardNameOnCardDiv" style="padding-right: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label">Card Type:</label>

                        <div class="col-sm-6" style="padding-right: 0px !important">
                            <select class="form-control pull-right" name="customerNewCardCardType" id="customerNewCardCardType" required>
                                <option>-Select One-</option>
                            </select>
                        </div>
                    </div>
					
					<div class="form-group col-md-5" id="customerNewCardCardTypeDiv" style="padding-left: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">Name On Card:</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="customerNewCardNameOnCard" id="customerNewCardNameOnCard" required placeholder="Name on Card">
                        </div>
                    </div>
					
                    <div class="form-group col-md-5 pull-right" id="customerNewCardNameOnCardDiv" style="padding-right: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label">Card Scheme:</label>

                        <div class="col-sm-6" style="padding-right: 0px !important">
                            <select class="form-control pull-right" name="customerNewCardCardScheme" id="customerNewCardCardScheme" required>
                                <option>-Select One-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-5" style="padding-left: 0px !important" id="customerNewCardExtraOptionsDiv">
                        <label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">Extra Options:</label>

                        <div class="col-sm-12" style="padding-left: 0px !important">
                            <label class="control-sidebar-subheading control-label" id="customerNewCardActivateNewPhysicalCard" style="font-weight: 100 !important; display:none">
                                &nbsp;&nbsp;Activate Card
                                <input type="checkbox" class="pull-left" checked name="customerNewCardActivateNewCard">
                            </label>
                            <label class="control-sidebar-subheading control-label" style="font-weight: 100 !important">
                                &nbsp;&nbsp;Add account to customer eWallet
                                <input type="checkbox" class="pull-left" checked name="customerNewCardAddNewCardToEWallet">
                            </label>
                        </div>
                    </div>
					
					<div class="col-md-12" id="cardfundingfromcustomerdiv" style="padding:0px !important">
						<div style="clear: both !important; padding:10px">&nbsp;
							<hr style="clear: both !important; margin-top: 0px !important">
						</div>
						<h4 style="font-weight: bold; text-decoration: underline; clear: both !important" class="">Fund Card</h4>
						<div class="form-group col-md-5" id="customerNewCardAccountBalanceDiv" style="padding-left: 0px !important">
							<label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">Account Balance:</label>

							<div class="col-sm-6" id="customerNewCardFloatingBalance">
								
							</div>
						</div>
						
						<div class="form-group col-md-5 pull-right" id="customerNewCardEnterAmountDiv" style="padding-right: 0px !important">
							<label for="inputEmail3" class="col-sm-5 control-label">Enter Amount:</label>

							<div class="col-sm-6" style="padding-right: 0px !important">
								<input type="number" class="form-control" name="customerNewCardFundAmount" id="customerNewCardFundAmount" placeholder="Provide Amount">
							</div>
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
			<a style="cursor:hand" class="btn btn-success" id="customerAddNewCardToAccount">Add New Card To Account</a>
		</div>
	</div>

</div>