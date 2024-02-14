<?php
$all = \Session::all();
$key = 'login_'.\Auth::user()->id;
$loginData = $all[$key];
$loginData = json_decode($loginData);
$allDistricts = json_decode($loginData->all_districts);
$allCountries = json_decode($loginData->all_countries);

?>


<div aria-hidden="true" class="onboarding-modal modal fade animated" role="dialog" tabindex="-1" id="add_new_collections_account_modal">
    <div class="modal-dialog modal-centered" role="document" style="top: 60px !important; max-width: 60% !important">
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
                        New Collections Account
                    </h2>
                    <div style="color: #636363; font-size: 14px;">
                        Provide the details below to create a new collections account
                    </div>




			<input type="hidden" name="addNewCollectionCustomerId" id="addNewCollectionCustomerId" value="">
                    <table style="margin-top: 30px; width: 100%;">
                        

			    
			    <tr id="">
                            <td style="padding-right: 0px;">
					
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Preferred Currency:
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<select class="form-control" required="required" id="currencyCode" name="currencyCode" data-error="Select the currency for this account">
						<option value>-Select Currency-</option>
                     			@foreach(getAllCurrency() as $sTypeKey => $sType)
                     			<option value="{{$sTypeKey }}">{{$sType}}</option>
                     			@endforeach
               			</select>
                                </div>

                            </td>


                            <td style="padding-right: 0px;">

                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Account Name:
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<input class="form-control" data-minlength="1" id="accountName" name="accountName" placeholder="" required="required" type="text">
                                </div>
                            </td>
                            
                        </tr>
			   
                    </table>
			
          <div class="form-buttons-w">
		<button class="btn btn-primary" id="createCollectionAccountBtn" style="display: block !important;" type="submit" onclick="createNewCollectionCustomerAccount('{{\Auth::user()->token}}', '{{\Session::get('jwt_token')}}', '{{PROBASEWALLET_DEVICE_CODE}}')"> Create Account</button>

          </div>

            </div>

            
        </div>
    </div>
</div>




