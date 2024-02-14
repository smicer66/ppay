
<div aria-hidden="true" class="onboarding-modal modal fade animated" role="dialog" tabindex="-1" id="load_pool_account_modal">
    <div class="modal-dialog modal-centered" role="document" style="top: 20px !important;">
        <div class="modal-content text-center">
            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="os-icon os-icon-close"></span></button>
            <table style="width: 100%;">
                <tr>
                    <td style="padding-left: 50px; text-align: right; padding-right: 20px;">
                        <a href="#" style="color: #261D1D; text-decoration: underline; font-size: 14px; letter-spacing: 1px;"></a><a href="#" style="color: #7C2121; text-decoration: underline; font-size: 14px; margin-left: 20px; letter-spacing: 1px;"></a>
                    </td>
                </tr>
            </table><img alt="" src="img/email-header-img.jpg" style="max-width: 100%; height: auto;">

            <div style="padding: 60px 70px;">
                    <h2 style="margin-top: 0px;">
                        Fund A Pool Account
                    </h2>
                    <div style="color: #636363; font-size: 14px;">
                        This should only be done after funds transfered to the pool account has reflected at the bank
                    </div>




                    <table style="margin-top: 30px; width: 100%;">
                        <tr>
                            <td style="padding-right: 0px;">
                                <div style="text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Pool Account:
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            <div class="col-sm-12" style="padding-left: 0px !important;">
              <div class="form-group">
                <select class="form-control" required="required" id="poolAccount" data-error="Select GL Account type">
			<option value>-Select A Pool Account-</option>
                     @foreach($poolAccountList as $poolAccount)
                     	<option value="{{$poolAccount->id}}">{{strtoupper($poolAccount->bankName)}} - {{$poolAccount->accountNumber}}{{$poolAccount->isTrustPoolAccount==true ? ' (Trust Funds)' : ''}}</option>
                    	@endforeach
                </select>
                <div class="help-block form-text with-errors form-control-feedback"></div>
              </div>
            </div>
                                </div>
                                <div style="text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Transaction Reference Number:
                                </div>
                                <div style="font-size: 12px; color: #111; font-weight: bold;">
            <div class="col-sm-12" style="padding-left: 0px !important;">
              <div class="form-group">
                <input class="form-control" id="transactionNumber" data-error="Enter transaction reference number" placeholder="Enter transaction reference number" required="required" type="text">
                <div class="help-block form-text with-errors form-control-feedback"></div>
              </div>
            </div>
                                </div>
                                
				    <div style="text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Amount Funded:
                                </div>
                                <div style="font-size: 12px; color: #111; font-weight: bold;">
            <div class="col-sm-12" style="padding-left: 0px !important;">
              <div class="form-group">
                <input class="form-control" id="amount" data-error="Enter transaction amount" placeholder="Enter transaction amount" required="required" type="number">
                <div class="help-block form-text with-errors form-control-feedback"></div>
              </div>
            </div>
                                </div>

                                <div style="text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Transaction Date:
                                </div>
                                <div style="font-size: 12px; color: #111; font-weight: bold;">
            

		<div class="form-group">
                  <div class="date-input">
                    <input class="single-daterange form-control" id="valueDate" data-error="Enter transaction date" placeholder="Enter transaction date - YYYY-MM-DD" type="text">
                  </div>
                </div>
                                </div>
                            </td>
                            
                        </tr>
                    </table>
          <div class="form-buttons-w">
            <button class="btn btn-primary" type="submit" onclick="submitFundPoolAccountForm('{{\Auth::user()->token}}', '{{\Session::get('jwt_token')}}')"> Fund Pool Account</button>
          </div>

            </div>

            
        </div>
    </div>
</div>




