<div aria-hidden="true" class="new-account-modal modal fade animated" id="new-account-modal-step-one" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg modal-centered" role="document">
	<div class="modal-content text-center">
		<button aria-label="Close" class="close floatright" data-dismiss="modal" type="button" id="dismissBtn"><span class="deviceDetails" class="close-label"></span><span class="os-icon os-icon-close"></span></button>
		<div class="onboarding-side-by-side">
		<div class="onboarding-content with-gradient col-md-12">
			<h4 class="onboarding-title col-md-12" style="text-align: left !important;">
                <div class="form-group col-md-12" style="text-decoration: underline !important">
			        Step One - Customer Wallet Details
                </div>
			</h4>

			<div class="onboarding-text" style="color: #000 !important; padding-bottom: 20px !important;">
				<form class="form-horizontal" id="new_account_step_1" data-toggle="validator" autocomplete="off" action="/bank-teller/customers/add-new-account" method="post" enctype="application/x-www-form-urlencoded">
                    <input type="hidden" name="addNewAccountCustomerVerificationNumber" id="addNewAccountCustomerVerificationNumber" value="">
                    <input type="hidden" name="addNewAccountMerchantCode" id="addNewAccountMerchantCode" value="">
                    <input type="hidden" name="addNewAccountDeviceCode" id="addNewAccountDeviceCode" value="">
                    <div class="box-body">

                        <div class="form-group  col-md-6 floatleft">
                            <label for="inputEmail3" class="col-sm-12 control-label" style="text-align: left !important;">Customer Full Name<br>
                            </label>

                            <div class="col-sm-9" id="newAccountCustomername" style="text-align: left !important;">

                            </div>
                        </div>

                        <div class="form-group  col-md-6 floatleft">
                            <label for="inputEmail3" class="col-sm-12 control-label" style="text-align: left !important;">Customer Verification Number<br>
                            </label>

                            <div class="col-sm-9" id="newAccountCustomerverficationnumber" style="text-align: left !important;">

                            </div>
                        </div>

                        <div class="form-group  col-md-6 floatleft">
                            <label for="inputEmail3" class="col-sm-12 control-label" style="text-align: left !important;">Account Type</label>

                            <div class="col-sm-9">
                                <select class="form-control" name="accountType" id="accountType" required>
                                    <option>-Select One-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group  col-md-6 floatleft">
                            <label for="inputEmail3" class="col-sm-12 control-label" style="text-align: left !important;">Account Currency</label>

                            <div class="col-sm-9">
                                <select class="form-control" name="accountCurrency" id="accountCurrency" required>
                                    <option>-Select One-</option>
                                </select>
                            </div>
                        </div>
                        @if(isset($userIssuer) && $userIssuer!=null && $userIssuer->holdFundsYes!=null && $userIssuer->holdFundsYes===false)
                        <div class="form-group  col-md-6 floatleft">
                            <label for="inputEmail3" class="col-sm-12 control-label" style="text-align: left !important;">Opening Balance</label>

                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="openingBalance" id="openingBalance" required>
                            </div>
                        </div>
                        @endif

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer col-md-12 " style="clear: both !important">
                        <div class="col-md-12">
                            <a onclick="" class="btn  btn-danger pull-left">Cancel</a>
                            <a onclick="addNewCustomerAccount('{{\Session::get('jwt_token')}}')" class="btn  btn-success pull-right">Next</a>
                        </div>
                        <div class="form-group  col-md-12" style="clear: both !important">
                            &nbsp;
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
			</div>
		</div>
		</div>
	</div>
	</div>
</div>
