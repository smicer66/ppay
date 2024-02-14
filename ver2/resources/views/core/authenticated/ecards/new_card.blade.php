

<div aria-hidden="true" class="onboarding-modal modal fade animated" id="new_card_modal" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg modal-centered" role="document">
	<div class="modal-content text-center">
		<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="deviceDetails" class="close-label"></span><span class="os-icon os-icon-close"></span></button>
		<div class="onboarding-side-by-side">
		<div class="onboarding-content with-gradient col-md-12">
			<h4 class="onboarding-title">
			Add New Card To Account - <span class="deviceDetails" id="accountNumber"></span>
			</h4>
			<div class="onboarding-text" style="color: #000 !important;">
				<form action id="newCardForm" data-toggle="validator">
					<div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Account Name: </label><br>
						<div class="deviceDetails" id="newCardAccountName">
						
						</div>
					</div>
					<div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Name On Card: </label><br>
						<div class="deviceDetails" id="cardNameDiv">
							<input class="form-control" id="newCardCardHolder" name="newCardCardHolder" placeholder="Cardholders Name" type="text">
						</div>
					</div>
					<div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Card Type: </label><br>
						<div class="deviceDetails" id="cardTypeDiv">
							<select class="form-control" name="newCardCardType" id="newCardCardType" required>
								@foreach(getAllCardType() as $key => $val)
								<option value="{{$key}}">{{$val}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6 " style="text-align: left !important; float: left !important; padding-top: 20px !important"><label>Card Scheme: </label><br>
						<div class="deviceDetails" id="cardSchemeDiv">
							<select class="form-control" name="newCardCardScheme" id="newCardCardScheme" required>
								@foreach($all_card_schemes  as $val)
								<option value="{{$val->id}}">{{$val->schemeName}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-12" style="text-align: left !important; float: left !important">
						<div class="form-buttons-w text-right">
							<a class="btn btn-primary step-trigger-btn" onclick="addANewCardSubmit('new_card_modal', '{{\Session::get('jwt_token')}}')" style="cursor: pointer !important;"> Continue</a>
							<a class="btn btn-primary step-trigger-btn" id="btn1" style="display: none !important" href="#stepContent2"> Continue</a>
						</div>
					</div>
					<input type="hidden" name="accountIdentifierNewCard" id="accountIdentifierNewCard" value="">
					<input type="hidden" name="acquirerIdNewCard" id="acquirerIdNewCard" value="">
					<input type="hidden" name="currencyCodeNewCard" id="currencyCodeNewCard" value="">
					<input type="hidden" name="customerVerificationNo" id="customerVerificationNo" value="">
					<input type="hidden" name="newCardDeviceCode" id="newCardDeviceCode" value="">
					<input type="hidden" name="newCardMerchantId" id="newCardMerchantId" value="">

				</form>
			</div>
		</div>
		</div> 
	</div>
	</div>
</div>