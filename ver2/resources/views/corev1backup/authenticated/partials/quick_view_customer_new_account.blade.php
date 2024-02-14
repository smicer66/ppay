<div id="newAccountCustomerAccountWrapper" class="allfloater col col-md-6" style="padding-top:30px;display: none; background: rgba(0,0,0,0.55); top: 0%; position: fixed; z-index:10000; height:100%;width:100%">
	<!--<div id="yourdiv" style="display: inline-block;">You text</div>-->

	<div class="modal-content" class="col col-md-6" style="box-shadow: 0 2px 3px rgba(0,0,0,0.125); position:
absolute; height: 90%; left: 10%;  background-color: transparent; top:5%;opacity: 1 !important;
filter: alpha(opacity=100); width:80%; display:block;">
		<div class="modal-header" style="background-color: #000 !important; color: #fff !important">
			<button type="button" class="close" onclick="javascript:hidenewcard('newAccountCustomerAccountWrapper')" aria-label="Close">
				<span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="modal-title">New Customer Account</h4>
		</div>
		<div class="modal-body" style="background-color: #fff !important; height:80% !important; overflow-y: scroll">
			<!--<form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/new-customer" method="post" enctype="application/x-www-form-urlencoded">-->
			<input type="hidden" name="account" value="" id="account">
			<div id="notifymsg" style="padding:3px;"></div>
			<div class="box-body">
				<label for="inputEmail3" class="col-sm-6 control-label" style="padding-left: 0px !important"><strong>Customer Name:</strong> <div id="newAccountCustomername" class=""></div></label>
				
				<label for="inputEmail3" class="col-sm-6 control-label pull-right" style="text-align:right !important; padding-left: 0px !important"><strong>Customer Verification Number:</strong> <div id="newAccountCustomerverficationnumber" class=""></div></label>
				
				<div class="col-sm-12" style="padding-left: 0px !important">
					<hr>

                    <div class="form-group col-md-5" style="padding-left: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">Account Type:<span style="color:red !important">*</span></label>

                        <div class="col-sm-6">
                            <select class="form-control" name="accountType" id="accountType" required>
                                <option value>-Select One-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-5 pull-right" style="padding-right: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label">Account Currency:<span style="color:red !important">*</span></label>

                        <div class="col-sm-6 pull-right" style="padding-right: 0px !important">
                            <select class="form-control pull-right" name="accountCurrency" id="accountCurrency" required>
                                <option value>-Select One-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-5" style="padding-left: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">Add A Card To Account?<span style="color:red !important">*</span></label>

                        <div class="col-sm-6">
                            <select class="form-control pull-right" name="addCardToAccount" id="addCardToAccount" required>
                                <option value="Yes">Yes</option>
								<option value="No">No</option>
                            </select>
                        </div>
                    </div>
					
					<div class="form-group col-md-5 pull-right" id="nameOnCardDiv" style="padding-right: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label">Name On Card:</label>

                        <div class="col-sm-6 pull-right" style="padding-right: 0px !important">
                            <input type="text" class="form-control pull-right" name="nameOnCard" id="nameOnCard" placeholder="Name on Card">
                        </div>
                    </div>
                    <div class="form-group col-md-5" id="cardTypeDiv" style="padding-left: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">Card Type:</label>

                        <div class="col-sm-6">
                            <select class="form-control" name="cardType" id="cardType">
                                <option>-Select One-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-5 pull-right" id="cardSchemeDiv" style="padding-right: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label">Card Scheme:</label>

                        <div class="col-sm-6 pull-right" style="padding-right: 0px !important">
                            <select class="form-control pull-right" name="cardScheme" id="cardScheme">
                                <option>-Select One-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-5" style="padding-left: 0px !important" id="extraOptionsDiv">
                        <label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">Extra Options:</label>

                        <div class="col-sm-12">
                            <label class="control-sidebar-subheading">
                                &nbsp;&nbsp;Add MasterPass to this account
                                <input type="checkbox" class="pull-left" checked name="addMobileMoney">
                            </label>
                            <label class="control-sidebar-subheading">
                                &nbsp;&nbsp;Add account to customer eWallet
                                <input type="checkbox" class="pull-left" checked name="addEWallet">
                            </label>
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
			<a onclick="javascript:addNewAccount()" style="cursor:hand" class="btn btn-success" id="clickActor">Add Account</a>
		</div>
	</div>

</div>