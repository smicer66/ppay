<?php
$all = \Session::all();
$key = 'login_'.\Auth::user()->id;
$loginData = $all[$key];
$loginData = json_decode($loginData);
$allDistricts = json_decode($loginData->all_districts);
$allCountries = json_decode($loginData->all_countries);

?>


<div aria-hidden="true" class="onboarding-modal modal fade animated" role="dialog" tabindex="-1" id="new_corporate_account_modal">
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




                    <table style="margin-top: 30px; width: 100%;">
                        

			    <tr id="" style="">
                            <td style="padding-right: 0px;" width="50%">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Representative's First Name
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<input class="form-control" data-minlength="1" id="firstName" name="firstName" placeholder="" required="required" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 0px;" width="50%">

                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Representative's Last Name
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<input class="form-control" data-minlength="1" id="lastName" name="lastName" placeholder="" required="required" type="text">
                                </div>

				</td>
			    </tr>
			    <tr id="">
                            <td style="padding-right: 0px;">

                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Representative's Gender
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<select class="form-control" required="required" id="gender" name="gender" data-error="Select the representatives gender">
						<option value>-Select Identification Type-</option>
                     			@foreach(getAllIdentificationType() as $sTypeKey => $sType)
                     			<option value="{{$sTypeKey }}">{{$sType}}</option>
                     			@endforeach
               			</select>
                                </div>

                            </td>
                            <td style="padding-right: 0px;">

                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Representative's Means of Identification Type:
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<select class="form-control" required="required" id="serviceType" name="serviceType" data-error="Select the bank this pool account belongs to">
						<option value>-Select Identification Type-</option>
                     			@foreach(getAllIdentificationType() as $sTypeKey => $sType)
                     			<option value="{{$sTypeKey }}">{{$sType}}</option>
                     			@endforeach
               			</select>
                                </div>

				</td>

			    </tr>
			    <tr id="">
                            <td style="padding-right: 0px;">

                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Representative's Means of Identification Number:
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<input class="form-control" data-minlength="1" id="firstName" name="firstName" placeholder="" required="required" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 0px;">

                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Representative's Contact Number:
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<div style="float: left !important; width: 30% !important">
						<select class="form-control" required="required" id="serviceType" name="serviceType" data-error="Select the bank this pool account belongs to">
							<option value>-Select Intl Code-</option>
                     				@foreach($allCountries as $country)
                     				<option value="{{$country->mobileCode}}">+{{$country->mobileCode}} - {{$country->name}}</option>
                     				@endforeach
               				</select>
					</div>
					<div style="float: left !important; width: 70% !important">
						<input class="form-control" data-minlength="1" id="firstName" name="firstName" placeholder="" required="required" type="text">
					</div>
                                </div>
					
				</td>

			    </tr>
			    <tr id="">
                            <td style="padding-right: 0px;">

                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Representative's Contact Email:
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<input class="form-control" data-minlength="1" id="firstName" name="firstName" placeholder="" required="required" type="text">
                                </div>
					
                            </td>
                            <td style="padding-right: 0px;">

                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Representative's Address Line 1:
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<input class="form-control" data-minlength="1" id="firstName" name="firstName" placeholder="" required="required" type="text">
                                </div>
					
				</td>

			    </tr>




			    <tr id="">
                            <td style="padding-right: 0px;">

                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Representative's Address Line 2:
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<input class="form-control" data-minlength="1" id="firstName" name="firstName" placeholder="" required="required" type="text">
                                </div>
					
                            </td>
                            <td style="padding-right: 0px;">

                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Representative's District:
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<select class="form-control" required="required" id="serviceType" name="serviceType" data-error="Select the bank this pool account belongs to">
						<option value>-Select Currency-</option>
                     			@foreach($allDistricts as $district)
                     			<option value="{{$district->id}}">{{$district->name}}</option>
                     			@endforeach
               			</select>
                                </div>

				</td>

			    </tr>
			    <tr id="">
                            <td style="padding-right: 0px;">
					
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Preferred Currency:
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<select class="form-control" required="required" id="serviceType" name="serviceType" data-error="Select the bank this pool account belongs to">
						<option value>-Select Currency-</option>
                     			@foreach(getAllCurrency() as $sTypeKey => $sType)
                     			<option value="{{$sTypeKey }}">{{$sType}}</option>
                     			@endforeach
               			</select>
                                </div>

                            </td>


                            <td style="padding-right: 0px;">

                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Preferred Currency:
                                </div>
				    <div style="text-align: left !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 50%">
            				<input class="form-control" data-minlength="1" id="firstName" name="firstName" placeholder="" required="required" type="text">
                                </div>
                            </td>
                            
                        </tr>
			   
                    </table>
          <div class="form-buttons-w">
		<button class="btn btn-primary" id="createCollectionAccountBtn" style="display: block !important;" type="submit" onclick="createCollectionAccount('{{\Auth::user()->token}}', '{{\Session::get('jwt_token')}}', '{{PROBASEWALLET_DEVICE_CODE}}')"> Create Account</button>

          </div>

            </div>

            
        </div>
    </div>
</div>




