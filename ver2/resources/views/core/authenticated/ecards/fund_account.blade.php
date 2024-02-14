@if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
<div aria-hidden="true" class="onboarding-modal modal fade animated" id="fund_account_modal" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg modal-centered" role="document">
	<div class="modal-content text-center">
		<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="deviceDetails" class="close-label"></span><span class="os-icon os-icon-close"></span></button>
		<div class="onboarding-side-by-side">
		<div class="onboarding-content with-gradient col-md-12">
			<h4 class="onboarding-title">
			    Fund Account - <span class="deviceDetails" id="fundAccountAccountNumber"></span>
			</h4>
			<div class="onboarding-text" style="color: #000 !important;">
				<form action id="fundAccountForm" data-toggle="validator">
					<div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Account Name: </label><br>
                        <span id="fundAccountAccountName"></span>
					</div>
                    <div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Receipt Number: </label><br>
                        <input type="text" class="form-control" id="banktransactionid" placeholder="Receipt Number" required>
                    </div>
                    <div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Amount Paid: </label><br>
                        <input type="number" class="form-control" id="amountPaid" placeholder="Amount Paid" required>
                    </div>
					<div class="col-md-12" style="text-align: left !important; float: left !important">
						<div class="form-buttons-w text-right">
							<a class="btn btn-primary step-trigger-btn" onclick="handleFundAccount('{{\Auth::user()->token}}', '{{\Session::get('jwt_token')}}')" style="cursor: pointer !important;"> Fund Account</a>
							<a class="btn btn-danger step-trigger-btn" id="btn1" style="display: none !important" href="#stepContent2"> Cancel</a>
						</div>
					</div>
                    <input type="hidden" id="fundAccountAccountId" value="" name="fundAccountAccountId">
				</form>
			</div>
		</div>
		</div>
	</div>
	</div>
</div>
@endif
