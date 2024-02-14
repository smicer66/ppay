
<div aria-hidden="true" class="onboarding-modal modal fade animated" role="dialog" tabindex="-1" id="changeCardPinWrapper">
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
                        Change Card Pin
                    </h2>
                    <div style="color: #636363; font-size: 14px;">
                        Provide the details below to issue a physical card to a customer
                    </div>




                    <table style="margin-top: 30px; width: 100%;">
                        

			    <tr id="customerDetailsFoundDiv" style="display: block">
                            <td style="padding-right: 0px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Card Number
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
            				<span id="changeCardPinCardPan"></span>
                                </div>

                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Type Of Card
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
            				<span id="changeCardPinCardType"></span>
                                </div>


                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Card Scheme
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
            				<span id="changeCardPinCardScheme"></span>
                                </div>
					
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Card Serial Number:
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px;">
            				<span id="changeCardPinCardSerialNo"></span>
                                </div>
                            </td>
                            
                        </tr>
			   
                    </table>
          <div class="form-buttons-w">
		<input type="hidden" id="cardTrackingNoCardPin" value="">
		<input type="hidden" id="cardSerialNoCardPin" value="">
		<button class="btn btn-primary" id="changeCardPinButton" style="display: block !important;" type="submit" onclick="changeCardPin('{{\Auth::user()->token}}', '{{\Session::get('jwt_token')}}', '{{PROBASEWALLET_DEVICE_CODE}}')"> Change Card Pin</button>

          </div>

            </div>

            
        </div>
    </div>
</div>




