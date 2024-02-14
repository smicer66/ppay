
<div aria-hidden="true" class="onboarding-modal modal fade animated" role="dialog" tabindex="-1" id="newSupportWrapper">
    <div class="modal-dialog modal-centered" role="document" style="top: 60px !important; width: 70% !important; max-width: 1000px !important">
        <div class="modal-content text-center">
            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="os-icon os-icon-close " id="dismissBtn"></span></button>
            <table style="width: 100%;">
                <tr>
                    <td style="padding-left: 50px; text-align: right; padding-right: 20px;">
                        <a href="#" style="color: #261D1D; text-decoration: underline; font-size: 14px; letter-spacing: 1px;"></a><a href="#" style="color: #7C2121; text-decoration: underline; font-size: 14px; margin-left: 20px; letter-spacing: 1px;"></a>
                    </td>
                </tr>
            </table><img alt="" src="img/email-header-img.jpg" style="max-width: 100%; height: auto;">

            <div style="padding: 60px 70px;">
                    <h2 style="margin-top: 0px;">
                        New Support Issue
                    </h2>
                    <div style="color: #636363; font-size: 14px;">
                        Provide the details below to create a support issue. The more details provided, the faster the chances of resolving the issue
                    </div>




                    <table style="margin-top: 30px; width: 100%;">
                        

			    <tr id="customerDetailsFoundDiv" style="display: block">
                            <td style="padding-right: 0px;">
					<div class="col-md-6 pull-left">
						<div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
										Date and Estimated Time of Issue:
									</div>

						<div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
								<input type="text" name="transactionDate" id="transactionDate" class="form-control" placeholder="Provide where applicable" required>
									</div>
					</div>
					<div class="col-md-6 pull-right">
									<div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
										Transaction Reference:
									</div>
						<div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
								<input type="text" name="transactionRef" id="transactionRef" class="form-control" placeholder="Provide where applicable">
									</div>
					</div>
					<div class="col-md-6 pull-left">


									<div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
										Transaction Amount:
									</div>

						<div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
								<input type="number" name="transactionAmount" id="transactionAmount" class="form-control" placeholder="Provide where applicable">
									</div>
					</div>
					<div class="col-md-6 pull-right">
						
									<div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
										Bevura App Version:
									</div>

						<div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
								<input type="text" name="appVersion" id="appVersion" class="form-control" placeholder="Provide where applicable">
									</div>
					</div>
					<div class="col-md-6 pull-left">
						
									<div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
										Wallet Number Debited:
									</div>

						<div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
								<input type="text" name="walletNumber" id="walletNumber" class="form-control" placeholder="Provide where applicable">
									</div>
					</div>
					<div class="col-md-6 pull-right">
						
									<div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
										Card Number Debited:
									</div>

						<div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
								<input type="text" name="cardNumber" id="cardNumber" class="form-control" placeholder="Provide where applicable">
									</div>
					</div>
					<div class="col-md-6 pull-left">
						
									<div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
										Customer Number:
									</div>

						<div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
								<input type="text" name="customerNumber" id="customerNumber" class="form-control" placeholder="Provide where applicable">
									</div>
					</div>
					<div class="col-md-12 pull-left">
						
									<div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
										Details:
									</div>

						<div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
								<textarea name="details" id="details" class="form-control" placeholder="Clearly specify what the problem is here" required></textarea>
									</div>
					</div>

                            </td>
                            
                        </tr>
			   
                    </table>
          <div class="form-buttons-w">
		<button class="btn btn-primary" id="changeCardPinButton" style="display: block !important;" type="submit" onclick="submitNewSupportMessage('{{\Session::get('jwt_token')}}', '{{\Auth::user()->token}}', '{{PROBASEWALLET_DEVICE_CODE}}')"> Save Issue </button>

          </div>

            </div>

            
        </div>
    </div>
</div>




