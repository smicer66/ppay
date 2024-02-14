
<div aria-hidden="true" class="onboarding-modal modal fade animated" role="dialog" tabindex="-1" id="issuePhysicalCard">
    <div class="modal-dialog modal-centered" role="document" style="top: 60px !important;">
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
                        Issue Physical Card
                    </h2>
                    <div style="color: #636363; font-size: 14px;">
                        Provide the details below to issue a physical card to a customer
                    </div>




                    <table style="margin-top: 30px; width: 100%;">
                        <tr id="customerAccountNumberDiv" style="">
                            <td style="padding-right: 0px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Customer Account Number:
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="cardAccountNumber" name="cardAccountNumber" placeholder="Card Account Number" type="number">
                                </div>

                            </td>
                            
                        </tr>

			    <tr id="customerDetailsFoundDiv" style="display: none">
                            <td style="padding-right: 0px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Customer Details
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
            				<span id="customerDetailsFound"></div>
                                </div>
					
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Card Scheme
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
            				<select class="form-control" name="cardScheme" id="cardScheme" required>
						@foreach($all_card_schemes  as $val)
						<option value="{{$val->id}}">{{$val->schemeName}}</option>
						@endforeach
					</select>
                                </div>
                            </td>
                            
                        </tr>
                    </table>
          <div class="form-buttons-w">
            <button class="btn btn-primary" id="searchButton" style="" type="submit" onclick="searchForCustomerAccount('{{\Auth::user()->token}}', '{{\Session::get('jwt_token')}}')"> Search For Account Number</button>
		<button class="btn btn-primary" id="assignPhysicalCard" style="display: none !important;" type="submit" onclick="issuePhysicalCardToAccount('{{\Auth::user()->token}}', '{{\Session::get('jwt_token')}}')"> Issue Card To Customer</button>
		<input type="hidden" name="accountIdForCardIssue" id="accountIdForCardIssue" value="">
		<input type="hidden" name="cardBinId" id="cardBinId" value="">

          </div>

            </div>

            
        </div>
    </div>
</div>




